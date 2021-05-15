<x-app-layout>
  @push('bottomScripts')
  <script>
    const lgaList = @json($lgaList);
    const lgaElem = document.getElementById('lga');
    const selectedLgaList = (state_code)=>{
      lgaElem.length =1
      lgaList.filter(x=>x.state_code ==state_code).map(y=>{
        let option = document.createElement("option");
        option.text = y.name;
            option.value= y.name;
            lgaElem.add(option);
      })
    }
  </script>
  @endpush
  <div class="container-fluid">
    <div class="pt-3">
      <div class="card my-card-look">
        <div class="card-header my-card-head my-card-head-text">
          Overview
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">First name</p>
              <input class="form-control form-control-sm @error('first_name') form-error @enderror"
                value="{{ old('first_name')?:$userFirstName }}" type="text" placeholder="first name">
              @error('first_name')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">Last name</p>
              <input class="form-control form-control-sm @error('last_name') form-error @enderror"
                value="{{ old('last_name')?:$userLastName }}" type="text" placeholder="last name">
              @error('last_name')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">Others</p>
              <input class="form-control form-control-sm  @error('middle_name') form-error @enderror " type="text"
                placeholder="other names">
              @error('middle_name')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">Email</p>
              <input class="form-control form-control-sm  @error('email') form-error @enderror"
                value="{{ old('email')?:$userEmail }}" type="email" placeholder="email">
              @error('email')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">Phone number</p>
              <input class="form-control form-control-sm  @error('phone') form-error @enderror"
                value="{{ old('phone')?:$userPhone }}" type="phone" placeholder="Phone number">
              @error('phone')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">Date Of Birth</p>
              <input class="form-control form-control-sm  @error('date_of_birth') form-error @enderror"
                value="{{ old('date_of_birth')?:$userDOB }}" type="date">
              @error('date_of_birth')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">State</p>
              <select class="form-control form-control-sm  @error('state') form-error @enderror"
                onchange="selectedLgaList(this.value)">
                <option value="">Select State</option>
                @if(count($stateList))
                @foreach ($stateList as $statex)
                <option value="{{$statex->code}}">{{$statex->name}}</option>
                @endforeach
                @endif
              </select>
            </div>
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">LGA</p>
              <select class="form-control form-control-sm  @error('lga') form-error @enderror" id="lga" name="lga">
                <option>Select LGA</option>
              </select>
            </div>
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">Employment status</p>
              <select class="form-control form-control-sm">
                <option value="">Select</option>
                <option value="unemployed">Unemployed</option>
                <option value="employee">Employee</option>
                <option value="self-employed">Self Employed</option>
                <option value="worker">Worker</option>
              </select>
            </div>
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">Type of ID</p>
              <select class="form-control form-control-sm">
                <option>Select ID type</option>
                <option value="international-passport">International Passport</option>
                <option value="national-id">National ID</option>
                <option value="driver-license">Driver License</option>
                <option value="permanent-voter-card">Permanent Voter Card</option>
              </select>
            </div>
            @if(Auth::user()->status != 'approved')
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">upload ID</p>
              <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
            @endif
            <div class="col-xs-12 col-md-4 pt-3">
              <p class="my-membarship-signup-text">Upload Profile Image</p>
              <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>

            <div class="col-xs-12 col-md-6 pt-3">
              <p class="my-membarship-signup-text">Address 1</p>
              <input class="form-control form-control-sm " type="text" value="{{ old('address1')?:$userAddress1 }}"
                placeholder="Eg 123 lagos close">
              @error('address1')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-xs-12 col-md-6 pt-3">
              <p class="my-membarship-signup-text">Address 2 (optional)</p>
              <input class="form-control form-control-sm " type="text" value="{{ old('address2')?:$userAddress2 }}"
                placeholder="Eg 123 lagos close">
              @error('address2')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

          </div>
          <div class="pt-5 pb-5">
            <div>
              <button type="button" class="btn btn-success">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
