<!-- =======================================
              MOBILE SIDE NAV END
         =======================================
    -->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="{{route('dashboard')}}">Dashboard</a>
  <a href="{{route('deposit_create')}}">Deposit</a>
  <a href="{{route('withdrawal_create')}}">Withdraw</a>
  <a href="{{route('investment_create')}}">Create Investment</a>
  <a href="{{route('investment_history')}}">Manage Investment</a>
  <a href="{{route('deposit_create')}}">Deposit History</a>
  <a href="{{route('withdrawal_history')}}">Withdraw History</a>
  <a href="{{route('profile_general')}}">Profile</a>
  <!-- Authentication -->
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <a href="{{route('logout')}}" onclick="event.preventDefault();
        this.closest('form').submit();">Sign Out</a>
  </form>
</div>
