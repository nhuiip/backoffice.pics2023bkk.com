@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    <div class="card">
        <div class="card-header pb-0">
            <div class="row justify-content-end">
                <div class="col-md-2">
                    <select name="country" id="country" class="form-control select2" onchange="loadDataTable(this)">
                        <option value="">Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->country }}">{{ $country->country }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="registrant_group" id="registrant_group" class="form-control select2"
                        onchange="loadDataTable(this)">
                        <option value="">Registrant Group</option>
                        @foreach ($registrant_groups as $registrant_group)
                            <option value="{{ $registrant_group->registrant_group }}">
                                {{ $registrant_group->registrant_group }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="registrant_group" id="registrant_group" class="form-control select2"
                        onchange="loadDataTable(this)">
                        <option value="">Registrant Group</option>
                        @foreach ($registrant_groups as $registrant_group)
                            <option value="{{ $registrant_group->registrant_group }}">
                                {{ $registrant_group->registrant_group }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_method" id="payment_method" class="form-control select2"
                        onchange="loadDataTable(this)">
                        <option value="">Payment</option>
                        <option value="1">Credit Card</option>
                        <option value="2">Bank Transfer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="payment_status" id="payment_status" class="form-control select2"
                        onchange="loadDataTable(this)">
                        <option value="">Payment Status</option>
                        <option value="1">Pending</option>
                        <option value="2">Paid</option>
                        <option value="3">Cancelled</option>
                    </select>
                </div>
                <div class="col-2">
                    @include('layouts.components.input-query')
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table-border-vertical table-hover" data-url="{{ route('members.jsontable') }}">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        {{-- <th>Country</th>
                        <th>Organization</th>
                        <th>Registration</th> --}}
                        <th>Fee</th>
                        <th>Payment</th>
                        <th>Payment Status</th>
                        <th>Created</th>
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
    <script src="{{ asset('js/select2/select2.min.js') }}"></script>
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
                    d.country = $('#country').val()
                    d.organization = $('#organization').val()
                    d.registrant_group = $('#registrant_group').val()
                    d.registration_type = $('#registration_type').val()
                    d.payment_method = $('#payment_method').val()
                    d.payment_status = $('#payment_status').val()
                },
            },
            columnDefs: [{
                    targets: [0, 1, 2, ],
                    orderable: false
                },
                {
                    targets: [3],
                    width: '5%',
                    className: 'text-end',
                    orderable: false
                },
                {
                    targets: [4, 5],
                    width: '5%',
                    className: 'text-center',
                    orderable: false
                },
                {
                    targets: [6],
                    width: '5%',
                    orderable: false
                },
                {
                    targets: [7],
                    width: '10%',
                    className: 'text-center',
                    orderable: false
                }
            ],
            columns: [{
                    data: 'reference'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                // {
                //     data: 'country'
                // },
                // {
                //     data: 'organization'
                // },
                // {
                //     data: 'registration'
                // },
                {
                    data: 'total'
                },
                {
                    data: 'payment_method'
                },
                {
                    data: 'payment_status'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'action'
                }
            ]
        });

        function loadDataTable() {
            dataTable.ajax.reload(null, false);
        }

        function fncStatus(e) {
            let url = $(e).attr('data-url');
            let status = $(e).attr('data-status');
            let text = $(e).attr('data-text');

            let popup = new swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: {
                    cancel: true,
                    confirm: {
                        text: text,
                        className: 'btn-info'
                    },
                },
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        type: "PUT",
                        data: {
                            // _token: "{{ csrf_token() }}",
                            payment_status: status
                        },
                        success: function(data) {
                            if (data) {
                                swal({
                                    title: "Success!",
                                    text: "Update Status Success",
                                    icon: "success",
                                    button: false,
                                    timer: 2000
                                }).then(function() {
                                    dataTable.ajax.reload(null, false);
                                });
                            } else {
                                swal({
                                    title: "Error!",
                                    text: "Update Status Error",
                                    icon: "error",
                                    button: false,
                                    timer: 2000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            swal({
                                title: "Error!",
                                text: xhr.responseText,
                                icon: "error",
                                button: false,
                                timer: 2000
                            });
                        }
                    });
                } else {
                    swal.close();
                }
            });
            return popup;
        }


        function fncSendEmail(e) {
            let url = $(e).attr('data-url');
            let type = $(e).attr('data-type');
            let text = $(e).attr('data-text');
            let id = $(e).attr('data-id');

            let popup = new swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: {
                    cancel: true,
                    confirm: {
                        text: text,
                        className: 'btn-info'
                    },
                },
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            id: Number(id),
                            type: type
                        },
                        success: function(data) {
                            if (data) {
                                swal({
                                    title: "Success!",
                                    text: "Update Status Success",
                                    icon: "success",
                                    button: false,
                                    timer: 2000
                                }).then(function() {
                                    dataTable.ajax.reload(null, false);
                                });
                            } else {
                                swal({
                                    title: "Error!",
                                    text: "Update Status Error",
                                    icon: "error",
                                    button: false,
                                    timer: 2000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            swal({
                                title: "Error!",
                                text: xhr.responseText,
                                icon: "error",
                                button: false,
                                timer: 2000
                            });
                        }
                    });
                } else {
                    swal.close();
                }
            });
            return popup;
        }
    </script>
@endsection
