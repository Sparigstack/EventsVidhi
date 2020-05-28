@extends('layouts.appOrg')
@section('content')

<div class="container-fluid">
    <?php
    $ActionCall = url('org/tags/store');
    ?>
    <div class="Data-Table">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                       <i class="fa fa-table pt-3"></i> All Tags
                    </div>
                    <div class="card-body">
                        <form class="" id="tagsForm" action="{{$ActionCall}}" method="post" >
                        <input type="hidden" class="addTags" value="{{url('org/tags/store')}}">
                        {{ csrf_field() }}
                        <div class='form-group col-lg-4'>
                            <label for='tagName'>Tags</label>
                            <input type="text" class="form-control" id="tagName" name='tagName' value="{{  old('tagName') }}" required>
                            <small class="text-danger tagInvalid"></small>
                        </div>

                        <div class="form-group col-lg-12">

                            <select multiple="multiple" class="form-control multiple-select" name="allTags" id="allTags" placeholder="">
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}" selected="selected">{{$tag->name}} </option>
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
