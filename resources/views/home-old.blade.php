@extends('layouts.app')
@section('css')
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<?php $AwsUrl = env('AWS_URL'); ?>
<div class="container col-md-11">

    <!-- <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Coming Soon!</h1>
        <p class="lead">We are building cool Events management system, easy to use and friendly to pockets!</p>
        @guest
        <a class="btn btn-primary btn-lg mb-5 mb-lg-2" href="{{ route('register') }}">List Your Event</a>
        @else
        <a class="btn btn-primary btn-lg mb-5 mb-lg-2" href="{{ route('orgEvents') }}">My Account</a>
        @endguest
    </div> -->

    <div class="card row col-md-12">
        <div class="card-header addNewEventButton">
            Upcoming Events
        </div>
    </div>

   
    <div class="row col-md-12 pl-0 pr-0">
        <?php foreach ($events as $event) { ?>
        <?php
            $logoUrl = $AwsUrl . 'no-image-logo.jpg';
            if (!empty($event->thumbnail)) {
                $logoUrl = $AwsUrl . $event->thumbnail;
            }
        ?>
        <div class="col-md-3">
            <div class="card">
                <?php
                $freeEventClass = "d-none";
                if($event->is_paid != 1){
                    $freeEventClass = "freeEventClass";
                } ?>
                <a href="#"><img src="{{$logoUrl}}" class="" alt="Event Logo" style="width: 100%;height: 200px;"></a>
                <span class="{{$freeEventClass}}">Free</span>
                <?php
                    $dateStr = "";

                    $sdStamp = strtotime($event->date_time);
                    $sd = date("d M, yy", $sdStamp);
                    $st = date('H:i A', $sdStamp);

                    $edStamp = strtotime($event->end_date_time);
                    $ed = date("d M, yy", $edStamp);
                    $et = date('H:i A', $edStamp);
                    if ($sd == $ed) {
                        // $dateStr = date("d M, yy", $sdStamp) . ' ' . $st;
                        $dateStr = date("D, M j, Y",  $sdStamp) . ' ' . $st;
                    } else {
                        // $dateStr = date("d M, yy", $sdStamp) . ' ' . $st;
                        $dateStr = date("D, M j, Y",  $sdStamp) . ' ' . $st;
                    }
                ?>
                <div class="card-body">
                    <p class="greenFont"> {{$dateStr}} {{$event->timezone->abbreviation}} <br> </p>
                    <a href="#"> <h5 class="card-title">{{$event->title}} </h5> </a>
                </div>
            </div>
        </div>
        <?php } ?>

    </div>


    <!--    <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
    
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>-->
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
            // columnDefs: [
            //     {orderable: false, targets: 4},
            // ],
            // bFilter: false,
                                                    ordering: false,

                                                    aoColumnDefs: [
                                                    {
                                                    bSortable: false,
                                                            aTargets: [2]
                                                    }
                                                    ],
                                                    // style_cell={'boxShadow': '0 0'},

        });
    });
</script>
@endsection
