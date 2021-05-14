<x-app-layout>
  <div class="container-fluid pt-3 pb-3">
    <!-- ################################ -->
    <span style="font-weight: bold;">Deposit</span><span style="font-size: 0.7em;" class="ml-2">History</span>
    <!-- ################################ -->
    <div class="">
      <div class="pt-3">
        <div class="card my-card-look">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
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
                  <td>₦{{number_format($deposit->amount)}}</td>
                  <td>{{$deposit->status}}</td>
                  <td>{{$deposit->created_at->toDateString()}}</td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="4" class="text-center">No Deposit Yet</td>
                </tr>
                @endif
                <tbody>
                </tbody>
              </table>
            </div>

          </div>
          @if ($deposits->hasPages())
          <div class="card-footer p-2">
            {!! $deposits->links() !!}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
