<!-- =======================================
               SIDE NAV START
         =======================================
    -->
<div class="col-xs-12 col-lg-2 d-none d-lg-block">
  <div class="card side-bar-card">
    <div class="pt-5 p-3 mb-5">
      <div class="pb-1 p-0 text-center">
        <img
          src="{{auth()->user()->profile_image!=(null||"")?asset('images/profile/'.auth()->user()->profile_image):asset('images/misc/default_avatar.png')}}"
          style="height: 60px; width: 60px; border-radius: 50px;">
      </div>
      <div class="">
        <p class="pt-3 mb-0" style="font-weight: bold; color: #ffffff; font-size: 0.9em;">
          <span class=" badge badge-success ">{{ $userPaddedId }}</span> </p>
        <p style="font-weight: bold; color: #ffffff; font-size: 0.9em;">{{ $userFullName }}</p>
        <p style="font-weight: bold; color: #ffffff; font-size: 0.7em;margin-top: -18px; ">{{$userEmail}}</p>
      </div>
      <div class="m-0 p-0 pt-3">
        <hr class="p-0 " style=" background-color: rgb(47, 151, 47); margin-top: -10px ">
      </div>

      <p class="side-link-text">
        <a href="{{route('dashboard')}}">
          <i style="font-size: 20px;" class="mdi mdi-view-dashboard mr-1"></i>
          Dashboard
        </a>
      </p>
      <p class="side-link-text">
        <a href="{{route('deposit_create')}}">
          <i style="font-size: 20px;" class="mdi mdi-bank-plus mr-1"></i>
          Deposit
        </a>
      </p>
      <p class="side-link-text">
        <a href="{{route('withdrawal_create')}}">
          <i style="font-size: 20px;" class="mdi mdi-bank-minus mr-1"></i>
          Withdraw
        </a>
      </p>
      <p class="side-link-text">
        <a href="{{route('investment_create')}}">
          <i style="font-size: 20px;" class="mdi mdi-wallet-plus mr-1"></i>
          Create Investment
        </a>
      </p>
      <p class="side-link-text">
        <a href="{{route('investment_history')}}">
          <i style="font-size: 20px;" class="mdi mdi-chart-bar mr-1"></i>
          Manage Investment
        </a>
      </p>
      <p class="side-link-text">
        <a href="{{route('deposit_history')}}">
          <i style="font-size: 20px;" class="mdi mdi-trending-down mr-1"></i>
          Deposit History
        </a>
      </p>
      <p class="side-link-text">
        <a href="{{route('withdrawal_history')}}">
          <i style="font-size: 20px;" class="mdi mdi-trending-up mr-1"></i>
          Withdrawal History
        </a>
      </p>
      <p class="side-link-text">
        <a href="{{route('profile_general')}}">
          <i style="font-size: 20px;" class="mdi mdi-account mr-1"></i>
          Profile
        </a>
      </p>
      @auth
      <!-- Authentication -->
      <form method="POST" action="{{ route('logout') }}">
        @csrf

        <p class="side-link-text"><a href="{{route('logout')}}" onclick="event.preventDefault();
            this.closest('form').submit();"><i style="font-size: 20px;" class="mdi mdi-logout mr-1"></i>
            {{ __('Log out') }}
          </a></p>
      </form>
      @endauth
    </div>
  </div>
</div>
