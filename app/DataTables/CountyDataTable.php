<?php

namespace App\DataTables;

use App\County;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

class CountyDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function ajax()
    {
        return DataTables::of($this->query())
            ->editColumn('action', function (County $county) {
                return '<button class="btn btn-primary btn-xs tooltips" title="Edit"
                data-edit-form="#editForm"
                data-edit-action="'.route('counties.edit', [$county->id], false).'"><i
                    class="fa fa-fw fa-pencil"></i></button>
        <button class="btn btn-danger btn-xs tooltips" title="Delete"
                data-edit-form="#delForm" data-edit-id="'.$county->id.'"><i
                    class="fa fa-fw fa-trash"></i></button>';
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $counties = County::with('state');

        return $this->applyScopes($counties);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns([
                'counties.id' => ['title' => '#', 'data' => 'id', 'searchable' => false],
                'counties.name' => ['title' => 'Name', 'data' => 'name', 'class'=>'dt_searchable'],
                'state.name' => ['title' => 'State', 'data' => 'state.name', 'class'=>'dt_searchable'],
                'counties.tax_rate' => ['title' => 'Tax Rate', 'data' => 'tax_rate', 'class'=>'dt_searchable'],
                'counties.collected_taxes' => ['title' => 'Collected Taxes', 'data' => 'collected_taxes', 'class'=>'dt_searchable'],
                'action' => ['title' => '', 'orderable' => false, 'searchable' => false]
            ])
            ->parameters([
                'responsive' => true,
                'dom' => 'Blfrtip',
                'sorting' => [[0, 'desc']],
                'initComplete' => 'function() {
    var input = $(".dataTables_filter input").unbind(),
        self = this.api(),
        searchButton = $("<button class=\'btn tooltips\' title=\'Search\'><i class=\'fa fa-search fa-lg\'></i></button>")
            .click(function() {
                self.search(input.val()).draw();
            }),
        clearButton = $("<button class=\'btn\'><i class=\'fa fa-remove fa-lg\'></i></button>")
            .click(function() {
                input.val("");
                searchButton.click();
            });
    input.keyup(function(e) {
        if (e.keyCode === 13)
            searchButton.click();
    });
    $(".dataTables_filter > label").append(searchButton, clearButton);
}'
            ]);
    }
}
