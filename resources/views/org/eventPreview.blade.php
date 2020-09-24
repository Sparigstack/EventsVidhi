@extends('layouts.appOrg')
@section('css')
<link href="{{asset('assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/plugins/bootstrap-switch/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css">
<!-- <link href="{{ asset('assets/plugins/bootstrap-switch/bootstrap-switch.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/switchery/css/switchery.min.css') }}" rel="stylesheet"> -->
@endsection
@section('content')
<div class="container-fluid">

        <div class="row">
            <input type="hidden" class="eventsPage d-none" value="{{url("org/events")}}"/>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header addNewEventButton">
                        <i class="fa fa-table pt-3"></i> Event Preview
                        <button id="" class="btn m-1 pull-right btn-primary" style=""><a href="">Event Preview</a></button>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group mb-1">
                            <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input type="hidden" class="deleteEvent" value="{{url('deleteEvent')}}">
                            <input type="hidden" class="copyEvent" value="{{url('copyEvent')}}">
                            <div class="col-lg-12 row pr-0">
                                <div class="col-lg-6">
                                    <h5 class="mt-2 pt-1">{{$event->title}}</h5>
                                </div>
                                <div class="col-lg-6 pr-0">
                                    <button type="button" id="button" class="btn btn-light waves-effect waves-light m-1 float-right" onclick="deleteEvent(this);" db-delete-id="{{$event->id}}">Delete</button>
                                    <button type="button" id="button" class="btn btn-light waves-effect waves-light m-1 float-right mr-2" onclick="copyEvent(this);" db-event-id="{{$event->id}}">Copy</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php
                                $dateStr = "";

                                $sdStamp = strtotime($event->date_time);
                                $sd = date("d M, Y", $sdStamp);
                                $st = date('H:i A', $sdStamp);

                                $edStamp = strtotime($event->end_date_time);
                                $ed = date("d M, Y", $edStamp);
                                $et = date('H:i A', $edStamp);
                                if ($sd == $ed) {
                                    $dateStr = date("d M, Y", $sdStamp) . ' ' . $st . ' to ' . $et;
                                } else {
                                    $dateStr = date("d M, Y", $sdStamp) . ' ' . $st . ' to ' . date("d M, Y", $edStamp) . ' ' . $et;
                                }
                            ?>
                            <div class="col-lg-12">
                                <p style="font-size:16px;" class="">{{$dateStr}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <label for="eventStatus" class="mb-0 mr-2">Draft</label>
                                <?php
                                    $checkBoxChecked = "";
                                    if($event->is_live == 1){
                                        $checkBoxChecked = "checked";
                                    }
                                ?>
                                <input type="checkbox" class="js-switch" data-color="#14abef" data-secondary-color="#607d8b" data-switchery="true" style="display: none;" data-size="small" {{$checkBoxChecked}}>
                                <label for="eventStatus" class="mb-0 ml-2 mr-3">Published</label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <div class="col-lg-12">
                                <label for="ticketSales" class="mb-0">Ticket Sales</label>
                            </div>
                        </div>

                        <div class="form-group col-lg-12">
                            <table class="table table-bordered">
                                <thead style="background-color: #6c757d29;">
                                    <tr>
                                        <th>Ticket Type</th>
                                        <th>Price</th>
                                        <th>Sold</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $ticket)
                                    <tr class="parent">
                                        <td>{{$ticket->name}}</td> 
                                        <td>${{$ticket->price}}</td>
                                        <td>0/{{$ticket->quantity}}</td>
                                        <td>$0.00</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="registrationTab" class="mb-0"> Check all Registrations <a target="_blank" href="{{ url("org/events/$event->id/3") }}"> here </a></label>
                        </div>

                    </div>
                </div>
            </div>
        </div>

</div>

@endsection
@section('script')
<script type="text/javascript" src="{{asset('assets/plugins/switchery/js/switchery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/plugins/bootstrap-switch/bootstrap-switch.min.js')}}"></script>
<script>
var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
$('.js-switch').each(function () {
    new Switchery($(this)[0], $(this).data());
});
</script>
<script>
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function () {
    var bt = function () {
        $(".radio-switch").on("switch-change", function () {
            $(".radio-switch").bootstrapSwitch("toggleRadioState")
        }), $(".radio-switch").on("switch-change", function () {
            $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
        }), $(".radio-switch").on("switch-change", function () {
        $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
        })
    };
    return {
                init: function () {
                    bt()
                }
             }
    }();

    $(document).ready(function () {
        radioswitch.init();
        $('#pageloader-overlay').fadeOut(1000);
    });
</script>
<script src="{{asset('/js/Events.js')}}" type="text/javascript"></script>
@endsection