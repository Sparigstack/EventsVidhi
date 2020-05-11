@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-11" style="margin: auto">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Add Event</div>
                    <hr>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                    <form class="row" method="post" action="{{url('org/events/store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }} 
                        <div class="form-group col-lg-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Event Title">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="selectionCategory">Category</label>
                            <select autocomplete="off" name="category" id="category" class=" custom-select">
                                <option value="0">Select Category</option>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="{{$category->id}}"><?php echo $category->name; ?> </option>
                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="Description">Description</label>
                            <textarea id="Description" name="Description" class="form-control" title="Description" placeholder="Description" autocomplete="off" rows="4"></textarea>
                        </div>


                        <div class="form-group col-lg-6">
                            <label for="Address">Address</label>
                            <input type="text" id="Address" name="Address" class="form-control" title="Address" placeholder="Address" autocomplete="off" rows="0">
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="selectionCategory">City</label>
                            <select autocomplete="off" name="city" id="city" class=" custom-select">
                                <option value="0">Select City</option>
                                <?php foreach ($cities as $city) { ?>
                                    <option value="{{$city->id}}"><?php echo $city->name; ?> </option>
                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="EventDateTime">Event Date & Time</label>
                            <input type="datetime-local" id="EventDateTime" name="EventDateTime" class="form-control">
                            <!-- datetime-local -->
                        </div>
                        <div class="form-group col-lg-6"></div>

                        <div class="form-group col-lg-6">
                            <label for="EventBannerImage">Banner Image</label>
                            <input type="file" id="EventBannerImage" name="EventBannerImage" class="form-control" onchange="document.getElementById('bannerImage').src = window.URL.createObjectURL(this.files[0]);document.getElementById('bannerImage').classList.remove('d-none');">
                            <small class="text-danger">{{ $errors->first('EventBannerImage') }}</small>
                            <img id="bannerImage" class="d-none m-2 imageRadius" alt="your image" width="100" height="100" />
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="EventImage">Thumbnail Image</label>
                            <input type="file" id="EventImage" name="EventImage" class="form-control" onchange="document.getElementById('thumbnailImage').src = window.URL.createObjectURL(this.files[0]);document.getElementById('thumbnailImage').classList.remove('d-none');">
                            <small class="text-danger">{{ $errors->first('EventImage') }}</small>
                            <img id="thumbnailImage" class="d-none m-2 imageRadius" alt="your image" width="100" height="100" />
                        </div>
                        
                        <!-- <div class="form-group col-lg-6">
                            <label for="input-5">Durations</label>
                            <input type="time" id="" class="form-control">
                        </div> -->
                        <div class="form-group col-12">
                            <div class="icheck-material-primary">
                                <input type="checkbox" id="IsPublic" name="IsPublic">
                                <label for="IsPublic">Public</label>
                            </div>
                        </div>



                        <div class="form-group col-lg-12">
                            <button type="submit" class="btn btn-primary px-5 pull-right"> ADD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('/js/customScript.js')}}" type="text/javascript"></script>
@endsection