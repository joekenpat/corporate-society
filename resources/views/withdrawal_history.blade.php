<x-app-layout>
  <div class="container-fluid pt-3 pb-3">
    <!-- ################################ -->
    <span style="font-weight: bold;">Withdraw</span><span style="font-size: 0.7em;" class="ml-2">History</span>
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
                @if(count($withdrawals))
                @foreach ($withdrawals as $withdrawal)
                <tr>
                  <td>{{$withdrawal->code}}</td>
                  <td>₦{{number_format($withdrawal->amount)}}</td>
                  <td>{{$withdrawal->status}}</td>
                  <td>{{$withdrawal->created_at->toDateString()}}</td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="4" class="text-center">No withdrawal yet</td>
                </tr>
                @endif
                <tbody>
                </tbody>
              </table>
            </div>

          </div>
          @if ($withdrawals->hasPages())
          <div class="card-footer p-2">
            {!! $withdrawals->links() !!}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
