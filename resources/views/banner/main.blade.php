@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-10">
                    @include('layouts.components.buttons.create', ['url' => route('banners.create')])
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table-border-vertical table-hover" data-url="{{ route('banners.jsontable') }}">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Seq</th>
                        <th>Type</th>
                        <th>Url</th>
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
                    d.role = $('#role').val();
                },
            },
            columnDefs: [{
                    targets: [0],
                    width: '10%'
                },
                {
                    targets: [1,2],
                    width: '5%'
                },
                {
                    targets: [3],
                    orderable: false
                },
                {
                    targets: [4,5],
                    width: '15%',
                    orderable: false
                },
                {
                    targets: [6],
                    width: '5%',
                    className: 'text-center',
                    orderable: false
                }
            ],
            columns: [{
                    data: 'id'
                },
                {
                    data: 'seq'
                },
                {
                    data: 'type'
                },
                {
                    data: 'url'
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
