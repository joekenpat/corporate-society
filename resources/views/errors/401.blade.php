@extends('errors.illustrated-layout')

@section('title', __('Unauthorized'))
{{-- @section('code', '401') --}}
@section('message', __('Sorry You Are not Authorised to View or Access That Resource.'))
@section('image')
<div style="background-image: url({{ asset('images/misc/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection
