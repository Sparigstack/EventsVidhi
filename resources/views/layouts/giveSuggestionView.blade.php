@if(isset($section))
	<h5 style="padding: 0px 40px;"> Interesting for you? </h5>

	<?php 
        $smileyCard1 = "smileyCard";
        $smileyCard2 = "smileyCard";
        $smileyCard3 = "smileyCard";
        $checkVal1 = "";
        $checkVal2 = "";
        $checkVal3 = "";
        if(Auth::check()){
            foreach($suggestionsList as $suggestionList){
               if(Auth::user()->id == $suggestionList->user_id && $section->id == $suggestionList->content_id && $suggestionList->discriminator == "e"){
                	if($suggestionList->suggestion_id == 1){
                        $smileyCard1 = "smileyCardColor";
                        $checkVal1 = "1";
                   }
                 	if($suggestionList->suggestion_id == 2){
                       $smileyCard2 = "smileyCardColor";
                       $checkVal2 = "1";
                    }
                    if($suggestionList->suggestion_id == 3){
                        $smileyCard3 = "smileyCardColor";
                        $checkVal3 = "1";
                    }
                }
            }
        }
    ?>

    <div class="row pt-2 mb-4" style="padding: 0px 55px;">
        <div class="card mb-0 mr-3 {{$smileyCard1}} h-25" style="">
            <a style="cursor:pointer;" onclick="saveUserSuggestions(this);" data-id="1" data-content-id="{{$section->id}}" discriminator="e" value="{{$checkVal1}}">
            	<div class="card-body pt-0 pb-0 row pl-4 mr-1">
                	<p class="smileyCountDiv mb-0" style="" class="mb-0">&#128516; </p>&nbsp;<p class="pt-3"> ({{$suggestionsListCountResult1}})</p>
           		</div>
            </a>
        </div>

        <div class="card mb-0 mr-3 {{$smileyCard2}} h-25" style="">
            <a style="cursor:pointer;" onclick="saveUserSuggestions(this);" data-id="2" data-content-id="{{$section->id}}" discriminator="e" value="{{$checkVal2}}">
                <div class="card-body pt-0 pb-0 row pl-4 mr-1">
                     <p class="smileyCountDiv mb-0" style="" class="mb-0">&#128578; </p>&nbsp;<p class="pt-3"> ({{$suggestionsListCountResult2}})</p>
               	</div>
            </a>
        </div>

        <div class="card mb-0 {{$smileyCard3}} h-25" style="">
            <a style="cursor:pointer;" onclick="saveUserSuggestions(this);" data-id="3" data-content-id="{{$section->id}}" discriminator="e" value="{{$checkVal3}}">
                <div class="card-body pt-0 pb-0 row pl-4 mr-1">
                     <p class="smileyCountDiv mb-0" style="" class="mb-0">&#128528; </p>&nbsp;<p class="pt-3"> ({{$suggestionsListCountResult3}})</p>
                </div>
            </a>
        </div>
    </div>

@endif

@if(isset($sectionvideo))
	<h5 style="padding: 0px 40px;"> Helpful for you? </h5>

	<?php 
        $smileyCard1 = "smileyCard";
        $smileyCard2 = "smileyCard";
        $smileyCard3 = "smileyCard";
        $checkVal1 = "";
        $checkVal2 = "";
        $checkVal3 = "";
        if(Auth::check()){
            foreach($suggestionsList as $suggestionList){
               if(Auth::user()->id == $suggestionList->user_id && $sectionvideo->id == $suggestionList->content_id && $suggestionList->discriminator == "v"){
                	if($suggestionList->suggestion_id == 1){
                        $smileyCard1 = "smileyCardColor";
                        $checkVal1 = "1";
                   }
                 	if($suggestionList->suggestion_id == 2){
                       $smileyCard2 = "smileyCardColor";
                       $checkVal2 = "1";
                    }
                    if($suggestionList->suggestion_id == 3){
                        $smileyCard3 = "smileyCardColor";
                        $checkVal3 = "1";
                    }
                }
            }
        }
    ?>

    <div class="row pt-2 mb-4" style="padding: 0px 55px;">
        <div class="card mb-0 mr-3 {{$smileyCard1}} h-25" style="">
            <a style="cursor:pointer;" onclick="saveUserSuggestions(this);" data-id="1" data-content-id="{{$sectionvideo->id}}" discriminator="v" value="{{$checkVal1}}">
            	<div class="card-body pt-0 pb-0 row pl-4 mr-1">
                	<p class="smileyCountDiv mb-0" style="" class="mb-0">&#128516; </p>&nbsp;<p class="pt-3"> ({{$suggestionsListCountResult1}})</p>
           		</div>
            </a>
        </div>

        <div class="card mb-0 mr-3 {{$smileyCard2}} h-25" style="">
            <a style="cursor:pointer;" onclick="saveUserSuggestions(this);" data-id="2" data-content-id="{{$sectionvideo->id}}" discriminator="v" value="{{$checkVal2}}">
                <div class="card-body pt-0 pb-0 row pl-4 mr-1">
                     <p class="smileyCountDiv mb-0" style="" class="mb-0">&#128578; </p>&nbsp;<p class="pt-3"> ({{$suggestionsListCountResult2}})</p>
               	</div>
            </a>
        </div>

        <div class="card mb-0 {{$smileyCard3}} h-25" style="">
            <a style="cursor:pointer;" onclick="saveUserSuggestions(this);" data-id="3" data-content-id="{{$sectionvideo->id}}" discriminator="v" value="{{$checkVal3}}">
                <div class="card-body pt-0 pb-0 row pl-4 mr-1">
                     <p class="smileyCountDiv mb-0" style="" class="mb-0">&#128528; </p>&nbsp;<p class="pt-3"> ({{$suggestionsListCountResult3}})</p>
                </div>
            </a>
        </div>
    </div>

@endif

@if(isset($sectionpodcast))
	<h5 style="padding: 0px 40px;"> Helpful for you? </h5>

	<?php 
        $smileyCard1 = "smileyCard";
        $smileyCard2 = "smileyCard";
        $smileyCard3 = "smileyCard";
        $checkVal1 = "";
        $checkVal2 = "";
        $checkVal3 = "";
        if(Auth::check()){
            foreach($suggestionsList as $suggestionList){
               if(Auth::user()->id == $suggestionList->user_id && $sectionpodcast->id == $suggestionList->content_id && $suggestionList->discriminator == "p"){
                	if($suggestionList->suggestion_id == 1){
                        $smileyCard1 = "smileyCardColor";
                        $checkVal1 = "1";
                   }
                 	if($suggestionList->suggestion_id == 2){
                       $smileyCard2 = "smileyCardColor";
                       $checkVal2 = "1";
                    }
                    if($suggestionList->suggestion_id == 3){
                        $smileyCard3 = "smileyCardColor";
                        $checkVal3 = "1";
                    }
                }
            }
        }
    ?>

    <div class="row pt-2 mb-4" style="padding: 0px 55px;">
        <div class="card mb-0 mr-3 {{$smileyCard1}} h-25" style="">
            <a style="cursor:pointer;" onclick="saveUserSuggestions(this);" data-id="1" data-content-id="{{$sectionpodcast->id}}" discriminator="p" value="{{$checkVal1}}">
            	<div class="card-body pt-0 pb-0 row pl-4 mr-1">
                	<p class="smileyCountDiv mb-0" style="" class="mb-0">&#128516; </p>&nbsp;<p class="pt-3"> ({{$suggestionsListCountResult1}})</p>
           		</div>
            </a>
        </div>

        <div class="card mb-0 mr-3 {{$smileyCard2}} h-25" style="">
            <a style="cursor:pointer;" onclick="saveUserSuggestions(this);" data-id="2" data-content-id="{{$sectionpodcast->id}}" discriminator="p" value="{{$checkVal2}}">
                <div class="card-body pt-0 pb-0 row pl-4 mr-1">
                     <p class="smileyCountDiv mb-0" style="" class="mb-0">&#128578; </p>&nbsp;<p class="pt-3"> ({{$suggestionsListCountResult2}})</p>
               	</div>
            </a>
        </div>

        <div class="card mb-0 {{$smileyCard3}} h-25" style="">
            <a style="cursor:pointer;" onclick="saveUserSuggestions(this);" data-id="3" data-content-id="{{$sectionpodcast->id}}" discriminator="p" value="{{$checkVal3}}">
                <div class="card-body pt-0 pb-0 row pl-4 mr-1">
                     <p class="smileyCountDiv mb-0" style="" class="mb-0">&#128528; </p>&nbsp;<p class="pt-3"> ({{$suggestionsListCountResult3}})</p>
                </div>
            </a>
        </div>
    </div>

@endif