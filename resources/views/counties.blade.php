@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="box box-info">
                <header class="box-header with-border">
                    <h3 class="box-title">New County</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </header>
                <div class="box-body">
                    <form id="createForm" class="form-horizontal" action="{{ route('counties.store') }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Name :</label>
                                            <div class="col-lg-8">
                                                <input name="name" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">State :</label>
                                            <div class="col-lg-8">
                                                <select name="state_id" class="form-control">
                                                    @foreach($states as $state)
                                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Tax Rate :</label>
                                            <div class="col-lg-8">
                                                <input name="tax_rate" type="number" class="form-control" min="0" max="99.99">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-4 control-label">Collected Taxes :</label>
                                            <div class="col-lg-8">
                                                <input name="collected_taxes" type="number" class="form-control" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-plus-square"></i> Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <div class="col-lg-12">
            <section class="box box-info">
                <header class="box-header with-border">
                    <h3 class="box-title">Counties List</h3>
                </header>
                <div class="box-body">
                    {!! $dataTable->table(['class' => 'table table-bordered table-striped table-advance table-hover', 'width' => '100%']) !!}
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit County</h4>
                </div>
                <div class="modal-body">
                    <form id="editForm" class="form-horizontal" action="{{ route('counties.update', ['']) }}" method="post">
                        @csrf
                        {{ method_field('put') }}

                        <input type="hidden" name="id">

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Name :</label>
                                    <div class="col-lg-8">
                                        <input name="name" type="text" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-4 control-label">State :</label>
                                    <div class="col-lg-8">
                                        <select name="state_id" class="form-control">
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Tax Rate :</label>
                                    <div class="col-lg-8">
                                        <input name="tax_rate" type="number" class="form-control" value="" min="0" max="99.99">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Collected Taxes :</label>
                                    <div class="col-lg-8">
                                        <input name="collected_taxes" type="number" class="form-control" value="" min="0">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Back</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete County</h4>
                </div>
                <form id="delForm" class="form-horizontal" action="{{ route('counties.destroy', ['']) }}" method="post">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('delete') }}
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label class="col-lg-12">
                                <strong style="color:#ec6459">Warning!</strong>
                                Are you sure?
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('script')
    <script>
        var editForm = $('#editForm'),
            delForm = $('#delForm'),
            createForm = $('#createForm');
        $(function () {
            createForm.ajaxForm({
                reset: true,
                callback: function () {
                    window.LaravelDataTables["dataTableBuilder"].draw(false);
                }
            });

            editForm.ajaxForm({
                progressBar: 'primary',
                callback: function () {
                    window.LaravelDataTables["dataTableBuilder"].draw(false);
                }
            });

            delForm.ajaxForm({
                progressBar: 'danger',
                closeModal: true,
                callback: function () {
                    window.LaravelDataTables["dataTableBuilder"].draw(false);
                }
            });
        });
    </script>

    {!! $dataTable->scripts() !!}
@endsection
