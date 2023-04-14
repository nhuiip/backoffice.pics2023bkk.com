@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    {{ Form::model($data, ['novalidate', 'route' => ['settings.update', $data->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    <div class="card">
        {!! Form::hidden('key', null) !!}
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <p class="sub-title">Social media</p>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label"><span class="text-danger">*</span> Facebook</label>
                        {{ Form::text('facebook', $facebook->value, ['class' => 'form-control', 'required', 'placeholder' => 'Enter facebook']) }}
                    </div>
                    <div class="col-6">
                        <label class="form-label"><span class="text-danger">*</span> Twitter</label>
                        {{ Form::text('twitter', $twitter->value, ['class' => 'form-control', 'required', 'placeholder' => 'Enter twitter']) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label"><span class="text-danger">*</span> Line</label>
                        {{ Form::text('line', $line->value, ['class' => 'form-control', 'required', 'placeholder' => 'Enter line']) }}
                    </div>
                    <div class="col-6">
                        <label class="form-label"><span class="text-danger">*</span> Youtube</label>
                        {{ Form::text('youtube', $youtube->value, ['class' => 'form-control', 'required', 'placeholder' => 'Enter youtube']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12">
                    @include('layouts.components.buttons.save', ['value' => 'social'])
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    {{ Form::model($quote, ['novalidate', 'route' => ['settings.update', $quote->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    <div class="card">
        {!! Form::hidden('key', null) !!}
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <p class="sub-title">Quote from the host</p>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        {!! Form::textarea('value', null, ['id' => 'config_quote', 'cols' => '10', 'rows' => '2']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12">
                    @include('layouts.components.buttons.save', ['value' => 'save'])
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    {{ Form::model($aboutus, ['novalidate', 'route' => ['settings.update', $aboutus->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    <div class="card">
        {!! Form::hidden('key', null) !!}
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <p class="sub-title">About Us</p>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        {!! Form::textarea('value', null, ['id' => 'config_aboutus', 'cols' => '10', 'rows' => '2']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-12">
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
    <script>
        CKEDITOR.replace('config_quote', {
            on: {
                contentDom: function(evt) {
                    // Allow custom context menu only with table elemnts.
                    evt.editor.editable().on('contextmenu', function(contextEvent) {
                        var path = evt.editor.elementPath();

                        if (!path.contains('table')) {
                            contextEvent.cancel();
                        }
                    }, null, null, 5);
                }
            }
        });
        CKEDITOR.replace('config_aboutus', {
            on: {
                contentDom: function(evt) {
                    // Allow custom context menu only with table elemnts.
                    evt.editor.editable().on('contextmenu', function(contextEvent) {
                        var path = evt.editor.elementPath();

                        if (!path.contains('table')) {
                            contextEvent.cancel();
                        }
                    }, null, null, 5);
                }
            }
        });
    </script>
@endsection
