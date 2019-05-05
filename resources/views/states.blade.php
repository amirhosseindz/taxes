@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <section class="box box-info">
                <header class="box-header with-border">
                    <h3 class="box-title">New State</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </header>
                <div class="box-body">
                    <form id="createForm" class="form-horizontal" action="{{ route('states.store') }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Name :</label>
                                            <div class="col-lg-10">
                                                <input name="name" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="col-lg-offset-1 col-lg-11">
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
                    <h3 class="box-title">States List</h3>
                </header>
                <div class="box-body">
                    <table id="statesList" class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if( ! $states->count())
                            <tr class="empty">
                                <td colspan="3">
                                    <p>There is no state. Please create one.</p>
                                </td>
                            </tr>
                        @else
                            @foreach($states as $state)
                                @include('partials.state-tr')
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Edit State</h4>
                </div>
                <div class="modal-body">
                    <form id="editForm" class="form-horizontal" action="{{ route('states.update', ['']) }}" method="post">
                        @csrf
                        {{ method_field('put') }}

                        <input type="hidden" name="id">

                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Name :</label>
                                    <div class="col-lg-9">
                                        <input name="name" type="text" class="form-control" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-9 col-md-offset-3">
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
                    <h4 class="modal-title">Delete State</h4>
                </div>
                <form id="delForm" class="form-horizontal" action="{{ route('states.destroy', ['']) }}" method="post">
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
                callback: redrawList,
                callbackParams: {form: createForm, action: 'create'}
            });

            editForm.ajaxForm({
                progressBar: 'primary',
                callback: redrawList,
                callbackParams: {form: editForm, action: 'update'}
            });

            delForm.ajaxForm({
                progressBar: 'danger',
                closeModal: true,
                callback: redrawList,
                callbackParams: {form: delForm, action: 'delete'}
            });
        });

        function redrawList(params) {
            var id, table = $('#statesList tbody');
            if (params.action != 'create') {
                id = params.form.find('input[name="id"]').val();
                var tr = table.find('tr[data-id="' + id + '"]');
            }
            switch (params.action) {
                case 'create':
                    var emptyTr = table.find('tr.empty');
                    if (emptyTr.length) {
                        emptyTr.fadeOut(400, function () {
                            $(this).remove();
                        });
                    }
                    table.prepend(params.tr);
                    break;
                case 'update':
                    tr.replaceWith(params.tr);
                    break;
                case 'delete':
                    tr.fadeOut(400, function () {
                        $(this).remove();
                    });
                    break;
            }
        }
    </script>
@endsection
