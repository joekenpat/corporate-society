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
        <span style="font-weight: bold;">Deposit</span><span style="font-size: 0.7em;" class="ml-2">History</span>
        <!-- ################################ -->
        <div class="container-fluid">
          <div class="pt-3">
            <div class="card my-card-look">
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created At</th>
                      </tr>
                    </thead>
                    @if(count($deposits))
                    @foreach ($deposits as $deposit)
                    <tr>
                      <td>{{$deposit->code}}</td>
                      <td>{{number_format($deposit->amount)}}</td>
                      <td>{{$deposit->code}}</td>
                      <td>{{$deposit->toDateString()}}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                      <td colspan="4"></td>
                    </tr>
                    @endif
                    <tbody>
                    </tbody>
                  </table>
                </div>

              </div>
              @if ($deposits->hasPages())
              <div class="card-footer">
                {!! $deposits->links() !!}
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
