<?php

namespace App\Services;

use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;

class CrudService {

    use ApiResponse;

    public function store($request){
        $data = $request->except('password_confirmation');
        
        // Handle Profile Upload
        if ($request->hasFile('profile') && $request->file('profile')->isValid()) {
            $filename =  time() . '.' . $request->file('profile')->getClientOriginalExtension();
            $data['profile'] = $request->file('profile')->storeAs('profiles', $filename, 'public');
        }
    
        return User::create($data);
    }

    public function edit($id){
        return User::findorFail($id);
    }

    public function update($request, $id){
        $user = User::findorFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->age = $request->age;
        $user->gender = $request->gender;
        
        // Handle Profile Upload
        if ($request->hasFile('profile')) {
            // Delete old image if exists
            if ($user->profile && Storage::disk('public')->exists($user->profile)) {
                Storage::disk('public')->delete($user->profile);
            }
            $filename =  time() . '.' . $request->file('profile')->getClientOriginalExtension();
            $path = $request->file('profile')->storeAs('profiles', $filename, 'public');
            $user->profile = $path;
        }
        $data = $user->toArray();
        $user->update($data);
        return $user;
    }

    public function destroy($id){
        $user = User::findorFail($id);
        if ($user->profile && Storage::disk('public')->exists($user->profile)) {
            Storage::disk('public')->delete($user->profile);
        }
        $user->delete();
        return $user;
    }
}