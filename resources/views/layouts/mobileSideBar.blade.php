<!-- =======================================
              MOBILE SIDE NAV END
         =======================================
    -->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="#" class="mb-0 py-0 text-center">
    <img
      src="{{auth()->user()->profile_image!=(null||"")?asset('images/profile/'.auth()->user()->profile_image):asset('images/misc/default_avatar.png')}}"
      style="height: 60px; width: 60px; border-radius: 50px;"></a>
  <p class="mb-0 pb-0 mt-2 text-center ">
    <span class="badge badge-success ">{{ auth()->user()->padded_id }}</span>
  </p>
  <p class="mb-n1 pb-0 mt-0 text-center">
    <span class="mb-0 pb-0 text-center" style="text-decoration: none;color:#fff">{{ auth()->user()->full_name }}</span>
  </p>
  <p class="mb-2 pb-0 mt-0 text-center >
    <span class=" mb-0 pt-0 pb-3 text-center" style="text-decoration: none;color:#fff">{{auth()->user()->email}}</span>
  </p>
  <hr>
  <a href="{{route('dashboard')}}">
    <span class="mdi mdi-view-dashboard mr-1"></span>
    Dashboard
  </a>
  <a href="{{route('deposit_create')}}">
    <span class="mdi mdi-bank-plus mr-1"></span>
    Deposit
  </a>
  <a href="{{route('withdrawal_create')}}">
    <span class="mdi mdi-bank-minus mr-1"></span>
    Withdraw
  </a>
  <a href="{{route('investment_create')}}">
    <span class="mdi mdi-wallet-plus mr-1"></span>
    Create Investment
  </a>
  <a href="{{route('investment_history')}}">
    <span class="mdi mdi-chart-bar mr-1"></span>
    Manage Investment
  </a>
  <a href="{{route('deposit_history')}}">
    <span class="mdi mdi-trending-down mr-1"></span>
    Deposit History
  </a>
  <a href="{{route('withdrawal_history')}}">
    <span class="mdi mdi-trending-up mr-1"></span>
    Withdrawal History
  </a>
  <a href="{{route('profile_general')}}">
    <span class="mdi mdi-account mr-1"></span>
    Profile
  </a>
  <!-- Authentication -->
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <a href="{{route('logout')}}" onclick="event.preventDefault();
        this.closest('form').submit();">
      <span class="mdi mdi-logout mr-1"></span>
      Sign Out</a>
  </form>
</div>
