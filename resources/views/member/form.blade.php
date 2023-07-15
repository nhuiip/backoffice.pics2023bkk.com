@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    {{ Form::model($data, ['novalidate', 'route' => ['members.update', $data->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <div class="col-10">
                        {{ Form::file('receipt', ['class' => 'form-control']) }}
                        @error('receipt')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success w-100" type="submit" name="action" value="upload_receipt">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
