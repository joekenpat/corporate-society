@extends('errors.illustrated-layout')

@section('title', __('Forbidden'))
@section('code', '403')
{{-- @section('message', __($exception->getMessage() ?: 'Forbidden')) --}}
@section('message', __('Not Enough Permission. You Are Forbidden From Accessing That Resouce'))
@section('image')
<div style="background-image: url({{ asset('images/misc/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
