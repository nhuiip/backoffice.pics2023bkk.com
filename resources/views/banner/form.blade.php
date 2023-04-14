@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    @if (empty($data))
        {{ Form::open(['novalidate', 'route' => 'banners.store', 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'post', 'files' => true]) }}
    @else
        {{ Form::model($data, ['novalidate', 'route' => ['banners.update', $data->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    @endif
    <div class="card">
        <div class="card-body">
            <div class="form-group">
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
                        <label class="form-label">Type</label>
                        {{ Form::select('type', $type, old('type'), ['class' => 'form-select', 'required']) }}
                        @error('type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">
                            Image
                            @if (!empty($data))
                                <a href="{{ $data->url }}" target="_blank" rel="noopener noreferrer"><i
                                        class="text-danger"><u>view old image</u></i></a>
                            @endif
                        </label>
                        {{ Form::file('image', ['class' => 'form-control', 'accept' => 'image/*']) }}
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Url Youtube</label>
                        @if (empty($data))
                            {{ Form::text('url', old('url'), ['class' => 'form-control', 'placeholder' => 'Enter url']) }}
                        @else
                            @if ($data->type == 1)
                                {{ Form::text('url', '', ['class' => 'form-control', 'placeholder' => 'Enter url']) }}
                            @else
                                {{ Form::text('url', old('url'), ['class' => 'form-control', 'placeholder' => 'Enter url']) }}
                            @endif
                        @endif
                        @error('url')
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
