@extends('errors.illustrated-layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __("Awwwh! Something isn't right but don't worry our engineers are right on it"))
@section('image')
<div style="background-image: url({{ asset('images/misc/500.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
