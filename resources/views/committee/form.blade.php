@extends('layouts.app')
@section('title', $title)
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    @if (empty($data))
        {{ Form::open(['novalidate', 'route' => 'committees.store', 'class' => $errors->any() ? 'was-validated form-horizontal' : 'needs-validation form-horizontal', 'id' => 'account-form', 'method' => 'post', 'files' => true]) }}
    @else
        {{ Form::model($data, ['novalidate', 'route' => ['committees.update', $data->id], 'class' => $errors->any() ? 'was-validated form-horizontal' : 'needs-validation form-horizontal', 'id' => 'account-form', 'method' => 'put', 'files' => true]) }}
    @endif
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <div class="col-1">
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
                    <div class="col-5">
                        <label class="form-label">Image</label>
                        {{ Form::file('image', ['class' => 'form-control', 'accept'=>'image/*']) }}
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label"><span class="text-danger">*</span> Name</label>
                        {{ Form::text('name', old('name'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter name']) }}
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label"><span class="text-danger">*</span> Position</label>
                        {{ Form::text('position', old('position'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter position']) }}
                        @error('position')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label"><span class="text-danger">*</span> Organization</label>
                        {{ Form::text('organization', old('organization'), ['class' => 'form-control', 'required', 'placeholder' => 'Enter organization']) }}
                        @error('organization')
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
    <script>
        function rondomPassword(e) {
            let password = Math.random().toString(36).slice(-e);
            $('.password').val(password)
        }
    </script>
@endsection
