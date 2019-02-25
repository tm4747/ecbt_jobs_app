<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script
                src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js"></script>


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
                font-size: 84px;
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

                <div class="links">
                    <a href="/">Home</a>
                    <a href="/transfer">Transfer</a>
                    <a href="/jobs/">view all jobs</a>
                </div>
                @yield('contents')
            </div>
        </div>
        </div>

    </body>
</html>
