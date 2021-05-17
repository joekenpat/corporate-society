@extends('errors.illustrated-layout')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('We Notice Too Many Requests From your end, You can try again after some minutes'))
@section('image')
<div style="background-image: url({{ asset('images/misc/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
