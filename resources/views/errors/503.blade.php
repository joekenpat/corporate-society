@extends('errors.illustrated-layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
{{-- @section('message', __($exception->getMessage() ?: 'Service Unavailable')) --}}
@section('message', __('Sorry we unable to provide the service you requested, as it is Unavailable.'))
@section('image')
<div style="background-image: url({{ asset('images/misc/503.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
