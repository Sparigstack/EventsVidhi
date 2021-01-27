@if(isset($section))
<a href="{{url('organizer/'. $section->user->id)}}" target="_blank">
            <div class="card w-100 d-flex align-items-center" style="margin-top: 15%;border-radius: 6px;">
                <?php
                    $profileLogo = "";
                    if(!is_null($section->user->profile_pic) && $section->user->profile_pic != ""){
                     $profileLogo = env("AWS_URL"). $section->user->profile_pic; ?>
                     <img class="videoUserprofileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                <?php } else{ ?>
                        <img class="videoUserprofileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                <?php } ?>

                <div class="card-body pt-3">
                    <div class="d-flex justify-content-center">
                       <h6> {{$section->user->name}} </h6>
                    </div>
                    
                    <?php
                    $checkFollow = "Follow";
                    $tickIcon = "d-none";
                    $hideFollow = "";
                    $backcolor = "background: #fed8c680;";
                    if (Auth::check()) {
                        if (Auth::user()->id == $section->user->id) {
                            $hideFollow = "d-none";
                        }
                        foreach ($eventFollowersList as $eventFollowerList) {
                            if (Auth::user()->id == $eventFollowerList->user_id && $section->user->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "o") {
                                $checkFollow = "Following";
                                $tickIcon = "";
                                $backcolor = "background: #FED8C6;";
                            }
                        }
                    }
                    ?>

                    <div class="row pt-2">
                        <i style="color: #9C9C9C;" aria-hidden="true" class="fa fa-location-arrow pr-1 pt-1"></i>
                        <p style="color: #9C9C9C;">{{$section->user->location}}</p>&nbsp;&nbsp;&nbsp;
                        <p class="followerCnt" style="color: #9C9C9C;">{{$orgFollowerCountResult}} followers </p>
                    </div>

                    <div class="followingDiv row justify-content-center {{$hideFollow}}" style="display:flex;">
                            <a style="cursor: pointer;" onclick="followOrganizer(this);" data-org-id="{{$section->user->id}}" discriminator="o">
                        <button type="button" id="followOrg" class="clickable createEventButton buttonMobileSize mt-2" value="{{$checkFollow}}" style="{{$backcolor}}color:black;height:40px;"><i aria-hidden="true" class="fa fa-check-square-o mr-2 followIcon {{$tickIcon}}" style="font-size: 17px;"></i>{{$checkFollow}}</button>
                    </a>
                        </div>

                </div>
            </div>
        </a>
@endif

@if(isset($myContent))
    @foreach ($myContent as $organizer)
        <div class="col-md-3 showHideListDiv parent pl-2 pr-2">
                <a href="{{url('organizer/'. $organizer->id)}}" target="_blank">
            <div class="card d-flex align-items-center mt-4" style="border-radius: 6px;">
                <?php
                    $profileLogo = "";
                    if(!is_null($organizer->profile_pic) && $organizer->profile_pic != ""){
                     $profileLogo = env("AWS_URL"). $organizer->profile_pic; ?>
                     <img class="videoUserprofileImg" src="{{$profileLogo}}" alt="user avatar" style="">
                <?php } else{ ?>
                        <img class="videoUserprofileImg" src="https://via.placeholder.com/110x110" alt="user avatar" style="">
                <?php } ?>

                <div class="card-body pt-3">
                    <div class="d-flex justify-content-center">
                       <h6> {{$organizer->name}} </h6>
                    </div>
                    
                    <?php
                    $checkFollow = "Follow";
                    $hideFollow = "";
                    $tickIcon = "d-none";
                    $backcolor = "background: #fed8c680;";
                    if (Auth::check()) {
                        if (Auth::user()->id == $organizer->id) {
                            $hideFollow = "d-none";
                        }
                        foreach ($eventFollowersList as $eventFollowerList) {
                            if (Auth::user()->id == $eventFollowerList->user_id && $organizer->id == $eventFollowerList->content_id && $eventFollowerList->discriminator == "o") {
                                $checkFollow = "Following";
                                $tickIcon = "";
                                $backcolor = "background: #FED8C6;";
                            }
                        }
                    }
                    ?>

                    <div class="row pt-2">
                        <i style="color: #9C9C9C;" aria-hidden="true" class="fa fa-location-arrow pr-1 pt-1"></i>
                        <p style="color: #9C9C9C;">{{$organizer->location}}</p>&nbsp;&nbsp;&nbsp;
                        <p class="followerCnt" style="color: #9C9C9C;">{{$orgFollowerCountResult}} followers </p>
                    </div>

                    <div class="followingDiv row justify-content-center {{$hideFollow}}" style="display:flex;">
                            <a style="cursor: pointer;" onclick="followOrganizer(this);" data-org-id="{{$organizer->id}}" discriminator="o">
                        <button type="button" id="followOrg" class="clickable createEventButton buttonMobileSize mt-2" value="{{$checkFollow}}" style="{{$backcolor}}color:black;height:40px;"><i aria-hidden="true" class="fa fa-check-square-o mr-2 followIcon {{$tickIcon}}" style="font-size: 17px;"></i>{{$checkFollow}}</button></a>
                        </div>

                </div>
            </div>
        </a>
        </div>
    @endforeach
@endif