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
  <a href="#" class="mb-0 pb-0 text-center" style="text-decoration: none;color:#fff">{{ auth()->user()->full_name }}</a>
  <a href="#" class="mb-0 pt-0 pb-3 text-center" style="text-decoration: none;color:#fff">{{auth()->user()->email}}</a>
  <a href="{{route('dashboard')}}">Dashboard</a>
  <a href="{{route('deposit_create')}}">Deposit</a>
  <a href="{{route('withdrawal_create')}}">Withdraw</a>
  <a href="{{route('investment_create')}}">Create Investment</a>
  <a href="{{route('investment_history')}}">Manage Investment</a>
  <a href="{{route('deposit_history')}}">Deposit History</a>
  <a href="{{route('withdrawal_history')}}">Withdraw History</a>
  <a href="{{route('profile_general')}}">Profile</a>
  <!-- Authentication -->
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <a href="{{route('logout')}}" onclick="event.preventDefault();
        this.closest('form').submit();">Sign Out</a>
  </form>
</div>
