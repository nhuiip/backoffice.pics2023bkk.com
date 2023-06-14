@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    {{ Form::open(['novalidate', 'route' => 'programs-attachment.store', 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'post', 'files' => true]) }}
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <div class="col-10">
                        {{ Form::hidden('programId', $program->id) }}
                        {{ Form::file('file[]', ['class' => 'form-control', 'multiple']) }}
                        @error('file[]')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success w-100" type="submit" value="save">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-10">
                </div>
                <div class="col-2">
                    @include('layouts.components.input-query')
                </div>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" id="programId" value="{{ $program->id }}">
            <table id="dataTable" class="table-border-vertical table-hover"
                data-url="{{ route('programs-attachment.jsontable') }}">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>File</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr></tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        let dataTable = $('#dataTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
            dom: 'rtip',
            ajax: {
                url: $('#dataTable').attr('data-url'),
                type: "GET",
                data: function(d) {
                    d.programId = $('#programId').val();
                },
            },
            columnDefs: [{
                    targets: [0],
                    width: '10%'
                },
                {
                    targets: [1],
                },
                {
                    targets: [2, 3],
                    width: '10%',
                },
                {
                    targets: [4],
                    width: '5%',
                    className: 'text-center',
                    orderable: false
                }
            ],
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
                },
                {
                    data: 'action'
                }
            ]
        });
    </script>
@endsection
