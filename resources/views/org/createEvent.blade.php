@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="card-title">Horizontal Form</div>
                    <hr>
                    <form>
                        <div class="form-group">
                            <label for="input-1">Title</label>
                            <input type="text" class="form-control" id="input-1" placeholder="Please enter your Event title">
                        </div>
                        <div class="form-group">
                            <label for="input-2">Email</label>
                            <input type="text" class="form-control" id="input-2" placeholder="Enter Your Email Address">
                        </div>
                        <div class="form-group">
                            <label for="input-3">Mobile</label>
                            <input type="text" class="form-control" id="input-3" placeholder="Enter Your Mobile Number">
                        </div>
                        <div class="form-group">
                            <label for="input-4">Password</label>
                            <input type="text" class="form-control" id="input-4" placeholder="Enter Password">
                        </div>
                        <div class="form-group">
                            <label for="input-5">Confirm Password</label>
                            <input type="text" class="form-control" id="input-5" placeholder="Confirm Password">
                        </div>
                        <div class="form-group py-2">
                            <div class="icheck-material-primary">
                                <input type="checkbox" id="user-checkbox1" checked="">
                                <label for="user-checkbox1">I Agree Terms &amp; Conditions</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary px-5"><i class="icon-lock"></i> Register</button>
                        </div>
                    </form>
                </div>
            </div>


            

        </div>
    </div>
</div>
@endsection
