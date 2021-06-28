<x-app-layout>
  <div class="container-fluid pt-3 pb-3">
    <!-- ################################ -->
    <span style="font-weight: bold;">Deposit</span><span style="font-size: 0.7em;" class="ml-2">Deposit Funds</span>
    <!-- ################################ -->
    <div class="">
      <div class="pt-3">
        <div class="card my-card-look">
          <div class="card-header my-card-head my-card-head-text">
            Overview
          </div>
          <div class="card-body">
            <p class="card-body-head-text">Amount to Deposit:</p>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <form action="{{route('deposit_initiate')}}" method="post">
                  @csrf
                  <input class="form-control form-control-lg" name="amount" type="number" min="50" max="50000000">
                  <div class="pt-5 pb-5">
                    <button type="submit" class="btn btn-success">Deposit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
