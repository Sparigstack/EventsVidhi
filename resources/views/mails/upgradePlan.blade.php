


<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <!--<link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet"/>-->
        <style>
            body {
                margin: 0;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-size: 1rem;
/*                font-weight: 400;*/
                /*line-height: 1.5;*/
                color: #212529;
                text-align: left;
                background-color: #fff;
            }
             .h3, h3 {
                font-size: 1.75rem !important;
                font-weight: 500;
            }
            .container-fluid {
                width: 100% ;
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
            }
            p {
                margin-top: 0;
                margin-bottom: 1rem;
            }
            *, ::after, ::before {
                box-sizing: border-box;
            }
            
           
/*            .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
                margin-bottom: .5rem;
                font-family: inherit;
                font-weight: 500;
                line-height: 1.2;
                color: inherit;
            }*/
/*            h3 {
                display: block;
                font-size: 1.17em;
                margin-block-start: 1em;
                margin-block-end: 1em;
                margin-inline-start: 0px;
                margin-inline-end: 0px;
                font-weight: bold;
            }*/
            .row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
img {
    vertical-align: middle;
    border-style: none;
}
.h5, h5 {
    font-size: 1.25rem !important;
}
h5 {
    display: block;
    font-size: 0.83em;
    margin-block-start: 1.67em;
    margin-block-end: 1.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
a {
    color: #007bff;
    text-decoration: none;
    background-color: transparent;
    -webkit-text-decoration-skip: objects;
}
            
        </style>
    </head>
    <body>

        <div class="container-fluid" style="width: 70%;margin-top: 5%;">
            <div class="wrapper">
                <div class="row" style="min-height: 200px;
                     margin: 0;display: flex; align-items: center;justify-content: center;
                     ">
    <p> Congratulations, your account has been upgraded to <b>{{$mail_content->planName}}</b><br>
    Recurring charges - ${{$mail_content->amount}}/{{$mail_content->planDuration}} <br>
    Benefits: {{$mail_content->benefits}}<br><br>
    Thank you, <br>
    Team PanelHive
    </p>
                </div>
            </div>
        </div>


    </body>
</html>