<x-app-layout>
  <div class="row pt-5">
    @include('layouts.sideBar',[
    'userFullName'=>auth()->user()->full_name,
    'userEmail'=>auth()->user()->email,
    ])
    @include('layouts.mobileSideBar')
    <!-- =======================================
               INVEST CREATE START
         =======================================
    -->

    <div class=" col-xs-12 col-lg-10">
      <div class="container-fluid pt-3 pb-3">
        <!-- ################################ -->
        <span style="font-weight: bold;">Create an Investment</span><span style="font-size: 0.7em;" class="ml-2">You can
          create multiple investments</span>
        <!-- ################################ -->
        <div class="container-fluid">
          <div class="pt-3">
            <div class="card my-card-look">
              <div class="card-header my-card-head my-card-head-text">
                Overview
              </div>
              <div class="card-body">
                <form action="{{route('investment_initiate')}}" method="post">
                  <div class="row">
                    @csrf
                    <div class="col-xs-12 col-md-6 pt-3">
                      <p class="card-body-head-text">Choose Package:</p>
                      <select class="form-control form-control-lg @error('investment_package_id') form-error @enderror"
                        name="investment_package_id">
                        <option value="">Select Package</option>
                        @if(count($investmentPackages))
                        @foreach ($investmentPackages as $investmentPackage)
                        <option value="{{$investmentPackage->id}}">{{$investmentPackage->name}}</option>
                        @endforeach
                        @endif
                      </select>
                      @error('investment_package_id')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-xs-12 col-md-6 pt-3">
                      <p class="card-body-head-text ">Amount:</p>
                      <input class="form-control form-control-lg @error('amount') form-error @enderror" type="number"
                        name="amount" value="{{ old('amount') }}" min="10000" max="{{$maxAmount}}">
                      @error('amount')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="pt-3 pb-5">
                    <p class="card-body-head-text">ROI(%):</p>
                    <p class="roi-tetx">10</p>
                    <p class="card-body-head-text">Tenure:</p>
                    <p class="roi-tetx">Every 3 Months</p>
                    <div class="text-center">
                      <button type="submit" class="btn btn-success">Invest</button>
                      <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                  </div>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</x-app-layout>
