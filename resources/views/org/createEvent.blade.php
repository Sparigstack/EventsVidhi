@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-11" style="margin: auto">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Add Event</div>
                    <hr>
                    <form class="row" method="post" action="{{url('org/events/store')}}">
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
                        </div>
                        <!-- <div class="form-group col-lg-6">
                            <label for="input-5">Durations</label>
                            <input type="time" id="" class="form-control">
                        </div> -->
                        <div class="form-group col-12">
                            <div class="icheck-material-primary">
                                <input type="checkbox" id="IsOnline" name="IsOnline">
                                <label for="IsOnline">Public</label>
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