@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    @if (empty($data))
        {{ Form::open(['novalidate', 'route' => 'hotels.store', 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'post', 'files' => true]) }}
    @else
        {{ Form::model($data, ['novalidate', 'route' => ['hotels.update', $data->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    @endif
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <p class="sub-title">Information</p>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <label class="form-label"><span class="text-danger">*</span> Seq</label>
                    @if (empty($data))
                        {{ Form::number('seq', $nextSeq, ['class' => 'form-control', 'required', 'placeholder' => 'Enter seq']) }}
                    @else
                        {{ Form::number('seq', old('seq'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter seq']) }}
                    @endif
                    @error('seq')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-3">
                    <label class="form-label"><span class="text-danger">*</span> Rangting</label>
                    {{ Form::number('ranging', old('ranging'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter ranging', 'min' => 1, 'max' => 5]) }}
                    @error('ranging')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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
                    <label class="form-label"><span class="text-danger">*</span> Description</label>
                    {{ Form::text('description', old('description'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter description']) }}
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                    <label class="form-label"><span class="text-danger">*</span> Tel</label>
                    {{ Form::number('tel', old('tel'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter tel']) }}
                    @error('tel')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-3">
                    <label class="form-label"><span class="text-danger">*</span> Email</label>
                    {{ Form::text('email', old('email'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter email']) }}
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label class="form-label"><span class="text-danger">*</span> Address</label>
                    {{ Form::text('address', old('address'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter address']) }}
                    @error('address')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label"><span class="text-danger">*</span> Room Rate</label>
                    {{ Form::text('roomrate', old('roomrate'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter roomrate']) }}
                    @error('roomrate')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-6">
                    <label class="form-label"><span class="text-danger">*</span> Google Map</label>
                    {{ Form::text('google_map', old('google_map'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter google_map']) }}
                    @error('google_map')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label"><span class="text-danger">*</span> Remark</label>
                    {{ Form::text('description', old('podescriptionsition'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter description']) }}
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <p class="sub-title">Content</p>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    {!! Form::textarea('content', null, ['id' => 'content', 'cols' => '10', 'rows' => '2']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
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
    <script src="{{ asset('js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/editor/ckeditor/adapters/jquery.js') }}"></script>
    <script src="{{ asset('js/email-app.js') }}"></script>
@endsection
