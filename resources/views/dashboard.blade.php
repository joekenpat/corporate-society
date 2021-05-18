<x-app-layout>
  <!-- =======================================
               DASHBOARD OVERVIEW START
         =======================================
    -->
  <div class="container-fluid pt-3 pb-3">
    <!-- ################################ -->
    <span style="font-weight: bold;">Dashboard</span><span style="font-size: 0.7em;" class="ml-2">Overview</span>
    <!-- ################################ -->
  </div>
  <div class="card border-0 pt-3" style="height: 20px; border-radius: 0%; background-color: #dddddb;"></div>
  <div class="container-fluid">
    <div class="pt-3">
      <div class="row">
        <div class="col-12 col-md-4 pb-3 px-md-4">
          <div class="row">
            <div class="col-auto bg-success">
              <div class="p-3">
                <i style="font-size: 40px; color: #ffffff;" class="mdi mdi-wallet mr-1"></i>
              </div>
            </div>
            <div class="col bg-white">
              <div class="p-1 pl-3 pr-3">
                <p class="overview-box-text-1 pt-2 p-0 m-0">WALLET</p>
                <p class="overview-box-text-2 pt-1 p-0 m-0">LEDGER BALANCE</p>
                <P class="overview-box-text-3 pt-1 p-0 m-0">₦{{$user_available_balance}}</P>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 pb-3 px-md-4">
          <div class="row">
            <div class="col-auto bg-info">
              <div class="p-3">
                <i style="font-size: 40px; color: #ffffff;" class="mdi mdi-wallet mr-1"></i>
              </div>
            </div>
            <div class="col bg-white">
              <div class="p-1 pl-3 pr-3">
                <p class="overview-box-text-1 pt-2 p-0 m-0">WALLET</p>
                <p class="overview-box-text-2 pt-1 p-0 m-0">INVESTMENT</p>
                <P class="overview-box-text-3 pt-1 p-0 m-0">₦{{$user_investment_balance}}</P>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 pb-3 px-md-4">
          <div class="row">
            <div class="col-auto bg-danger">
              <div class="p-3">
                <i style="font-size: 40px; color: #ffffff;" class="mdi mdi-calendar-month mr-1"></i>
              </div>
            </div>
            <div class="col bg-white">
              <div class="p-1 pl-3 pr-3">
                <p class="overview-box-text-1 pt-2 p-0 m-0">INVESTMENT</p>
                <p class="overview-box-text-2 pt-1 p-0 m-0">{{$user_active_investment_count}}</p>
                <P class="overview-box-text-3 pt-1 p-0 m-0"></P>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
