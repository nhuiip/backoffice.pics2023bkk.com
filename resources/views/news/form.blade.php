@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    @if (empty($data))
        {{ Form::open(['novalidate', 'route' => 'news.store', 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'post', 'files' => true]) }}
    @else
        {{ Form::model($data, ['novalidate', 'route' => ['news.update', $data->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    @endif
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-check form-check-inline checkbox checkbox-dark mb-0">
                            {{ Form::checkbox('is_announcement', true, null, ['class' => 'form-check-input', 'id' => 'inline-1']) }}
                            <label class="form-check-label" for="inline-1">Check for Announcement</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">
                            @if (empty($data))
                            <span class="text-danger">*</span>
                            @endif
                            Image
                            @if (!empty($data))
                                <a href="{{ $data->image_url }}" target="_blank" rel="noopener noreferrer"><i
                                        class="text-danger"><u>view old image</u></i></a>
                            @endif
                        </label>
                        {{ Form::file('image', ['class' => 'form-control', 'accept' => 'image/*']) }}
                        @error('image')
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
                    @if (Route::Is('users.resetpassword'))
                        @include('layouts.components.buttons.save', ['value' => 'resetpassword'])
                    @else
                        @include('layouts.components.buttons.save', ['value' => 'save'])
                    @endif
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
