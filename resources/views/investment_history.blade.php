<x-app-layout>
  <div class="container-fluid pt-3 pb-3">
    <!-- ################################ -->
    <span style="font-weight: bold;">Investment</span><span style="font-size: 0.7em;" class="ml-2">History</span>
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
                    <th scope="col">ROI</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Ends At</th>
                  </tr>
                </thead>
                @if(count($investments))
                @foreach ($investments as $investment)
                <tr>
                  <td>{{$investment->code}}</td>
                  <td>₦{{number_format($investment->amount)}}</td>
                  <td>₦{{number_format($investment->roi)}}</td>
                  <td>{{$investment->completed_at ==null?'Active':'Closed'}}</td>
                  <td>{{$investment->created_at->toDateString()}}</td>
                  <td>{{$investment->ends_at->toDateString()}}</td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="6" class="text-center">No Investment Yet</td>
                </tr>
                @endif
                <tbody>
                </tbody>
              </table>
            </div>

          </div>
          @if ($investments->hasPages())
          <div class="card-footer p-2">
            {!! $investments->links() !!}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</x-app-layout>