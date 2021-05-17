@extends('errors.illustrated-layout')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('This page have been inactive for a while. To continue viewing this page kindly go back and try
again'))
@section('image')
<div style="background-image: url({{ asset('images/misc/500.svg') }});"
  class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
