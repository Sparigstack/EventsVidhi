<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<?php $v = "1.0.1"; ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PanelHive - Event Management System') }}</title>
    @yield('css')
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

    <!-- datetimepicker -->
    <!-- <link href="{{ asset('assets/plugins/datetimepicker-master/jquery.datetimepicker.css') }}" rel="stylesheet"> -->
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Font -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <!-- custom styles -->
    <link href="{{ asset('css/style.css?v='.$v) }}" rel="stylesheet">
    <!-- simplebar CSS-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet">
    <!-- Bootstrap core CSS-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--animate CSS-->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css">
    <!--Icons CSS-->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <!--Sidebar CSS-->
    <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet">
    <!--Custom Style-->
    <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet">
    <!--Bootstrap date picker-->
    <!-- <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"> -->

    <!-- Data Tables -->
    <!-- <link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> -->

    <!-- <link href="{{ asset('assets/plugins/jquery-multi-select/multi-select.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" /> -->


</head>

<body>
<!-- <?php
//$videoSize = Auth::user()->videos->sum('file_size');
// $fs=Video::where('user_id', 4)->sum('file_size');
// return $fs/8589934592;
?> -->
{{$vidSize= Auth::user()->videos->sum('file_size')}}
{{$podSize= Auth::user()->podcasts->sum('file_size')}}
{{$total=$vidSize+$podSize}}
{{$totalGb=$total/1073741824}}

<?php
    use App\Video;
    use APP\Podcast; 

    $loginUser = Auth::user();
    $vidUrlCount = Video::where("user_id" , $loginUser->id)->where("file_size" , NULL)->get();
    $podUrlCount = Podcast::where("user_id" , $loginUser->id)->where("file_size" , NULL)->get();
    $videoUrlCount = "";
    $podcastUrlCount = "";

    if($loginUser->plan_id == NULL){
        if(count($vidUrlCount) > 3){
            $videoUrlCount = "3";
        }
        if(count($podUrlCount) > 3){
            $podcastUrlCount = "3";
        }
    } else if($loginUser->plan_id == 1 || $loginUser->plan_id == 2){
        if(count($vidUrlCount) > 10){
            $videoUrlCount = "10";
        }
        if(count($podUrlCount) > 10){
            $podcastUrlCount = "10";
        }
    } else {
        if(count($vidUrlCount) > 10){
            $videoUrlCount = "";
        }
        if(count($podUrlCount) > 10){
            $podcastUrlCount = "";
        }
    }
?>

    <div id="pageloader-overlay" class="visible incoming" style="display: none;">
        <div class="loader-wrapper-outer">
            <div class="loader-wrapper-inner">
                <div class="loader"></div>
            </div>
        </div>
    </div>
    <div id='app'></div>
    <div id="wrapper">
        <div id="sidebar-wrapper" class="bg-theme bg-theme2 active" data-simplebar="init" data-simplebar-auto-hide="true">
            <div class="simplebar-track vertical" style="visibility: visible;">
                <div class="simplebar-scrollbar" style="visibility: visible; top: 0px; height: 140px;"></div>
            </div>
            <div class="simplebar-track horizontal" style="visibility: hidden;">
                <div class="simplebar-scrollbar"></div>
            </div>
            <div class="simplebar-scroll-content" style="padding-right: 17px; margin-bottom: -34px;">
                <div class="simplebar-content" style="padding-bottom: 17px; margin-right: -17px;">
                    <div class="brand-logo">
                        <!-- <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                            <h5 class="logo-text">Vidhi's Events</h5>
                        </a> -->
                        <a href="{{ url('/') }}" style="color: white;">
                        <h4 style="" class="mt-1 logo-text OrgLogoText"> <span class="dot1"></span> <span class="dot"></span>  panelhive </h4> </a> 
                    </div>
                    <div class="user-details">
                        <div class="media align-items-center" data-toggle="collapse">
                            <!-- <div class="avatar"><img class="mr-3 side-user-img" src="https://via.placeholder.com/110x110" alt="user avatar"></div> -->

                            <?php
                                $profileLogo = "";
                                 if(!is_null(Auth::user()->profile_pic) && Auth::user()->profile_pic != ""){
                                 $profileLogo = env("AWS_URL"). Auth::user()->profile_pic; ?>
                                 <div class="avatar"><img class="mr-3 side-user-img" src="{{$profileLogo}}" alt="user avatar"></div>
                               <?php } else{ ?>
                                    <div class="avatar"><img class="mr-3 side-user-img" src="https://via.placeholder.com/110x110" alt="user avatar"></div>
                               <?php } ?>

                            <div class="media-body">
                                <h6 class="side-user-name">{{ Auth::user()->name }} </h6>
                            </div>
                        </div>
                    </div>
                    <ul class="sidebar-menu do-nicescrol in">
                        <li class="sidebar-header">MAIN NAVIGATION</li>

                        <?php if(Auth::user()->user_type != 3) { ?>
                        <li>
                            <a href="{{ url('org/events') }}" class="waves-effect">
                                <i class="zmdi zmdi-view-dashboard"></i> <span>Events</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu in">
                                <li class="active"><a href="{{ url('org/events') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Upcoming Events</a></li>
                                <li class=""><a href="{{ url('org/events/new') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Add New Event</a></li>
                                <li class=""><a href="{{ url('org/pastEvents') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Past Events</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{url('org/videos')}}" class="waves-effect">
                                <i class="fa fa-file-video-o"></i> <span>Videos</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu in">
                                <li class="active"><a href="{{ url('org/videos/new') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Add New Video</a></li>
                                <li class=""><a href="{{ url('org/videos') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> All Videos</a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="{{url('org/podcasts')}}" class="waves-effect">
                                <i class="fa fa-headphones"></i> <span>Podcasts</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu in">
                                <li class="active"><a href="{{ url('org/podcasts/new') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Add New Podcast</a></li>
                                <li class=""><a href="{{ url('org/podcasts') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> All Podcasts</a></li>

                            </ul>
                        </li>

                        <li>
                            <a href="javaScript:void();" class="waves-effect">
                                <i class="fa fa-user-circle"></i> <span>Contacts</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <!-- zmdi zmdi-grid -->
                            <ul class="sidebar-submenu in">
                                <li class="active"><a href="{{ url('org/contacts/new') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Add New Contact</a></li>
                                <li class=""><a href="{{ url('org/my_contacts') }}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> All Contacts</a></li>
                                <li class=""><a href="{{url('org/csvImport')}}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> CSV Import</a></li>
                                <li class=""><a href="{{url('org/tags')}}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Tags</a></li>
                                <li class=""><a href="{{url('org/customFields')}}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Custom Fields</a></li>
                            </ul>
                        </li>

                        <!-- <li>
                            <a href="{{url('org/csvImport')}}" class="waves-effect">
                                <i class="fa fa-download"></i>
                                <span>CSV Import</span> -->
                                <!--<small class="badge float-right badge-warning">12</small>-->
                            <!-- </a>
                        </li> -->

                        <li>
                            <a href="javaScript:void();" class="waves-effect">
                                <i class="zmdi zmdi-email"></i>
                                <span>Communications</span>
                                <!--<small class="badge float-right badge-warning">12</small>-->
                            </a>
                        </li>

                        <li>
                            <a href="{{url('/')}}" class="waves-effect">
                                <i class="zmdi zmdi-format-list-bulleted"></i> <span>Forms</span><i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="sidebar-submenu in">
                                <li class="active"><a href="{{url('/')}}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Registration Form</a></li>
                                <li class=""><a href="{{url('/')}}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Feedback Form</a></li>
                                <li class=""><a href="{{url('/')}}" class="active"><i class="zmdi zmdi-long-arrow-right"></i> Custom Form</a></li>

                            </ul>
                        </li>

                       <?php } else { ?>

                            <li>
                                <a href="{{url('organizers')}}" class="waves-effect">
                                <i class="fa fa-user-circle mr-1"></i>
                                <span>Organizers</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{url('orgEvents')}}" class="waves-effect">
                                <i class="zmdi zmdi-view-dashboard"></i>
                                <span>Events</span>
                                </a>
                            </li>

                        <?php } ?>

                    </ul>

                </div>
            </div>
        </div>
        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top">
                <ul class="navbar-nav mr-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link toggle-menu" href="javascript:void();">
                            <i class="icon-menu menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form class="search-bar">
                            <input type="text" class="form-control" placeholder="Enter keywords">
                            <a href="javascript:void();"><i class="icon-magnifier"></i></a>
                        </form>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center right-nav-link">
                    <?php if(Auth::user()->user_type != 3) { ?>
                    <li class="nav-item">
                        <div class="mt-2"><button class="btn m-1 pull-right btn-primary"><a style="color:white;" href="{{url('org/pricingPlans')}}">Upgrade Plan</a></button></div>
                    </li>
                   <?php } ?>

                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret UserIconWithText" data-toggle="dropdown" href="#">
                            <?php if(Auth::user()->user_type != 3) { 
                                $totalGbData = number_format((float)$totalGb, 3, '.', ''); 
                                $outofspace = "";
                                $planChooseGB = "";
                                if(Auth::user()->plan_id == NULL){
                                    $outofspace = "out of 3GB";
                                    $planChooseGB = "3.000";
                                }
                                if(Auth::user()->plan_id == 1 || Auth::user()->plan_id == 2)  {
                                    $outofspace = "out of 10GB";
                                    $planChooseGB = "10.000";
                                }
                            ?>
                            <div class="mr-2 AvailableStorage">{{$totalGbData}} GB Used {{$outofspace}}</div>
                            <div class="mr-2 AvailableStorage"></div>
                            <input type="hidden" class="AvailableStorageValue" value ="{{$totalGbData}}">
                            <input type="hidden" class="planChooseGB" value ="{{$planChooseGB}}">
                            <input type="hidden" class="videoUrlCount" value="{{$videoUrlCount}}">
                            <input type="hidden" class="podcastUrlCount" value="{{$podcastUrlCount}}">

                            <?php } ?>
                            <div>
                                <!-- <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span> -->
                                <?php
                                $profileLogo = "";
                                 if(!is_null(Auth::user()->profile_pic) && Auth::user()->profile_pic != ""){
                                 $profileLogo = env("AWS_URL"). Auth::user()->profile_pic; ?>
                                <span class="user-profile"><img src="{{$profileLogo}}" class="img-circle" alt="user avatar"></span>
                               <?php } else{ ?>
                                    <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span>
                               <?php } ?>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <!-- <div class="avatar"><img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar"></div> -->
                                        <?php
                                $profileLogo = "";
                                 if(!is_null(Auth::user()->profile_pic) && Auth::user()->profile_pic != ""){
                                 $profileLogo = env("AWS_URL"). Auth::user()->profile_pic; ?>
                                 <div class="avatar"><img class="align-self-start mr-3" src="{{$profileLogo}}" alt="user avatar"></div>
                               <?php } else{ ?>
                                    <div class="avatar"><img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar"></div>
                               <?php } ?>

                                        <div class="media-body">
                                            <h6 class="mt-2 user-title">{{ Auth::user()->name }}</h6>
                                            <p class="user-subtitle">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <!-- <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
                                <li class="dropdown-divider"></li> -->
                            <li class="dropdown-item"><a style="color:inherit" href="{{url('org/profile')}}"><i class="icon-settings mr-2"></i> Profile</a></li>
                            <li class="dropdown-divider"></li>
                            <!-- <li class="dropdown-item"><a style="color:inherit" href="{{url('account')}}"><i class="icon-wallet mr-2"></i> Account</a></li> -->
                            <!-- <li class="dropdown-divider"></li> -->
                            <li class="dropdown-item"><a style="color:inherit" href="{{url('org/settings')}}"><i class="icon-settings mr-2"></i> Settings</a></li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><a class style="color:inherit" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="icon-power mr-2"></i> Logout</a></li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div class="clearfix"></div>
            <div class="content-wrapper">
                @yield('content')
            </div>
    </div>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/app-script.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
    <script src="{{asset('/js/customScript.js?v='.$v)}}" type="text/javascript"></script>
    <!-- Data Tables -->
    <!-- <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script> -->


    
    <!-- <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.print.min.js') }}"></script> -->
    <!-- <script src="{{ asset('assets/plugins/bootstrap-datatable/js/jszip.min.js') }}"></script> -->
    <!-- <script src="{{asset('assets/plugins/bootstrap-datatable/js/pdfmake.min.js')}}"></script> -->
    <!-- datetimepicker -->
    <!-- <script src="{{ asset('assets/plugins/datetimepicker-master/jquery.datetimepicker.js') }}"></script> -->
    <!--Multi Select Js-->
    <!-- <script src="{{ asset('assets/plugins/jquery-multi-select/jquery.multi-select.js') }}"></script> -->
    <script src="{{ asset('assets/plugins/jquery-multi-select/jquery.quicksearch.js') }}"></script>
    <!--Select Plugins Js-->
    <!-- <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script> -->
    <script>
        // $(document).ready(function() {
        //     $('.single-select').select2();

        //     $('.multiple-select').select2({
        //         placeholder: "Select categories",
        //         allowClear: true
        //     });
        //     var MultiSlectCounter = 0;
        //     $('.multiple-select').on('select2:select', function(e) {
        //         console.log(e.params.data.id);
        //         if (MultiSlectCounter == 0) {
        //             $('#HiddenCategoyID').append(e.params.data.id);
        //         } else {
        //             $('#HiddenCategoyID').append("," + e.params.data.id);
        //         }

        //         MultiSlectCounter += 1;
        //     });
        //     $('.multiple-select').on('select2:unselecting', function(e) {
        //         console.log(e.params.args.data.id);
        //         var str = $('#HiddenCategoyID').val();
        //         var res = str.replace(e.params.args.data.id, "");
        //         $('#HiddenCategoyID').empty();
        //         $('#HiddenCategoyID').append(res);
        //     });


        //     //multiselect start

        //     $('#my_multi_select1').multiSelect();
        //     $('#my_multi_select2').multiSelect({
        //         selectableOptgroup: true
        //     });

        //     $('#my_multi_select3').multiSelect({
        //         selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        //         selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        //         afterInit: function(ms) {
        //             var that = this,
        //                 $selectableSearch = that.$selectableUl.prev(),
        //                 $selectionSearch = that.$selectionUl.prev(),
        //                 selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
        //                 selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

        //             that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
        //                 .on('keydown', function(e) {
        //                     if (e.which === 40) {
        //                         that.$selectableUl.focus();
        //                         return false;
        //                     }
        //                 });

        //             that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
        //                 .on('keydown', function(e) {
        //                     if (e.which == 40) {
        //                         that.$selectionUl.focus();
        //                         return false;
        //                     }
        //                 });
        //         },
        //         afterSelect: function() {
        //             this.qs1.cache();
        //             this.qs2.cache();
        //         },
        //         afterDeselect: function() {
        //             this.qs1.cache();
        //             this.qs2.cache();
        //         }
        //     });

        //     $('.custom-header').multiSelect({
        //         selectableHeader: "<div class='custom-header'>Selectable items</div>",
        //         selectionHeader: "<div class='custom-header'>Selection items</div>",
        //         selectableFooter: "<div class='custom-header'>Selectable footer</div>",
        //         selectionFooter: "<div class='custom-header'>Selection footer</div>"
        //     });


        // });
    </script>
    @yield('script')

</body>

</html>