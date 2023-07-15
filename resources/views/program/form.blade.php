@extends('layouts.app')
@section('title', $title)
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendors/timepicker.css') }}">
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <style>
        .input-group .btn {
            color: #1e2125;
            padding: 0;
        }

        .input-group .btn:hover {
            background-color: transparent !important;
            border-color: #1e2125 !important;
        }

        /* 1e2125 */
    </style>
@endsection
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    @if (empty($data))
        {{ Form::open(['novalidate', 'route' => 'programs.store', 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'post', 'files' => true]) }}
    @else
        {{ Form::model($data, ['novalidate', 'route' => ['programs.update', $data->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    @endif
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                            {{ Form::checkbox('is_highlight', true, null, ['class' => 'form-check-input', 'id' => 'inline-1']) }}
                            <label class="form-check-label" for="inline-1">Check for Highlight</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label"><span class="text-danger">*</span> Name</label>
                        {{ Form::text('name', old('name'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter name']) }}
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label"><span class="text-danger">*</span> Room</label>
                        {{ Form::text('room', old('room'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter room']) }}
                        @error('room')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <label class="form-label"><span class="text-danger">*</span> Date</label>
                        @if (empty($data))
                            {{ Form::text('date', old('date'), ['class' => 'datepicker form-control', 'required', 'placeholder' => 'Enter date']) }}
                        @else
                            {{ Form::text('date', date('Y-m-d', strtotime($data->date)), ['class' => 'datepicker form-control', 'required', 'placeholder' => 'Enter date']) }}
                        @endif
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label class="form-label"><span class="text-danger">*</span> Start time</label>
                        @if (empty($data))
                            {{ Form::text('startTime', old('startTime'), ['class' => 'form-control clockpicker', 'required', 'placeholder' => 'Enter time']) }}
                        @else
                            {{ Form::text('startTime', date('h:i', strtotime($data->startTime)), ['class' => 'form-control clockpicker', 'required', 'placeholder' => 'Enter time']) }}
                        @endif
                        @error('startTime')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label class="form-label"><span class="text-danger">*</span> End time</label>
                        @if (empty($data))
                            {{ Form::text('endTime', old('endTime'), ['class' => 'form-control clockpicker', 'required', 'placeholder' => 'Enter time']) }}
                        @else
                            {{ Form::text('endTime', date('h:i', strtotime($data->endTime)), ['class' => 'form-control clockpicker', 'required', 'placeholder' => 'Enter time']) }}
                        @endif
                        @error('endTime')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label"><span class="text-danger">*</span> Content</label>
                        {!! Form::textarea('content', null, ['id' => 'content', 'cols' => '10', 'rows' => '2']) !!}
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-6">
                    @include('layouts.components.buttons.back', [
                        'url' => $breadcrumbs[count($breadcrumbs) - 2]['route'],
                    ])
                    @include('layouts.components.buttons.reset')
                </div>
                <div class="col-6">
                    @include('layouts.components.buttons.save', ['value' => 'save'])
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('script')
    <script src="{{ asset('js/time-picker/jquery-clockpicker.min.js') }}"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <script>
        $('.clockpicker').clockpicker();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            uiLibrary: 'bootstrap5'
        });
    </script>
    <script src="{{ asset('js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('js/email-app.js') }}"></script>
@endsection
