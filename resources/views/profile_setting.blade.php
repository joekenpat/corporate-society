<x-app-layout>
  @push('bottomScripts')
  <script>
    const checkValidAccount = ()=>{
    let bank_code = document.getElementById('bank').value
    let account_number = document.getElementById('account_number').value

    if(bank_code !== "" && account_number.length === 10){
      $.ajax({
        type: "POST",
        url: "/api/verify/bank-account",
        data: {account_number:account_number,bank: bank_code},
        success: function(res){
          if(res.status === 'success'){
            document.getElementById('account_name').value=res.data.account_name
            document.getElementById('account_name_error').innerHTML=''
            document.getElementById('smBtn').removeAttribute('disabled')
          }else{
            document.getElementById('account_name_error').innerHTML=res.message
            document.getElementById('smBtn').setAttribute('disabled','true')
          }
        },
        error: function(error){
          document.getElementById('account_name').innerHTML=''
          document.getElementById('account_name_error').innerHTML='Error Retrieving Account Details.'
          document.getElementById('smBtn').setAttribute('disabled','true')
        }
      })
    }else{
      document.getElementById('smBtn').setAttribute('disabled','true')
    }
  }
  </script>
  @endpush
  <div class="container-fluid pt-3 pb-3">
    <!-- ################################ -->
    <span style="font-weight: bold;">My Profile</span>
    <!-- ################################ -->
    <div class="">
      <div class="pt-3">
        <div class="card my-card-look">
          <div class="card-header my-card-head my-card-head-text">
            <span class="mr-5">Personal Information:</span><a href="{{route('membership_detail')}}"
              style="color: blue;">Edit</a>
          </div>
          <div class="card-body">
            <p class="card-body-head-text">Banking Information:</p>
            <form action="{{route('update_profile_withdrawal_bank')}}" method="post">
              @csrf
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <label class="pb-3" for="bank" style="font-size: 0.8em; font-weight: bold;">Bank Name</label>
                  <select class="form-control form-control-sm @error('bank') form-error @enderror" name="bank"
                    id="bank">
                    <option value="">Select Bank</option>
                    @if(count($bankList))
                    @foreach ($bankList as $bankListItem)
                    <option value="{{$bankListItem->code}}"
                      {{($withdrawalBank->bank_code) == $bankListItem->code?"selected":""}}>{{$bankListItem->name}}
                    </option>

                    @endforeach
                    @endif
                  </select>
                  @error('bank')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-xs-12 col-md-6">
                  <label class="pb-3" for="account_number" style="font-size: 0.8em; font-weight: bold;">Account
                    Number</label>
                  <input class="form-control form-control-sm @error('account_number') form-error @enderror" type="text"
                    name="account_number" id="account_number"
                    value="{{ old('account_number')?:($withdrawalBank->account_number??"") }}"
                    placeholder="Account Number" oninput="checkValidAccount()">
                  @error('account_number')
                  <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-xs-12 col-md-6">
                  <label class="pt-3" for="account_name" style="font-size: 0.8em; font-weight: bold;">Account
                    Name</label>
                  <input class="form-control form-control-sm" type="text" name="account_name" id="account_name" readonly
                    value="{{ $withdrawalBank->account_name }}" placeholder="Account Name" required>
                  <span id="account_name_error" class="text-danger">
                    @error('amount')
                    {{ $message }}
                    @enderror
                  </span>
                </div>
              </div>
              <div class="pt-3" style="float: right;">
                <button id="smBtn" type="submit" class="btn btn-success">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="pt-3">
        <div class="card my-card-look">
          <div class="card-header my-card-head my-card-head-text">
            <span class="mr-5">Change Password:</span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-xs-12 col-md-4">
                <label class="pb-3" for="old_password" style="font-size: 0.8em; font-weight: bold;">Old
                  Password</label>
                <input class="form-control form-control-sm @error('old_password') form-error @enderror" type="password"
                  placeholder="Old Password">
              </div>
              <div class="col-xs-12 col-md-4">
                <label class="pb-3" for="new_password" style="font-size: 0.8em; font-weight: bold;">New
                  Password</label>
                <input class="form-control form-control-sm @error('new_password') form-error @enderror" type="password"
                  placeholder="New Password" autocomplete="new-password">
              </div>
              <div class="col-xs-12 col-md-4">
                <label class="pt-3" for="confirm_password" style="font-size: 0.8em; font-weight: bold;">Confirm
                  Password</label>
                <input class="form-control form-control-sm @error('confirm_password') form-error @enderror"
                  type="password" placeholder="Retype New Password">
              </div>
            </div>
            <div class="pt-3" style="float: right;">
              <button type="button" class="btn btn-success">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- =======================================
               WITHDRAWAL END
         =======================================
    -->
  </div>
  </div>
</x-app-layout>
