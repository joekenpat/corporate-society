@extends('errors.illustrated-layout')

@section('title', __('Server Error'))
@section('code', '501')
@section('message', __("Awwwh! Sorry we do not yet support the your kind of request"))
@section('image')
<div style="background-image: url({{ asset('images/misc/500.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
