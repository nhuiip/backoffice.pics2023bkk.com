@extends('layouts.app')
@section('title', $title)
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/vendors/photoswipe.css') }}">
@endsection
@section('breadcrumb')
    @include('layouts.components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title])
@endsection
@section('content')
    {{ Form::open(['novalidate', 'route' => 'hotels-image.store', 'class' => 'form-horizontal', 'id' => 'account-form', 'method' => 'post', 'files' => true]) }}
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="row mb-3">
                    <div class="col-10">
                        {{ Form::hidden('hotelId', $hotel->id) }}
                        {{ Form::file('image[]', ['class' => 'form-control', 'accept' => 'image/*', 'multiple']) }}
                        @error('image[]')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-2">
                        <button class="btn btn-success w-100" type="submit" value="save">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="row my-gallery gallery-with-description" itemscope="" data-pswp-uid="1">
        @foreach ($data as $key => $value)
            <figure class="col-xl-3 col-sm-6 xl-33" itemprop="associatedMedia" itemscope="">
                @if($value->is_cover)
                <span class="badge badge-success" style="position: absolute;font-size:1rem"><i class="fa fa-check"></i> Cover</span>
                @endif
                <a href="javascript:;" itemprop="contentUrl" data-size="1600x950">
                    <img src="{{ $value->image_url }}" class="bg-white" itemprop="thumbnail" alt="Image description">
                    <div class="caption bg-white">
                        <div class="btn-group w-100" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-success w-50" data-text="Make to cover!"
                                data-form="update-form-{{ $value->id }}" onclick="fncCover(this)">Make to cover</button>
                            <button type="button" class="btn btn-danger w-50" data-text="Delete!"
                                data-form="delete-form-{{ $value->id }}" onclick="fncDelete(this)">Delete</button>
                        </div>
                    </div>
                </a>
                <form id="update-form-{{ $value->id }}" method="post"
                    action="{{ route('hotels-image.update', $value->id) }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="is_cover" value="1">
                </form>
                <form id="delete-form-{{ $value->id }}" method="post"
                    action="{{ route('hotels-image.destroy', $value->id) }}">
                    @csrf
                    @method('DELETE')
                </form>
            </figure>
        @endforeach
    </div>
@endsection
@section('script')
    <script>
        function fncCover(e) {
            let text = $(e).attr('data-text');
            let form = $(e).attr('data-form');
            let popup = new swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: {
                    cancel: true,
                    confirm: {
                        text: text,
                        className: 'btn-success'
                    },
                },
            }).then((willDelete) => {
                if (willDelete) {
                    $('#' + form).submit();
                } else {
                    swal.close();
                }
            });
            return popup;
        }
    </script>
@endsection
