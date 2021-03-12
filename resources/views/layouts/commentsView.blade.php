@if(isset($comment))
	<div class="commentsDiv mb-2" style="padding: 0px 45px;">
        <div class="col-md-12 row">
            <div class="col-md-9 pl-0">
                <h5 class="mt-2 mb-4"> Comments ({{count($commentDetail)}}) </h5>
            </div>
            <div class="col-md-3">
                <?php if(Auth::check()){
                if(count($getRegisterOrPurchaseEventResult) > 0) { ?>
                <a href="javascript:void();" data-toggle="modal" data-target="#openCommentPopup">
                <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="Add Comment" style="padding: 8px 30px;"></a>
                <?php }} ?>
            </div>
        </div>

        @if(count($commentDetail) > 0)
        <?php
            $commentSection = "";
            $cntCmt = 1;
        ?>
        @foreach($commentDetail as $commentDetails)
        @if($cntCmt > 2)
            <?php
                $commentSection = "commentSection d-none";
            ?> 
        @endif
        <div class="row parent mb-3 {{$commentSection}}">
            <div class="pl-2 col-md-1">
                <?php
                    $profileLogo = "";
                    if(!is_null($commentDetails->user->profile_pic) && $commentDetails->user->profile_pic != "")
                    {
                        $profileLogo = env("AWS_URL"). $commentDetails->user->profile_pic; 
                    } else {
                        $profileLogo =  "https://via.placeholder.com/110x110";  
                    }
                ?>
                <img class="align-self-start profileImg" src="{{$profileLogo}}" alt="user avatar" style="width: 45px !important;height: 45px !important;">
            </div>

            <div class="col-md-11">
                <h6 class="mt-1 mb-0"> {{$commentDetails->user->name}} </h6>
                <?php
                    $dnoneMore = "";
                    if(strlen($commentDetails->comment) <= 140){
                        $dnoneMore = "d-none";
                    }
                	$comment = $commentDetails->comment;
                	$commentText = substr($comment,0,140).'...';
                ?>
                <div class="contentDiv fullContent d-none mb-2 mt-2">{{$comment}}</div>
                <div class="shortContent mb-2 mt-2">{{$commentText}}</div>
                <u><a style="cursor: pointer;color: black;" class="show_hide {{$dnoneMore}}" data-content="toggle-text" onclick="showHideComments(this);">Show More</a></u>
            </div>
        </div>
        <?php $cntCmt++; ?>
        @endforeach
        @if(count($commentDetail) > 2)
        <div class="moreComments col-md-12 row ml-4 pl-4 mt-5">
            <a onclick="moreCommentShowHide();"><input type="button" id="" class="clickable morecmtbtn buttonMobileSize" value="More Comments" style=""></a>
        </div>
        @endif
        @else
            <div class="col-md-12 pl-0">
                <p> There are no comments </p>
            </div>
        @endif

    </div>
@endif