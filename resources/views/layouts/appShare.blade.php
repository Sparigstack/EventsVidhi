<h5 class="mt-4"> Share </h5>

     		<div class="col-md-12 col-lg-12 row">
     			<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
     			<a href="javascript:void()" class="btn-social btn-social-circle waves-effect waves-light m-1 float-right" style="background-color:white;"><i aria-hidden="true" class="fa fa-link" style="color: #9C9C9C;" onclick="shareLink();"></i></a>
     			<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $actual_link; ?>" target="_blank" class="btn-social btn-social-circle btn-linkedin waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-linkedin"></i></a>
     			<a href="http://www.facebook.com/share.php?u=<?php echo $actual_link; ?>" onclick="return fbs_click();" target="_blank" class="btn-social btn-social-circle btn-facebook waves-effect waves-light m-1 float-right" style="color:white;"><i class="fa fa-facebook"></i></a>
     		</div>

     		<div class="copied mt-2"></div>