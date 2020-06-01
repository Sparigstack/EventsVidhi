@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php
    $ActionCall = url('org/csv/import');
    $RedirectCall = "";

    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5>User Settings</h5>
                    </div>
                    <hr>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif


                    {{ csrf_field() }}
                    <input type="hidden" id="urlToCall" class="urlToCall" value="{{ url('org/setting/update')}}" />
                    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <div class="parent" style="width: 100%;">
                        <div class="form-group col-lg-4">
                            <label for="CsvFile">Username</label>
                            <div class="">
                                <input type="text" id="Username" name="Username" data_type="username" class="form-control" value="{{$user->username}}" onchange="SaveUserSetting(this)">

                            </div>
                            <small class="text-danger usernameExist"></small>
                        </div>
                    </div>

                    <div class="icheck-material-info icheck-inline col-lg-6">
                        <?php $IsChecked = "";
                        if ($user->auto_approve_follower) {
                            $IsChecked = "checked";
                        }
                        ?>
                        <input type="checkbox" id="AutoApproveFollower" {{$IsChecked}} name="AutoApproveFollower" data_type="AutoAproveFollower" onchange="SaveUserSetting(this)">
                        <label for="AutoApproveFollower">Auto approve follower's</label>
                    </div>

                </div>
            </div>
        </div>

    </div>
    @endsection

    @section('script')
    <script src="{{asset('/js/settings.js')}}" type="text/javascript"></script>

    @endsection