@extends('layouts.master')
@section('content')
    


      

@if(session('feedsuccess'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>{{ session('feedsuccess')  }}</strong> 
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form action="{{ url('admin/edit') }}" method="POST">
  @csrf

            <div class="col-md-8">
            <select class="form-select" name ="staff" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <option value="1">DR JOHN</option>
                <option value="2">DR ANNA</option>
                <option value="3">DR JULLIETH</option>
              </select>
            </div>

              <div class="mb-3">
                <label for="validationTextarea" class="form-label">Appointment Description</label>
                <textarea class="form-control is-invalid" name="FeedDescrption" placeholder="Required example textarea" required></textarea>
                <div class="invalid-feedback">
                  Please enter a message in the textarea.
                </div>

                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Submit form</button>
                </div>
          </form>
       
      
    @endsection
