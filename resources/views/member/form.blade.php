@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    {{ Form::model($data, ['novalidate', 'route' => ['members.update', $data->id], 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    {{ Form::hidden('formType', $formType) }}
    {{ Form::hidden('registrantTypeId', $registrantTypeId, ['id' => 'registrantTypeId']) }}
    @if ($formType == 'data')
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Information</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label"><span class="text-danger">*</span> Title</label>
                            {{ Form::text('title', old('title'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label class="form-label"><span class="text-danger">*</span> First Name</label>
                            {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('first_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label class="form-label"><span class="text-danger">*</span> Middle Name</label>
                            {{ Form::text('middle_name', old('middle_name'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('middle_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label class="form-label"><span class="text-danger">*</span> Last Name</label>
                            {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('last_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label"><span class="text-danger">*</span> E-mail</label>
                            {{ Form::email('email', old('email'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label"><span class="text-danger">*</span> Second E-mail</label>
                            {{ Form::email('email_secondary', old('email_secondary'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('email_secondary')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label"><span class="text-danger">*</span> Address (Department /
                                Office)</label>
                            {{ Form::text('address', old('address'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-3">
                            <label class="form-label"><span class="text-danger">*</span> City Code</label>
                            {{ Form::text('city_code', old('city_code'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('city_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label class="form-label"><span class="text-danger">*</span> City / State / District</label>
                            {{ Form::text('city', old('city'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('city')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label"><span class="text-danger">*</span> Country</label>
                            {{ Form::select('country', $countries, old('country'), ['id' => 'country', 'class' => 'form-select', 'required', 'onchange' => 'getAssociation(this)']) }}
                            @error('country')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label"><span class="text-danger">*</span> Phone</label>
                            {{ Form::text('phone', old('phone'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label"><span class="text-danger">*</span> Mobile Phone</label>
                            {{ Form::text('phone_mobile', old('phone_mobile'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('phone_mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label"><span class="text-danger">*</span> Authority /Organisation</label>
                            @if ($hasAssociation)
                                {{ Form::select('organization', $associations, old('organization'), ['id' => 'organization', 'class' => 'form-select', 'required']) }}
                            @else
                                {{ Form::text('organization', old('organization'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @endif
                            @error('organization')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label"><span class="text-danger">*</span> Professional Title</label>
                            {{ Form::text('profession_title', old('profession_title'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('profession_title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Invoicing Address</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label"><span class="text-danger">*</span> Tax ID</label>
                            {{ Form::text('tax_id', old('tax_id'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('tax_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label"><span class="text-danger">*</span> Phone</label>
                            {{ Form::text('tax_phone', old('tax_phone'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter data']) }}
                            @error('tax_phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Other (optional)</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label"> Dietary Restrictions</label>
                            {{ Form::text('dietary_restrictions', old('dietary_restrictions'), ['class' => 'form-control', 'placeholder' => 'Enter data']) }}
                            @error('dietary_restrictions')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label"> Special Requirements</label>
                            {{ Form::text('special_requirements', old('special_requirements'), ['class' => 'form-control', 'placeholder' => 'Enter data']) }}
                            @error('special_requirements')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
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
        <br>
        <br>
    @else
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
                            <button class="btn btn-success w-100" type="submit" name="action"
                                value="upload_receipt">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {!! Form::close() !!}
@endsection
@section('script')
    <script>
        function getAssociation(e) {
            let country = $('#country').val()
            let registrantTypeId = $('#registrantTypeId').val()
            console.log(country);
            console.log(registrantTypeId);
            $.ajax({
                type: 'POST',
                url: '{!! route('members.getassociations') !!}',
                data: {
                    country: country,
                    registrantTypeId: registrantTypeId,
                },
                success: function(data) {
                    console.log(data);
                    $('select[id="organization"]').find('option').remove();
                    $('select[id="organization"]').append('<option value="">Authority /Organisation</option>');
                    if (data.length == 0) {
                        $('select[id="organization"]').prop('disabled', true);
                    } else {
                        data.forEach(element => {
                            $('select[id="organization"]').append('<option value="' + element.name +
                                '">' +
                                element
                                .name + '</option>');
                        });
                        $('select[id="organization"]').prop('disabled', false);
                    }
                }
            });
        }
    </script>
@endsection
