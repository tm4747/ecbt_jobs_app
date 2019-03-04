<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script
                src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"></script>
        <script
                src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
                integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
                crossorigin="anonymous"></script>



        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: black;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 3em;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .parent_force_same_line{
                white-space: nowrap;
                overflow-x: auto;
                overflow-y: hidden;
            }
            .child_force_same_line{
                display: inline-block;
            }
            .force_same_line{
                white-space: nowrap;
            }
            .filter_checkbox{
                margin-left:.25em;
                margin-right:1.25em;
            }
            .jobs_select{
                rows:10;
            }
            .btn-outline-danger{
                color:black;
                font-weight: bold;
            }
            .alert-primary{
                color:ghostwhite;
                background-color: #00385A;
                /*padding-top:.25em;*/
                /*padding-bottom:.25em;*/
            }
            h4{
                font-weight: bold;
            }
            .div_job_name_img{
                border-bottom-style: dotted;
                border-bottom-width:1px;
                border-bottom-color:#999;
            }
            .jobs_div_container{
                border-style: solid;
                border-width:2px;
                border-color:#555;
            }
            .jobs_bg_light{
                background-color: #ddd;
            }
            .jobs_bg_dark{
                background-color: white;
            }
            .div_job_info{
                padding:.5em;
            }
            .div_thruster_info{
                padding-right:1.5em;
                padding-left:1.5em;
            }
            h5{
                font-weight:bold;
            }
            .div_edit_job{
                margin-top:auto;
                margin-bottom:auto;
            }
            /*** MY STYLES BEGIN ***/
            .btn-outline-primary{
                font-weight:bold;
                color:black;
            }
            .jobs_div_container{
                padding-top:1em;
            }
            .menu_links{
                font-size: 1.5em;
            }
        </style>
    </head>
    <body>
        <div class=" position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        <div class="content">
            <div class="container-fluid" style="width:75%;">
                <div class="title m-b-md">
                    ECBT Jobs
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 form-group menu_links links">
                        {{--<a href="/" ><button class="btn btn-outline-primary form-control">View Jobs</button></a>--}}
                        <a href="/jobs/" ><span class="menu_links force_same_line">view all jobs</span></a>
                    </div>
                    <div class="col-md-6 col-sm-12 form-group menu_links links">
                        {{--<a href="/create/" ><span class="btn btn-outline-primary form-control">Enter New Job</span></a>--}}
                        <a href="/create/" ><span class="menu_links force_same_line">Enter New Job</span></a>
                    </div>
                </div>
                <div class="links">



                    <hr>
                </div>
            </div>

                @yield('contents')

        </div>
        </div>

    </body>
</html>
