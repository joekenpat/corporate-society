<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description"
    content="Is an organization that is born out of passion and needs to impact positively on the economic growth of the nation, to reduce the rate of poverty, and to improve the general wellbeing of the people.">
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset("apple-touch-icon.png")}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset("images/misc/favicon-32x32.png")}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset("images/misc/favicon-16x16.png")}}">
  <link rel='shortcut icon' type='image/x-icon' href="{{asset("images/misc/favicon.ico")}}">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @stack(' topStyles')
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  @stack('topScripts')
</head>

<body style="background-color: #c5c4c4;overflow-x: hidden;">
  @include('layouts.appNavigation')

  <!-- Page Content -->
  <main>
    <div class="row pt-5">
      @include('layouts.sideBar',[
      'userFullName'=>auth()->user()->full_name,
      'userEmail'=>auth()->user()->email,
      'userPaddedId' => auth()->user()->padded_id,
      ])
      @include('layouts.mobileSideBar')
      <div class="col-xs-12 col-lg-10 pt-3">
        <div class="p-3">
          @if ($message = Session::get('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!!$message!!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @elseif ($message = Session::get('info'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {!!$message!!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @elseif ($message = Session::get('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!!$message!!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
        @endif
        {{ $slot }}
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
    integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
  </script>
  <script>
    function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

  </script>
  @stack('bottomScripts')
</body>

</html>
