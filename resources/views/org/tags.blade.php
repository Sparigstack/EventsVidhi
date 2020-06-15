@extends('layouts.appOrg')
@section('css')
<link href="{{ asset('assets/plugins/jquery-multi-select/multi-select.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
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
    $ActionCall = url('org/tags/store');
    ?>
    <div class="Data-Table">
    <input type="hidden" id="deleteTag" class="deleteTag" value="{{url('org/tags/delete')}}" />
    <input type="hidden" class="contactPage" value="{{url('org/my_contacts')}}" />
    <input class="csrf-token" type="hidden" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-table pt-3"></i> All Tags
                    </div>
                    <div class="card-body">
                        <form class="row tagsForm" id="tagsForm" action="{{$ActionCall}}" method="post">
                            <input type="hidden" class="addTags" value="{{url('org/tags/store')}}">
                            {{ csrf_field() }}
                            <div class='form-group col-lg-4'>
                                <label for='tagName'>Add New Tags</label>
                                <input type="text" class="form-control" id="tagName" name='tagName' value="{{  old('tagName') }}" required>
                                <small class="text-danger tagInvalid"></small>
                            </div>
                            <div class="col-lg-2 pt-4 mt-2 pl-0"><button type="submit" class="btn btn-primary">Save Tag</button></div>

                            <div class="form-group col-lg-12 mt-2">

                                <select multiple="multiple" class="form-control multiple-select" name="allTags" id="allTags" placeholder="">
                                    @foreach($tags as $tag)
                                    <option value="{{$tag->id}}" selected="selected" tagName="{{$tag->name}}">{{$tag->name}} </option>
                                    @endforeach
                                </select>
                                <textarea id="HiddenCategoyID" name="HiddenCategoyID" required class="form-controld d-none" title="HiddenCategoyID" placeholder="HiddenCategoyID" autocomplete="off" rows="4">{{ old('HiddenCategoyID') }} </textarea>

                                <!-- <textarea id="allTags" name="allTags" class="form-control" autocomplete="off" rows="4">
                                @foreach($tags as $tag)
                                {{$tag->name}}
                                @endforeach
                            </textarea> -->
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@section('script')

<script src="{{asset('/js/ContactAndTag.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-multi-select/jquery.multi-select.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Data Tables -->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.single-select').select2();

        $('.select2-dropdown').css('display','none');
        $('.select2-selection__rendered').css('height','100px !important');
        

        $('.multiple-select').select2({
            placeholder: "Select tags",
            allowClear: true
        });

        
        var MultiSlectCounter = 0;
        $('.multiple-select').on('select2:select', function(e) {
            // console.log(e.params.data.id);
            if (MultiSlectCounter == 0) {
                $('#HiddenCategoyID').append(e.params.data.id);
            } else {
                $('#HiddenCategoyID').append("," + e.params.data.id);
            }

            MultiSlectCounter += 1;
        });

        $('.select2-selection__choice').on('click', function(e) {
            // console.log(e.params.args.data.id);
            var urlString = $(".contactPage").val();
            var tagName = $(this).attr('title');
            var trim = $.trim(tagName);
            var tagId = "";
            $('.multiple-select option').each(function() {
                if(trim == $(this).attr("tagName")){
                    tagId = $(this).val();
                }
            });
            window.location.href = urlString + '/' + tagId;
        });

        $('.multiple-select').on('select2:unselecting', function(e) {
            var confirmDelete = confirm("Are you sure want to remove this Tag from all Contacts and delete permanently?");
            if (!confirmDelete){
                return false;
            }
            var tagID = e.params.args.data.id;
            //alert(tagID);
           // var parent = findParent(element);
            var tagDeleteId = tagID;
            var CSRF_TOKEN = $('.csrf-token').val();
            var urlString = $('.deleteTag').val();
            urlString+="/"+tagID;
            $.ajax({
                url: urlString,
                type: 'post',
                data: {
                    _token: CSRF_TOKEN,
                    tagDeleteId: tagDeleteId
                },
                success: function(response) {
                    // console.log(response);
                 //   location.reload();
                }
            });

            console.log(e.params.args.data.id);
            var str = $('#HiddenCategoyID').val();
            var res = str.replace(e.params.args.data.id, "");
            $('#HiddenCategoyID').empty();
            $('#HiddenCategoyID').append(res);

        });


        //multiselect start

        $('#my_multi_select1').multiSelect();
        $('#my_multi_select2').multiSelect({
            selectableOptgroup: true
        });

        $('#my_multi_select3').multiSelect({
            selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function(ms) {
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e) {
                        if (e.which === 40) {
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e) {
                        if (e.which == 40) {
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
            },
            afterSelect: function() {
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function() {
                this.qs1.cache();
                this.qs2.cache();
            }
        });

        $('.custom-header').multiSelect({
            selectableHeader: "<div class='custom-header'>Selectable items</div>",
            selectionHeader: "<div class='custom-header'>Selection items</div>",
            selectableFooter: "<div class='custom-header'>Selectable footer</div>",
            selectionFooter: "<div class='custom-header'>Selection footer</div>"
        });


    });

    (function() {

        var bar = $('.bar_upload');
        var percent = $('.percent_upload');
        //var status = $('#status');

        $('.tagsForm').ajaxForm({
            beforeSend: function() {
                LoaderStart();
            },
            success: function(response) {
                if (response.error != '') {
                    $('.tagInvalid').append(response.error.tagName);
                    alert(response.error.tagName);
                    LoaderStop();
                } else {
                    $("#tagName").val('');
                    // $("#allTags").append(response.tagName);
                    $("#allTags").append('<option value="' + response.id + '" selected="selected">' + response.tagName + '</option>');
                    LoaderStop();
                }
            }
        });

    })();
</script>

@endsection