@extends('layouts.master')
@section('content')
    
@if ($message = Session::get('success'))
                    <div class="alert alert-success row col-xs-12" style="margin-left: -13px;
    margin-bottom: -1px;
    margin-top: 4px;">
                        <p>{{$message}}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger row col-xs-12" style="margin-left: -13px; margin-bottom: -1px; margin-top: 4px;">
                        {{ session('error') }}
                        <br>
                    </div>
                @endif

            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">username</th>
                    <th scope="col">appointment Description</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>

                    @php($i=1)
                    @foreach ($appointments as $appointment)
                        
                    
                  <tr>
                    <th scope="row">{{$i++}}</th>
                    <td>{{$appointment ->UsernameAP}}</td>
                    <td>{{$appointment ->AppointDescription}}</td>
                    <td>{{$appointment ->created_at}}</td>
                    <td>@if($appointment->replied=='0' || $appointment->replied=='' )
                    NOT YET REPLIED
                    @else
                    ALREADY REPLIED
                  
                    @endif
                    </td>
                    <td>
                        
@if($appointment->replied=='0' || $appointment->replied=='')
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#appointment{{$appointment->AppointNo}}">
 Reply
</button>
@else
@endif

<!-- Modal -->
<div class="modal fade" id="appointment{{$appointment->AppointNo}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('create_feeback') }}">
          {{csrf_field()}}

          

<div class="col-md-8">
<select class="form-select" name ="staff" aria-label="Default select example">
<option value=""  selected></option>
<option value="DR JOHN">DR JOHN</option>
<option value="DR ANNA">DR ANNA</option>
<option value="DR JULLIETH">DR JULLIETH</option>
</select>
</div>

<div class="mb-3">
<label for="validationTextarea" class="form-label">Appointment Description</label>
<textarea class="form-control is-invalid" name="FeedDescrption" placeholder="Required example textarea" required></textarea>
<div class="invalid-feedback">
Please enter a message in the textarea.
</div>

<input type="hidden" name="AppointId" value="{{$appointment->AppointNo}}">

<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
  <button type="submit" class="btn btn-primary">Submit</button>
</div>


      </form>
      </div>
      
    </div>
  </div>
</div>




                      


                      {{-- <a href="{{ url('admin/edit') }}" class="btn btn-info">Edit</a> --}}
                       
  
  
  
                      </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

       

{{-- <form class="row g-3 needs-validation" novalidate>
    <div class="col-md-4">
      <label for="validationCustom01" class="form-label">First name</label>
      <input type="text" class="form-control" name="firstnameAD" value="Mark" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationCustom02" class="form-label">Last name</label>
      <input type="text" class="form-control" ="validationCustom02" value="Otto" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-4">
      <label for="validationCustomUsername" class="form-label">Username</label>
      <div class="input-group has-validation">
        <span class="input-group-text" id="inputGroupPrepend">@</span>
        <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
        <div class="invalid-feedback">
          Please choose a username.
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <label for="validationCustom03" class="form-label">City</label>
      <input type="text" class="form-control" id="validationCustom03" required>
      <div class="invalid-feedback">
        Please provide a valid city.
      </div>
    </div>
    <div class="col-md-3">
      <label for="validationCustom04" class="form-label">State</label>
      <select class="form-select" id="validationCustom04" required>
        <option selected disabled value="">Choose...</option>
        <option>...</option>
      </select>
      <div class="invalid-feedback">
        Please select a valid state.
      </div>
    </div>
    <div class="col-md-3">
      <label for="validationCustom05" class="form-label">Zip</label>
      <input type="text" class="form-control" id="validationCustom05" required>
      <div class="invalid-feedback">
        Please provide a valid zip.
      </div>
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
  </form> --}}
  @endsection