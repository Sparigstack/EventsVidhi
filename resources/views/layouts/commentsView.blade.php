@if(isset($comment))
	<div class="commentsDiv mb-5" style="padding: 0px 45px;">
                		<h5 class="mt-2 mb-4"> Comments </h5>

                		<div class="row parent mb-3">
                			<div class="pl-2 col-md-1">
                				<img class="align-self-start profileImg" src="https://panelhiveus.s3.us-west-1.amazonaws.com/org_5/Profile/1606136463image-1.jpg" alt="user avatar" style="width: 45px !important;height: 45px !important;">
                			</div>

                			<div class="col-md-11">
                				<h6 class="mt-1 mb-0"> Mansi Mehta </h6>
                				<?php
                					$comment = "Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he developed following a personal crisis. Cohen and Professor Francesca Gino, author of a case study about the company, discuss whether that approach can endure through rapid growth, a leadership transition, and changing employee expectations.";
                					$commentText = substr($comment,0,140).'...';
                				 ?>
                				<div class="contentDiv fullContent d-none mb-2">{{$comment}}</div>
                				<div class="shortContent mb-2">{{$commentText}}</div>
                				<u><a style="cursor: pointer;color: black;" class="show_hide" data-content="toggle-text" onclick="showHideComments(this);">Show More</a></u>
                				
                			</div>

                		</div>

                        <div class="row parent mb-3">
                            <div class="pl-2 col-md-1">
                                <img class="align-self-start profileImg" src="https://panelhiveus.s3.us-west-1.amazonaws.com/org_5/Profile/1606136463image-1.jpg" alt="user avatar" style="width: 45px !important;height: 45px !important;">
                            </div>

                            <div class="col-md-11">
                                <h6 class="mt-1 mb-0"> Mansi Mehta </h6>
                                <?php
                                    $comment = "Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he developed following a personal crisis. Cohen and Professor Francesca Gino, author of a case study about the company, discuss whether that approach can endure through rapid growth, a leadership transition, and changing employee expectations.";
                                    $commentText = substr($comment,0,140).'...';
                                 ?>
                                <div class="contentDiv fullContent d-none mb-2">{{$comment}}</div>
                                <div class="shortContent mb-2">{{$commentText}}</div>
                                <u><a style="cursor: pointer;color: black;" class="show_hide" data-content="toggle-text" onclick="showHideComments(this);">Show More</a></u>
                                
                            </div>

                        </div>

                        <div class="row parent mb-3 commentSection d-none">
                            <div class="pl-2 col-md-1">
                                <img class="align-self-start profileImg" src="https://panelhiveus.s3.us-west-1.amazonaws.com/org_5/Profile/1606136463image-1.jpg" alt="user avatar" style="width: 45px !important;height: 45px !important;">
                            </div>

                            <div class="col-md-11">
                                <h6 class="mt-1 mb-0"> Mansi Mehta </h6>
                                <?php
                                    $comment = "Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he developed following a personal crisis. Cohen and Professor Francesca Gino, author of a case study about the company, discuss whether that approach can endure through rapid growth, a leadership transition, and changing employee expectations.";
                                    $commentText = substr($comment,0,140).'...';
                                 ?>
                                <div class="contentDiv fullContent d-none mb-2">{{$comment}}</div>
                                <div class="shortContent mb-2">{{$commentText}}</div>
                                <u><a style="cursor: pointer;color: black;" class="show_hide" data-content="toggle-text" onclick="showHideComments(this);">Show More</a></u>
                                
                            </div>

                        </div>

                        <div class="row parent mb-3 commentSection d-none">
                            <div class="pl-2 col-md-1">
                                <img class="align-self-start profileImg" src="https://panelhiveus.s3.us-west-1.amazonaws.com/org_5/Profile/1606136463image-1.jpg" alt="user avatar" style="width: 45px !important;height: 45px !important;">
                            </div>

                            <div class="col-md-11">
                                <h6 class="mt-1 mb-0"> Mansi Mehta </h6>
                                <?php
                                    $comment = "Simón Cohen, founder of Henco Logistics, transformed a small Mexican company into a major player. Cohen credits the firm’s focus on employee happiness as the key ingredient to its success—an approach he developed following a personal crisis. Cohen and Professor Francesca Gino, author of a case study about the company, discuss whether that approach can endure through rapid growth, a leadership transition, and changing employee expectations.";
                                    $commentText = substr($comment,0,140).'...';
                                 ?>
                                <div class="contentDiv fullContent d-none mb-2">{{$comment}}</div>
                                <div class="shortContent mb-2">{{$commentText}}</div>
                                <u><a style="cursor: pointer;color: black;" class="show_hide" data-content="toggle-text" onclick="showHideComments(this);">Show More</a></u>
                                
                            </div>

                        </div>

                        <div class="moreComments col-md-12 row ml-4 pl-4">
                            <a onclick="moreCommentShowHide();">
                                <input type="button" id="" class="clickable morecmtbtn buttonMobileSize" value="More Comments" style=""></a>
                        </div>

    </div>
@endif