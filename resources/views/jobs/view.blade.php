@extends('layouts.layout')


@section('contents')

<style>
    label{
        font-weight:bold;
        font-size:1.25em;
    }
    form-control{
        color:black;
    }
    .row{
        padding:.5em;
    }
</style>

<div class="container-fluid" style="width:90%;">

    <?php

    echo "<h2>View Job</h2>";

    $job_info['images'] = !empty( $job_info['images'] ) ? $job_info['images'] :  array( array('id'=>"", 'path'=>"")); ?>

    <div class="container-fluid jobs_div_container jobs_bg_">
            {{--TOP ROW - BOAT YEAR MAKE MODEL AND UPDATE BUTTON--}}
            <div class="row div_job_name_img">
                <div class="col-sm-12 col-xs-12 div_job_info">
                    <h4>{{$job_info['year']}}  {{$job_info['make']}} {{$job_info['model']}}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>
            {{--EDIT SHORT FIELDS - THRUSTER INSTALLED, --}}
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify">
                    <h4>Thruster Installed:</h4>
                    {{$job_info['thruster_type']}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>
            {{--EDIT SHORT FIELDS - DATE COMPLETED --}}
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify">
                    <h4>Date Installed: </h4>
                    {{$job_info['done_on']}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>
            {{--EDIT LONG FIELDS - THRUSTER INFO, WIRING INFO--}}
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 div_job_info div_thruster_info text-justify form-group">
                    <h4>Thruster Info: </h4>
                    <textarea class="job_info form-control" rows="20" readonly id="this_thruster_info">{{$job_info['thruster_info']}}</textarea>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 div_job_info text-justify form-group" >
                    <h4>Wiring Info: </h4>
                    <textarea class="form-control job_info" rows="20" readonly id="this_wiring_info">{{$job_info['wiring_info']}}</textarea>
                </div>
            </div>

        {{--IMAGES    --}}
            <div class="row div_job_name_img">
                @foreach($job_info['images'] as $image)
                <div class="col-md-6 col-sm-12 div_job_info">
                    <img src="{{ URL::to( '/images/'. $image['path'] )}}" width="100%">
                </div>
                @endforeach
            </div>
        </form>

    </div>





    <script>

        $(document).ready(function(){

        });
    </script>

</div>

@endsection
