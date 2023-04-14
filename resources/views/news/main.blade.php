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
                    @include('layouts.components.buttons.create', ['url' => route('news.create')])
                </div>
                <div class="col-2">
                    @include('layouts.components.input-query')
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table-border-vertical table-hover" data-url="{{ route('news.jsontable') }}">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Announcement</th>
                        <th>Visit</th>
                        <th>Favorite</th>
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
                    targets: [1],
                    orderable: false
                },
                {
                    targets: [2],
                    width: '5%',
                    className: 'text-end',
                    orderable: false
                },
                {
                    targets: [3, 4],
                    className: 'text-end',
                    width: '5%',
                },
                {
                    targets: [5, 6],
                    width: '10%',
                    orderable: false
                },
                {
                    targets: [7],
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
                    data: 'is_announcement'
                },
                {
                    data: 'visit'
                },
                {
                    data: 'favorite'
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
