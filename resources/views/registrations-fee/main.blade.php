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
                    @include('layouts.components.buttons.create', ['url' => route('registrations-fee.create', ['registrantGroupId' => $registration->id])])
                </div>
                <div class="col-2">
                    @include('layouts.components.input-query')
                </div>
            </div>
        </div>
        <div class="card-body">
            <input type="hidden" id="registrantGroupId" value="{{ $registration->id }}">
            <table id="dataTable" class="table-border-vertical table-hover"
                data-url="{{ route('registrations-fee.jsontable') }}">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Rate</th>
                        <th>Type</th>
                        <th>Price (USD)</th>
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
                    d.registrantGroupId = $('#registrantGroupId').val();
                },
            },
            columnDefs: [{
                    targets: [0],
                    width: '10%'
                },
                {
                    targets: [1, 2],
                },
                {
                    targets: [3],
                    width: '10%',
                    className: 'text-end',
                },
                {
                    targets: [4, 5],
                    width: '10%',
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
                    data: 'registrationRateId'
                },
                {
                    data: 'registrantTypeId'
                },
                {
                    data: 'price'
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
