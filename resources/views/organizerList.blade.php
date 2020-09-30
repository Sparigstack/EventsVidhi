@extends('layouts.appOrg')
@section('css')
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header addNewEventButton">
                        <i class="fa fa-table pt-3"></i> List of Organizers
                        <!-- <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="{{url("org/events/new")}}">Add New Event</a></button> -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="default-datatable_wrapper">
                            <!-- <table id="default-datatable" class="table table-bordered"> -->
                            <table id="default-datatable" class="table" style="border-collapse: collapse !important;">
                                <thead style="background-color: #6c757d29;">
                                    <tr>
                                        <th width="35%">Organizer Name</th>
                                        <th>Organizer Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($organizers as $organizer) {
                                        ?>
                                    <tr class="parent">
                                        <td width="35%"> <a href="{{ url("orgEvents/$organizer->id") }}" style="color:inherit;"> <u> {{$organizer->name}} </u> </a> </td> 
                                        <td> {{$organizer->email}} </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                                <!-- <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Title</th>
                                        <th class="max-w-table-100">Date & Time</th>
                                        <th>Category</th>
                                        <th class="max-w-table-100">Action</th>
                                    </tr>
                                </thead> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
<!-- <script src="{{asset('/js/Events.js')}}" type="text/javascript"></script> -->
<!-- Data Tables -->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>
<script>
    $(document).ready(function () {
        var table = $('#default-datatable').DataTable({
                        ordering: false,

                        aoColumnDefs: [
                        {
                            bSortable: false,
                            aTargets: [1]
                        }
                        ],
        });
    });
</script>
@endsection