@extends('layouts.appOrg')

@section('content')
<div class="container-fluid">
    <?php
    $ActionCall = url('org/csv/import');
    $RedirectCall = "";
    ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5>CSV IMPORT</h5>
                    </div>
                    <hr>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form class="CsvImportForm" action="{{$ActionCall}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" id="hdnRedirect" value="{{$RedirectCall}}" />

                        <div class='parent' style='width: 100%;'>
                            <div class='form-group '>
                                <label class="w-100" for='CsvFile'>Upload CSV <span class="CsvUploadInfo">Oreder Should be like First Name, Last Name, Email, Contact Number {{$customFieldOrder}}</span></label>
                                <div class='dragFileContainer'>
                                    <input type="file" id='CsvFile' name='CsvFile' value="{{  old('CsvFile') }}" style="height: 44%" required>
                                    <p>Drag your CSV file here or click in this area.</p>
                                </div>
                                <small class="text-danger">{{ $errors->first('CsvFile') }}</small>
                            </div>
                            <div class="form-group progressBar ">
                                <div class="progress_upload">
                                    <div class="bar_upload"></div>
                                    <div class="percent_upload">0%</div>
                                </div>
                            </div>
                        </div>


                        <button class="btn btn-primary px-5 pull-right" type="submit">Upload</button>
                    </form>

                </div>
            </div>
        </div>

    </div>
    @endsection

    @section('script')
    <script>
        $(document).ready(function() {
            $('.dragFileForm input').change(function() {
                $('.dragFileForm p').text(this.files.length + " file(s) selected");
            });
        });

        (function() {

            var bar = $('.bar_upload');
            var percent = $('.percent_upload');
            //var status = $('#status');

            $('.CsvImportForm').ajaxForm({
                beforeSend: function() {
                    LoaderStart();
                    //status.empty();
                    var percentVal = '0%';
                    var posterValue = $('input[name=CsvFile]').fieldValue();
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                    // if (percentComplete == 100) {
                    //     LoaderStart();
                    //     var interval = setInterval(function mak() {
                    //         clearInterval(interval);
                    //         window.location.href = $('#hdnRedirect').val();
                    //         LoaderStop();
                    //     }, 5000);
                    //     // window.location.href = $('#hdnRedirect').val();
                    // }
                    // LoaderStart();
                },
                success: function (response) {
                    LoaderStop();
                    console.log(response);
                    alert('Contacts are saved');
                },
                complete: function (xhr) {
                    //status.html(xhr.responseText);
                    //alert('Uploaded Successfully');

                   // window.location.href = $('#hdnRedirect').val();
                },
                error: function (response) {
                    LoaderStop();
                    console.log(response);
                }
            });

        })();
    </script>

    @endsection