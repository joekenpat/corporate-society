<x-app-layout>
  <div class="row pt-5">
    @include('layouts.sideBar',[
    'userFullName'=>auth()->user()->full_name,
    'userEmail'=>auth()->user()->email,
    ])
    @include('layouts.mobileSideBar')
    <!-- =======================================
               PROFILE SUMMARY START
         =======================================
    -->
    <div class=" col-xs-12 col-lg-10">
      <div class="container-fluid pt-3 pb-3">
        <!-- ################################ -->
        <span style="font-weight: bold;">My Profile</span>
        <!-- ################################ -->
        <div class="container-fluid">
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
                      <label class="pb-3" for="bank_name" style="font-size: 0.8em; font-weight: bold;">Bank Name</label>
                      <select class="form-control form-control-sm @error('bank_code') form-error @enderror"
                        name="bank_code">
                        <option value="">Select Bank</option>
                        @if(count($bankList))
                        @foreach ($bankList as $bankListItem)
                        <option value="{{$bankListItem->code}}"
                          {{$withdrawalBank->bank_code == $bankListItem->code?"selected":""}}>{{$bankListItem->name}}
                        </option>

                        @endforeach
                        @endif
                      </select>
                      @error('bank_code')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <label class="pb-3" for="account_number" style="font-size: 0.8em; font-weight: bold;">Account
                        Number</label>
                      <input class="form-control form-control-sm @error('account_number') form-error @enderror"
                        type="text" name="account_number"
                        value="{{ old('account_number')?:($withdrawalBank->account_number??"") }}"
                        placeholder="Account Number">
                      @error('account_number')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <label class="pt-3" for="account_name" style="font-size: 0.8em; font-weight: bold;">Account
                        Name</label>
                      <input class="form-control form-control-sm @error('account_name') form-error @enderror"
                        type="text" name="account_name"
                        value="{{ old('account_name')?:($withdrawalBank->account_name??"") }}"
                        placeholder="Account Name">
                      @error('account_name')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="pt-3" style="float: right;">
                    <button type="submit" class="btn btn-success">Save</button>
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
                    <input class="form-control form-control-sm @error('old_password') form-error @enderror"
                      type="password" placeholder="Old Password">
                  </div>
                  <div class="col-xs-12 col-md-4">
                    <label class="pb-3" for="new_password" style="font-size: 0.8em; font-weight: bold;">New
                      Password</label>
                    <input class="form-control form-control-sm @error('new_password') form-error @enderror"
                      type="password" placeholder="New Password" autocomplete="new-password">
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
  </div>
  </div>
</x-app-layout>
