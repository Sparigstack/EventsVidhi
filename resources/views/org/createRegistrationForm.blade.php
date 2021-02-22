<?php $v = "1.0.1"; ?>
@extends('layouts.appOrg')
@section('css')
<link href="{{ asset('assets/plugins/jquery-multi-select/multi-select.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<!-- Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
.select2-dropdown {
    display: none !important;
}
.select2-selection__rendered{
    height: 100px !important;
}

.select2-container--default .select2-selection--multiple{
    height: auto !important;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <?php
    $CardTitle = "Add Registration Form";
    $ActionCall = url('org/regForm/store');
    $RedirectCall = url('org/regForms');
    $title = "";
    $question = "";
    $isRequired = "";

    if (!empty($regForm)) {
        $ActionCall = url('org/regForm/edit/' . $regForm->id);
        $CardTitle = "Edit Registration Form";
        $title = $regForm->title;
        $question = $regFormInput->question;

        if($regFormInput->is_inputRequired == 1){
            $isRequired = "checked";
        }
    }
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5>{{$CardTitle}}</h5>
                    </div>
                    <hr>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form class="parent" action="{{$ActionCall}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group col-lg-12 regDiv">
                            <div class="mb-3">
                                <label for="RegTitle">Registration Title</label>
                                <input id="RegTitle" type="text" name="RegTitle" class="form-control RegTitle" title="Registration Title" placeholder="Registration Title" autocomplete="off" rows="0" value="{{$title}}" required="">
                            </div>

                            <div class="mb-3">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" id="IsRequired" name="IsRequired" {{$isRequired}}>
                                    <label for="IsRequired">Required</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="Question">Question</label>
                                <input id="question" type="text" name="question" class="form-control question" title="Question" placeholder="Question" autocomplete="off" rows="0" value="{{$question}}" required="">
                            </div>

                            <select autocomplete="off" value="" name="regFormsSelect" id="regFormsSelect" class="custom-select" onclick="checkSelectionValue(this);" required="">
                                <?php 
                                    $selected1 = "";
                                    $selected2 = "";
                                    $selected3 = "";
                                    $dNoneAnswer = "d-none";
                                    $answerValuesDB = "";
                                    $hiddenAnswerValuesDB = "";
                                    if (!empty($regForm)) {
                                        if($regFormInput->answer_type == 1){
                                            $selected1 = "selected";
                                        } else if($regFormInput->answer_type == 2){
                                            $selected2 = "selected";
                                            $dNoneAnswer = "";
                                        } if($regFormInput->answer_type == 3){
                                            $selected3 = "selected";
                                            $dNoneAnswer = "";
                                        }
                                        $answerValuesDB = explode("@~@", $regFormInput->answer_values);
                                        $hiddenAnswerValuesDB = str_replace("@~@", ",", $regFormInput->answer_values); 
                                    }
                                ?>
                                <option {{$selected1}} value="1"> Single Answer </option>
                                <option {{$selected2}} value="2"> Multiple Answer </option>
                                <option {{$selected3}} value="3"> Custom Answer </option>
                            </select>
                        </div>

                        <div class="form-group col-lg-12 answerDiv {{$dNoneAnswer}}">
                            <label for="Question">Answer Values</label>
                            <input id="answerVal" type="text" name="answerVal" class="form-control answerVal mb-4" title="Answer Values" placeholder="Answer Values" autocomplete="off" rows="0" value="">
                            <select multiple="multiple" class="form-control multiple-select" name="multipleAnsVal" id="multipleAnsVal" placeholder=""> 
                                <?php if (!empty($regForm)) { ?>
                                @foreach($answerValuesDB as $answerValueDB)
                                    <option selected="selected">{{$answerValueDB}}</option>
                                @endforeach
                                <?php } ?>
                                </select>
                                <textarea id="hiddenAnswerValues" name="hiddenAnswerValues" required class="form-controld d-none" title="hiddenAnswerValues" placeholder="hiddenAnswerValues" autocomplete="off" rows="4">{{$hiddenAnswerValuesDB}}</textarea>
                        </div>
                        
                        <button id="btnSaveVideo" class="btn btn-primary px-5 pull-right" type="submit">Save Registration Form</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-6"> -->
            <!-- <div class="card">
                <div class="card-header listItemsBottomBorder border-bottom-0">Recently Added Forms
                </div>

                <ul class="list-group list-group-flush shadow-none">

                </ul>
        </div> -->
    <!-- </div> -->
</div>
@endsection

@section('script')
<!-- Data Tables -->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js')}}"></script>

<script src="{{ asset('assets/plugins/jquery-multi-select/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{asset('/js/regForms.js?v='.$v)}}" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $('.single-select').select2();

        $('.select2-dropdown').css('display','none');
        $('.select2-selection__rendered').css('height','100px !important');
        

        $('.multiple-select').select2({
            placeholder: "Select Values",
            allowClear: true
        });

        
        var MultiSlectCounter = 0;

        $('.multiple-select').on('select2:unselecting', function(e) {
            var str = $('#hiddenAnswerValues').text();
            var search = e.params.args.data.id;

            var res = str.replace(e.params.args.data.id, "");
            $('#hiddenAnswerValues').empty();
            $('#hiddenAnswerValues').append(res);

            // $('.select2-selection__choice').each(function() {
            //     if(trim == $(this).attr('title')){
            //         tagId = $(this).val();
            //     }
            // });

            // str.split(',').forEach(function(host) {
            //     if (search.indexOf(host) != -1) {
            //         var res = str.replace(search, "");
            //         //res.replace(/[, ]+/g, " ").trim();
            //         $('#hiddenAnswerValues').empty();
            //         $('#hiddenAnswerValues').append(res);
            //     }
            // });
        });

    });
</script>
@endsection