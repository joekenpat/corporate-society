<!--
        ***********************************
                    N A V B A R
        ***********************************
    -->
<nav class="navbar navbar-light shadow-sm bg-white py-3 fixed-top navbar-expand-lg" id="myMenu">
  <div class="container">
    <!-- navbar brand -->
    <a href="javascript:void(0)" class="navbar-brand">
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
          <a href="#home" class="nav-link">Home</a>
        </li>

        <!-- link -->
        <li class="nav-item">
          <a href="#packages" class="nav-link">Packages</a>
        </li>

        <!-- link -->
        <li class="nav-item">
          <a href="#about" class="nav-link">About</a>
        </li>

        <!-- link -->
        <li class="nav-item">
          <a href="#contact" class="nav-link">Contact</a>
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
      </ul>
    </div>
  </div>
</nav>
