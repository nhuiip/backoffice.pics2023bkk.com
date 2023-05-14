@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    @if (empty($data))
        {{ Form::open(['novalidate', 'route' => 'registrations-fee.store', 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'post', 'files' => true]) }}
    @else
        {{ Form::model($data, ['novalidate', 'route' => ['registrations-fee.update', $data->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    @endif
    {{ Form::hidden('registrantGroupId', $registration->id) }}
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <div class="col-4">
                        <label class="form-label"><span class="text-danger">*</span> Registration rate</label>
                        {{ Form::select('registrationRateId', $rate, old('registrationRateId'), ['class' => 'form-select', 'required']) }}
                        @error('registrationRateId')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-4">
                        <label class="form-label"><span class="text-danger">*</span> Registrant type</label>
                        {{ Form::select('registrantTypeId', $type, old('registrantTypeId'), ['class' => 'form-select', 'required']) }}
                        @error('registrantTypeId')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-4">
                        <label class="form-label"><span class="text-danger">*</span> Price (USD)</label>
                        {{ Form::number('price', old('price'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter price']) }}
                        @error('price')
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
