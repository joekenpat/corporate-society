<!-- =======================================
               HEADER START
         =======================================
    -->
<nav class="navbar fixed-top" style="background-color: rgb(47, 151, 47)">
  <a class="navbar-brand" @auth href="{{route('dashboard')}}" @else href="{{route('welcome')}}" @endauth>
    <x-application-logo height="40px" width="40px"
      style="height: 30px;background-color: #ffffff; height: 40px; width: 40px; border-radius: 50px" alt="logo" />
  </a>
  @if(Auth::user()->status != 'approved' && Auth::user()->status !='declined')
  <a href="{{route('membership_detail')}}"
    style="background-color: orange; border-radius: 5px; padding: 5px;padding-left: 20px; padding-right: 20px; color: #ffffff; font-size: 0.8em; font-weight: bold; margin-bottom: 0%;">
    Membership
  </a>
  @endif
  <i style="font-size:30px;cursor:pointer; color: #ffffff;" class="mdi mdi-menu mr-1  d-lg-none d-xs-block d-md-block"
    onclick="openNav()"></i>
</nav>
