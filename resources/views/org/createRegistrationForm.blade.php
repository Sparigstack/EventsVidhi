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

/*.formDivQue .NewQueForm:last-of-type hr {
display: none;
}*/
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
    $idcnt = "2";

    if (!empty($regForm)) {
        $ActionCall = url('org/regForm/edit/' . $regForm->id);
        $CardTitle = "Edit Registration Form";
        $title = $regForm->title;
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

                    <div id="newQuestionField0" class="parent form-group col-lg-12 NewQueForm d-none" id="NewQueForm" name="NewQueForm">

                        <!-- <div class="parent regDiv"> -->

                            <div class="mb-3">
                                <label for="Question">Question</label>
                                <input id="question" type="text" name="question" class="form-control question" title="Question" placeholder="Question" autocomplete="off" rows="0" value="{{$question}}">
                            </div>

                            <div class="mb-3">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" class="IsRequired" id="IsRequired1" name="IsRequired">
                                    <label for="IsRequired1">Required</label>
                                </div>
                            </div>

                            <select autocomplete="off" value="" name="regFormsSelect" id="regFormsSelect" class="custom-select regFormsSelect" onchange="checkSelectionValue(this);" required="">
                                <option value="1"> Short Answer </option>
                                <option value="2"> Single Answer </option>
                                <option value="3"> Multiple Answers </option>
                            </select>

                        <div class="answerDiv d-none mt-3">
                            <label for="Question" class="mb-0">Answer Values</label>
                            <p style="font-size: 13px;">[Note: If you have value in the textbox and hit enter, you can add more answer values.]</p>
                            <input id="answerVal" type="text" name="answerVal" class="form-control answerVal mb-4" title="Answer Values" placeholder="Answer Values" autocomplete="off" rows="0" value="" onkeyup="setMultipleAnswerValues(this,event);">
                            <select multiple="multiple" class="form-control multiple-select1 multipleAnsVal" name="multipleAnsVal" id="multiple-select" placeholder="" onchange="return removeAnswerValues(this);"></select>
                                <textarea id="hiddenAnswerValues" name="hiddenAnswerValues" class="form-control d-none hiddenAnswerValues" title="hiddenAnswerValues" placeholder="hiddenAnswerValues" autocomplete="off" rows="4"></textarea>
                        </div>

                    <!-- </div> -->

                    </div>

                    <form class="parent formDivQue" action="" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <!-- {{$ActionCall}} -->
                    <div class="form-group col-lg-12 mb-3">
                        <label for="RegTitle">Registration Title</label>
                        <input id="RegTitle" type="text" name="RegTitle" class="form-control RegTitle" title="Registration Title" placeholder="Registration Title" autocomplete="off" rows="0" value="{{$title}}" required="">
                    </div>
                   
                    @if(count($regFormInput) > 0 && strpos($_SERVER['REQUEST_URI'], '/new') !== true && isset($regForm))
                    <?php 
                        $cnt = 0;
                        $horizontalLineAdd = "";
                        $posts_count = $regFormInput->count();;
                    ?>
                        @foreach($regFormInput as $key => $regFormInputs)   
                        <?php 
                            $question = $regFormInputs->question;

                            if($regFormInputs->is_inputRequired == 1){
                                $isRequired = "checked";
                            } else {
                                $isRequired = "";
                            }
                        ?>  
                    <input type="hidden" class="regFormId" value="{{$regForm->id}}"> 
                    <!-- <div class="form-group col-lg-12 questionAnsDiv"> -->
                    <div id="newQuestionField" class="parent form-group col-lg-12 NewQueForm" id="NewQueForm" name="NewQueForm">

                        <input type="hidden" class="deleteQue" value="{{url('deleteThisQue')}}">

                        {{ csrf_field() }}
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <!-- <div class="parent regDiv"> -->

                            <div class="mb-3">
                                <label for="Question">Question</label>
                                <input id="question" type="text" name="question" class="form-control question" title="Question" placeholder="Question" autocomplete="off" rows="0" value="{{$question}}">
                            </div>

                            <div class="mb-3">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" class="IsRequired" id="IsRequired{{$idcnt}}" name="IsRequired" {{$isRequired}}>
                                    <label for="IsRequired{{$idcnt}}">Required</label>
                                </div>
                            </div>

                            <select autocomplete="off" value="" name="regFormsSelect" id="regFormsSelect" class="custom-select regFormsSelect" onchange="checkSelectionValue(this);" required="">
                                <?php 
                                    $selected1 = "";
                                    $selected2 = "";
                                    $selected3 = "";
                                    $dNoneAnswer = "d-none";
                                    $answerValuesDB = "";
                                    $hiddenAnswerValuesDB = "";
                                    if (!empty($regForm)) {
                                        if($regFormInputs->answer_type == 1){
                                            $selected1 = "selected";
                                        } else if($regFormInputs->answer_type == 2){
                                            $selected2 = "selected";
                                            $dNoneAnswer = "";
                                        } if($regFormInputs->answer_type == 3){
                                            $selected3 = "selected";
                                            $dNoneAnswer = "";
                                        }
                                        $answerValuesDB = explode("@~@", $regFormInputs->answer_values);
                                        $hiddenAnswerValuesDB = str_replace("@~@", ",", $regFormInputs->answer_values); 
                                    }
                                ?>
                                <option {{$selected1}} value="1"> Short Answer </option>
                                <option {{$selected2}} value="2"> Single Answer </option>
                                <option {{$selected3}} value="3"> Multiple Answers </option>
                            </select>

                        <div class="answerDiv {{$dNoneAnswer}} mt-3">
                            <label class="mb-0" for="Question">Answer Values</label>
                            <p style="font-size: 13px;">[Note: If you have value in the textbox and hit enter, you can add more answer values.]</p>
                            <input id="answerVal" type="text" name="answerVal" class="form-control answerVal mb-4" title="Answer Values" placeholder="Answer Values" autocomplete="off" rows="0" value="" onkeyup="setMultipleAnswerValues(this,event);">
                            <select multiple="multiple" class="form-control multiple-select multipleAnsVal" name="multipleAnsVal" id="" placeholder=""> 
                                <!-- multipleAnsVal -->
                                <?php if ($regFormInputs->answer_values != "") { ?>
                                @foreach($answerValuesDB as $answerValueDB)
                                    <option selected="selected">{{$answerValueDB}}</option>
                                @endforeach
                                <?php } ?>
                                </select>
                                <textarea id="hiddenAnswerValues" name="hiddenAnswerValues" class="form-controld d-none hiddenAnswerValues" title="hiddenAnswerValues" placeholder="hiddenAnswerValues" autocomplete="off" rows="4">{{$hiddenAnswerValuesDB}}</textarea>
                        </div>

                        <!-- <div class="delQue">
                            <a style="cursor: pointer;" id="RemoveImgBtn" onclick="deleteThisQue(this);" class="mt-2 pull-right" db-delete-id="{{$regFormInputs->id}}"> Delete Question </a>
                        </div> -->

                    <!-- </div> -->

                    </div>

                    @if ($key + 1 != $posts_count)
                        <hr class='mt-4 mb-4'>
                    @endif
                    <?php
                        $idcnt++; 
                    ?>
                    @endforeach
                    @else
                            <div id="newQuestionField" class="parent form-group col-lg-12 NewQueForm" id="NewQueForm" name="NewQueForm">

                        <!-- <div class="parent regDiv"> -->

                            <div class="mb-3">
                                <label for="Question">Question</label>
                                <input id="question" type="text" name="question" class="form-control question" title="Question" placeholder="Question" autocomplete="off" rows="0" value="{{$question}}">
                            </div>

                            <div class="mb-3">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" class="IsRequired" id="IsRequired0" name="IsRequired">
                                    <label for="IsRequired0">Required</label>
                                </div>
                            </div>

                            <select autocomplete="off" value="" name="regFormsSelect" id="regFormsSelect" class="custom-select regFormsSelect" onchange="checkSelectionValue(this);" required="">
                                <option value="1"> Short Answer </option>
                                <option value="2"> Single Answer </option>
                                <option value="3"> Multiple Answers </option>
                            </select>

                        <div class="answerDiv d-none mt-3">
                            <label class="mb-0" for="Question">Answer Values</label>
                            <p style="font-size: 13px;">[Note: If you have value in the textbox and hit enter, you can add more answer values.]</p>
                            <input id="answerVal" type="text" name="answerVal" class="form-control answerVal mb-4" title="Answer Values" placeholder="Answer Values" autocomplete="off" rows="0" value="" onkeyup="setMultipleAnswerValues(this,event);">
                            <select multiple="multiple" class="form-control multiple-select multipleAnsVal" name="multipleAnsVal" id="multiple-select" placeholder=""></select>
                                <textarea id="hiddenAnswerValues" name="hiddenAnswerValues" class="form-control d-none hiddenAnswerValues" title="hiddenAnswerValues" placeholder="hiddenAnswerValues" autocomplete="off" rows="4"></textarea>
                        </div>

                    <!-- </div> -->

                    </div>
                    @endif

                    <div class="form-group col-lg-12 ">
                        <button type="button" class="btn btn-outline-primary waves-effect waves-light m-1 newQuestionButton"> <i class="fa fa-plus-circle"></i> <span>Add New Question</span> </button>
                    </div>

                        
                        <div class="form-group col-lg-12">
                        <button id="btnSaveVideo" class="btn btn-primary px-5 pull-right" name="submit" onclick="return saveMultipleQuestions(this);">Save Registration Form</button>
                    </div>
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
    $(function() {
        $(".newQuestionButton").click(function (e) {
            var newQuestionField0 = $("#newQuestionField0");
            var newForm = $(newQuestionField0).clone().val('');
            var number = Math.floor(Math.random() * 999);
            $(newForm).attr('id', "newQuestionField" + number);

            // answerVal, hiddenAnswerValues, multipleAnsVal
            var a = $(newForm).find("#answerVal");
            $(a).attr('id', "answerVal" + number);
            var b = $(newForm).find("#hiddenAnswerValues");
            $(b).attr('id', "hiddenAnswerValues" + number);

            var c = $(newForm).find(".multiple-select1");
            $(c).attr('id', "multiple-select1" + number);
            $(c).select2();

            var d = $(newForm).find(".icheck-material-primary").find("#IsRequired1");
            $(d).attr('id', "IsRequired" + number);
            var e = $(newForm).find(".icheck-material-primary").find("label");
            $(e).attr('for', "IsRequired" + number);

            // var c = $(newForm).find("#multipleAnsVal");
            // $(c).attr('id', "multipleAnsVal" + number);
            //$(newForm).find(".multiple-select").select2();

            $(newForm).removeClass('d-none');
            $(this).parent().before(newForm);
            $(newForm).before("<hr class='mt-4 mb-4'>");
        });

        // $('.multiple-select1').each(function(element) {
        //     $(this).on('select2:unselecting', function(e) {
        //     var str = $(this).parent().find('.hiddenAnswerValues').text();
        //     var search = e.params.args.data.id;

        //     var res = str.replace(e.params.args.data.id, "");
        //     $(this).parent().find('.hiddenAnswerValues').text("");
        //     $(this).parent().find('.hiddenAnswerValues').append(res);
        //      });

        // });

    });

    $(document).ready(function() {

        $('.multiple-select').select2();
        //$('#multiple-select1').select2();

        // $('.select2-dropdown').css('display','none');
        // $('.select2-selection__rendered').css('height','100px !important');
        

        // $('.multiple-select').select2({
        //     placeholder: "Select Values",
        //     allowClear: true
        // });

        
        //var MultiSlectCounter = 0;

        $('.multiple-select').on('select2:unselecting', function(e) {
            var str = $(this).parent().find('.hiddenAnswerValues').text();
            var search = e.params.args.data.id;

            var res = str.replace(e.params.args.data.id, "");
            $(this).parent().find('.hiddenAnswerValues').text("");
            $(this).parent().find('.hiddenAnswerValues').append(res);
        });

    });
</script>
@endsection