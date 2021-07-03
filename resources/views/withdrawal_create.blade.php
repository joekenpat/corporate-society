<x-app-layout>
  @push('bottomScripts')
  <script>
    const min_amount = 100
    const max_amount = {{$maxAmount}}
    const checkMinAmount = (value)=>{
      if(value < 100){
        document.getElementById('amount_error').innerHTML=`You need to increase the amount to the minimum ₦${100}.`
        document.getElementById('smBtn').setAttribute('disabled','true')
      }else if(value > max_amount){
        document.getElementById('amount_error').innerHTML=`You do not have upto the selected amount ₦${value}, you need ₦${(value - {{$maxAmount}})} in your available balance.`
        document.getElementById('smBtn').setAttribute('disabled','true')
      }else{
        document.getElementById('amount_error').innerHTML='';
        document.getElementById('smBtn').removeAttribute('disabled')
      }
    }
  </script>
  @endpush
  <div class="container-fluid pt-3 pb-3">
    <!-- ################################ -->
    <span style="font-weight: bold;">Withdrawal</span><span style="font-size: 0.7em;" class="ml-2">Withdraw
      Funds</span>
    <!-- ################################ -->
    <div class="">
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
                    name="amount" value="{{ old('amount') }}" min="100" max="{{$maxAmount}}"
                    oninput="checkMinAmount(this.value)">
                  <span id="amount_error" class="text-danger">
                    @error('amount')
                    {{ $message }}
                    @enderror
                  </span>
                  <div class="pt-5 pb-5">
                    <button  id="smBtn"  type="submit" class="btn btn-success">Withdraw</button>
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
</x-app-layout>
