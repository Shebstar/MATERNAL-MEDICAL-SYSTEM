<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hi.. <b> {{Auth::user()->name}}</b>
            <b style ="float:right;"> Total users
                <span class="badge badge-danger">{{ count($users) }}</span>
            </b>
        </h2> 
    </x-slot>
<h1>Appointment scheduling</h1>
    <div class="py-12">
      <div class="container">
          <div class="row">
            @if(session('success'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <strong>{{ session('success')  }}</strong> 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif


            <form action="{{ route('dashboard') }}" method="POST">
              @csrf
            <form class="row g-3 needs-validation" novalidate>
              <div class="col-md-4">
                <label for="validationCustom01" class="form-label">First name</label>
                <input type="text" class="form-control" name="First_Name" value="Mark" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
              <div class="col-md-4">
                <label for="validationCustom02" class="form-label">Last name</label>
                <input type="text" class="form-control" name="Last_Name" value="Otto" required>
                <div class="valid-feedback">
                  Looks good!
                </div>
              </div>
              <div class="col-md-4">
                <label for="validationCustomUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                  <span class="input-group-text" id="inputGroupPrepend">@</span>
                  <input type="text" class="form-control" name="Username" aria-describedby="inputGroupPrepend" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <label for="validationCustom03" class="form-label">City</label>
                <input type="text" class="form-control" name="City" required>
                <div class="invalid-feedback">
                  Please provide a valid city.
                </div>
              </div>
              <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Gender</label>
                <select class="form-select" name="Gender" required>
                  <option selected disabled value="">Choose...</option>
                  <option>Female</option>
                  <option>Male</option>
                  <option>Other</option>
                </select>
                <div class="invalid-feedback">
                  Please select a valid state.
                </div>
              </div>
              <div class="col-md-3">
                <label for="validationCustom05" class="form-label">Zip</label>
                <input type="integer" class="form-control" name="Zip_Code" required>
                <div class="invalid-feedback">
                  Please provide a valid zip.
                </div>
              </div>
              <div class="mb-3">
                <label for="validationTextarea" class="form-label">Appointment Description</label>
                <textarea class="form-control is-invalid" name="Appointment_Description" placeholder="Required example textarea" required></textarea>
                <div class="invalid-feedback">
                  Please enter a message in the textarea.
                </div>
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                  <label class="form-check-label" for="invalidCheck">
                    Agree to terms and conditions
                  </label>
                  <div class="invalid-feedback">
                    You must agree before submitting.
                  </div>
                </div>
              </div>
              <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
              </div>
            </form>
           


          </div>
      </div>



    </div>
</x-app-layout>
