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
            option.value= y.id;
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
          <form action="{{route('update_membership_details')}}" enctype="multipart/form-data" method="post">
            <div class="row">
              @csrf
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">First name</p>
                <input class="form-control form-control-sm @error('first_name') form-error @enderror"
                  value="{{ old('first_name')?:$userFirstName }}" type="text" placeholder="first name"
                  name="first_name">
                @error('first_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Last name</p>
                <input class="form-control form-control-sm @error('last_name') form-error @enderror"
                  value="{{ old('last_name')?:$userLastName }}" type="text" placeholder="last name" name="last_name">
                @error('last_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Others</p>
                <input class="form-control form-control-sm  @error('middle_name') form-error @enderror " type="text"
                value="{{ old('middle_name')?:$userMiddleName }}" placeholder="other names" name="middle_name">
                @error('middle_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Gender</p>
                <select class="form-control form-control-sm  @error('gender') form-error @enderror"
                  onchange="selectedLgaList(this.value)" name="gender">
                  <option value="">Select Gender</option>
                  <option {{$userGender =="M"?"selected":""}} value="M">Male</option>
                  <option {{$userGender =="F"?"selected":""}} value="F">Female</option>
                </select>
                @error('gender')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Email</p>
                <input class="form-control form-control-sm  @error('email') form-error @enderror"
                  value="{{ old('email')?:$userEmail }}" name="email" type="email" placeholder="email">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Phone number</p>
                <input class="form-control form-control-sm  @error('phone') form-error @enderror"
                  value="{{ old('phone')?:$userPhone }}" name="phone" type="tel" placeholder="Phone number">
                @error('phone')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Date Of Birth</p>
                <input class="form-control form-control-sm  @error('date_of_birth') form-error @enderror"
                  value="{{ old('dob')?:$userDOB }}" type="date" max="2005-01-01" name="dob">
                @error('dob')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">State</p>
                <select class="form-control form-control-sm  @error('state_code') form-error @enderror"
                  onchange="selectedLgaList(this.value)" name="state_code">
                  <option value="">Select State</option>
                  @if(count($stateList))
                  @foreach ($stateList as $statex)
                  <option value="{{$statex->code}}">{{$statex->name}}</option>
                  @endforeach
                  @endif
                </select>
                @error('state_code')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">LGA</p>
                <select class="form-control form-control-sm  @error('lga_id') form-error @enderror" id="lga" name="lga_id">
                  <option value="">Select LGA</option>
                </select>
                @error('lga_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Employment status</p>
                <select class="form-control form-control-sm  @error('emplpoyment_status') form-error @enderror"
                  name="employment_status">
                  <option value="">Select Employment Status</option>
                  <option {{$userEmploymentType =="unemployed"?"selected":""}} value="unemployed">Unemployed</option>
                  <option {{$userEmploymentType =="employee"?"selected":""}} value="employee">Employee</option>
                  <option {{$userEmploymentType =="self-employed"?"selected":""}} value="self-employed">Self Employed
                  </option>
                  <option {{$userEmploymentType =="worker"?"selected":""}} value="worker">Worker</option>
                </select>
                @error('employment_status')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Type of ID</p>
                <select class="form-control form-control-sm  @error('identification_type') form-error @enderror"
                  name="identification_type">
                  <option value="">Select ID type</option>
                  <option {{$userIdType =="international-passport"?"selected":""}} value="international-passport">
                    International Passport</option>
                  <option {{$userIdType =="national-id"?"selected":""}}value="national-id">National ID</option>
                  <option {{$userIdType =="driver-license"?"selected":""}}value="driver-license">Driver License</option>
                  <option {{$userIdType =="permanent-voter-card"?"selected":""}}value="permanent-voter-card">Permanent
                    Voter Card</option>
                </select>
                @error('identification_type')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              @if(Auth::user()->status != 'approved')
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Upload ID (5MB Max Size)</p>
                <input type="file" accept=".png, .jpg, .jpeg"
                  class="form-control-file   @error('identification_image') form-error @enderror"
                  name="identification_image">
                @error('identification_image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              @endif
              <div class="col-xs-12 col-sm-6 col-md-4 pt-3">
                <p class="my-membarship-signup-text">Upload Profile Image (5MB Max Size)</p>
                <input type="file" accept=".png, .jpg, .jpeg"
                  class="form-control-file   @error('profile_image') form-error @enderror" name="profile_image">
                @error('profile_image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-xs-12 col-md-6 pt-3">
                <p class="my-membarship-signup-text">Address 1</p>
                <input class="form-control form-control-sm   @error('address1') form-error @enderror" type="text"
                  value="{{ old('address1')?:$userAddress1 }}" placeholder="Eg 123 lagos close" name="address1">
                @error('address1')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-xs-12 col-md-6 pt-3">
                <p class="my-membarship-signup-text">Address 2 (optional)</p>
                <input class="form-control form-control-sm   @error('address2') form-error @enderror" type="text"
                  value="{{ old('address2')?:$userAddress2 }}" placeholder="Eg 123 lagos close" name="address2">
                @error('address2')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="p-3">
                <button type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
