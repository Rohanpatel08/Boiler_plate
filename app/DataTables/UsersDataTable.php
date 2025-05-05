<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<a href="' . route('test.edit', $row->id) . '" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>';
                $delete = '<form action="' . route('test.destroy', $row->id) . '" method="POST" style="display:inline">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this user?\')"><i class="fa fa-trash"></i></button>
                </form>';
                return $edit . ' ' . $delete;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y h:i A');
            })
            ->editColumn('updated_at', function ($row) {
                return $row->updated_at->format('d-m-Y h:i A');
            })
            ->editColumn('profile', function ($row) {
                return $row->profile 
                ? '<img src="' . asset('storage/' . $row->profile) . '" alt="Profile Image" width="50" height="50">' 
                : '';
            })
            ->rawColumns(['profile', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->lengthMenu([[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']])
            ->addTableClass('table-bordered table-hover gy-5 gs-7  w-100 datatable');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title('Sr.')->searchable(false)->orderable(false),
            Column::make('id')->visible(false),
            Column::make('name'),
            Column::make('email'),
            Column::make('age'),
            Column::make('gender'),
            Column::make('profile'),
            Column::make('action')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
