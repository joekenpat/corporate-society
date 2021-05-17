@extends('errors.illustrated-layout')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('The Service or Page you are looking was Not Found'))
@section('image')
<div style="background-image: url({{ asset('images/misc/404.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
