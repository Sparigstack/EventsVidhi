@extends('layouts.appFront')
@section('content')
<?php $v = "1.0.1"; ?>
<div class="container mainHomePageContainer pt-3 pb-5 pl-0 pr-0" style="">

	<div class="col-md-12 col-lg-12 d-flex align-items-center mb-5 pb-4">
		<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class=""><i class="fa fa-angle-left"></i>&nbsp; Back</a>
	</div>

	<div class="card mb-4 col-md-9 m-auto pb-3" style="">
		<div class="row col-md-12 col-lg-12 col-sm-12">
			<div class="col-md-5 col-lg-5 col-sm-12">
				<img class="plansOuterImg" style="top:-5%;" src="assets/images-new/Managment.png" />
			</div>

			<div class="col-md-7 col-lg-7 col-sm-12"> 
				<h4 class="mt-5 text-uppercase" style="line-height: 35px;"> Your one stop shop for complete Event Management </h4>

				<div class="mt-3">
					<h5> We at Panelhive, encourage learning! </h5>
					<p style="line-height: 25px;">And that’s why we value our organisers and want to offer them our best services so they can reach out and inspire learning in wider community and create a unique experience. <br> <br>
					Whether you have an event to host, a story to tell, a session to conduct, a learning to share, Panelhive offers you the platform to reach out and do it! <br>
					We want you to create a lasting experience for your followers and offer them the best you can! We will just help you along the way in all possible ways we can! </p>
				</div>

				<div class="mt-3 mb-5">
					<h5 class="mt-2"> As an Organiser, you can: </h5>
					<p style="line-height: 25px;"> <span class="dot1 mt-4 mr-2" style="margin-left: -20px;background: #FD6568;"></span>  <b> Create events </b> – You enjoy the benefits of hosting events, workshops, tutorials; <br>
						<span class="dot1 mt-4 mr-2" style="margin-left: -20px;background: #E180A0;"></span> <b> Manage Media Library </b> – Save your media content, showcase to public or store in your archives. You can upload videos & podcasts of past events and sessions for your followers to enjoy at any point of time; <br>
						<span class="dot1 mt-4 mr-2" style="margin-left: -20px;background: #FED8C6;"></span> <b> Easy Registration </b> – Manage your registrations with ease with our added features; <br>
						<span class="dot1 mt-4 mr-2" style="margin-left: -20px;background: #FED8C6;"></span> <b> Manage Contacts </b> – Manage your contacts at one place. Send quick updates and notifications about upcoming events; <br>
						<span class="dot1 mt-4 mr-2" style="margin-left: -20px;background: #7B97FB;"></span> <b> Surveys & Reports </b> – Conduct surveys and manage reports at one place!
					</p>
				</div>

				<div class="registerEvent ml-5 pl-5 mb-5">
                            <a href="#">
                            <input type="button" id="" class="clickable createEventButton buttonMobileSize" value="I wanna join!" style="padding: 8px 30px;"></a>
                </div>

                <div class="row mb-4">
			<div class="col-md-12 row">
				<div class="col-md-9 pull-right mt-5 pt-3"><p class="ml-5 pl-4">Any Questions?&nbsp;&nbsp;&nbsp;<a href="{{url('contactUs')}}"><b><u>Message Us</u></b></a></p></div>
				<div class="col-md-2 pull-right"><img src="assets/images-new/plansImage2.png"></div>
			</div>
		</div>


			</div>
		</div>
	</div>

</div>
@endsection