<!--
        ***********************************
                    N A V B A R
        ***********************************
    -->
<nav class="navbar navbar-light shadow-sm bg-white py-3 fixed-top navbar-expand-lg" id="myMenu">
  <div class="container">
    <!-- navbar brand -->
    <a @auth href="{{route('dashboard')}}" @else href="{{route('welcome')}}" @endauth class="navbar-brand">
      <!-- site title -->
      <x-application-logo height="40px" width="40px" />
    </a>

    <!-- menu toggle on small screen -->
    <button type="button" data-toggle="collapse" data-target="#navbarMenu" class="navbar-toggler border-0">
      <!-- icon -->
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- collapse -->
    <div class="collapse navbar-collapse" id="navbarMenu">

      <!-- navbar -->
      <ul class="navbar-nav ml-auto">
        <!-- link -->
        <li class="nav-item">
          <a href="{{route('welcome')}}#home" class="nav-link">Home</a>
        </li>

        <!-- link -->
        <li class="nav-item">
          <a href="{{route('welcome')}}#packages" class="nav-link">Packages</a>
        </li>

        <!-- link -->
        <li class="nav-item">
          <a href="{{route('about')}}" class="nav-link">About</a>
        </li>

        <!-- link -->
        <li class="nav-item">
          <a href="{{route('welcome')}}#contact" class="nav-link">Contact</a>
        </li>

        @guest
        <!-- link -->
        <li class="nav-item">
          <a href="{{route('login')}}" class="nav-link">Login</a>
        </li>

        <!-- link -->
        <li class="nav-item">
          <a href="{{route('register')}}" class="nav-link">Register</a>
        </li>
        @endguest
        @auth
        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link" onclick="event.preventDefault();
            this.closest('form').submit();">{{ __('Log out') }}</a>
          </li>
        </form>
        @endauth
      </ul>
    </div>
  </div>
</nav>
