<x-app-layout>
  <div class="row pt-5">
    @include('layouts.sideBar',[
    'userFullName'=>auth()->user()->full_name,
    'userEmail'=>auth()->user()->email,
    ])
    @include('layouts.mobileSideBar')
    <!-- =======================================
               DEPOSIT HISTORY START
         =======================================
    -->

    <div class=" col-xs-12 col-lg-10">
      <div class="container-fluid pt-3 pb-3">
        <!-- ################################ -->
        <span style="font-weight: bold;">Withdrawal</span><span style="font-size: 0.7em;" class="ml-2">Withdraw
          Funds</span>
        <!-- ################################ -->
        <div class="container-fluid">
          <div class="pt-3">
            <div class="card my-card-look">
              <div class="card-header my-card-head my-card-head-text">
                Overview
              </div>
              <div class="card-body">
                <p class="card-body-head-text">Amount to Withdraw:</p>
                <div class="row">
                  <div class="col-xs-12 col-md-6">
                    <form action="{{route('withdrawal_initiate')}}" method="post">
                      @csrf
                      <input class="form-control form-control-lg @error('amount') form-error @enderror" type="number"
                        name="amount" value="{{ old('amount') }}" min="10000" max="{{$maxAmount}}">
                      @error('amount')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                      <div class="pt-5 pb-5">
                        <button type="submit" class="btn btn-success">Withdraw</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
