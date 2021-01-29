@extends('layouts.appFront')
@section('content')
<div class="card mb-0" style="box-shadow: none;">

	<div class="col-md-12 col-lg-12 d-flex align-items-center">
		<div class="container mb-5 mt-4">
			<a href="{{url('/')}}" style="color: #9C9C9C;font-weight: 100;" class=""><i class="fa fa-angle-left"></i>&nbsp; Back</a>

			<div class="row">
				<div class="col-md-4" style="margin-top: 15%;">
					<h5 class="text-center" style="line-height: 25px;">For all your queries, <br> or just to say hello! </h5>
					<p class="mt-4 text-center">Reach us</p>
					<p class="mt-2 text-center"><a href="mailto:hello@panelhive.com"><b><u>hello@panelhive.com</u></b></a></p>
				</div>

				<div class="col-md-8" style="background:url('{{asset('assets/images-new/Contact Us.png')}}'); background-size:cover; background-position:center;
                    background-repeat:no-repeat; min-height:700px; padding:unset;">
					<!-- <img src="assets/images-new/Contact Us.png"> -->
				</div>
			</div>

		</div>
	</div>

</div>
@endsection