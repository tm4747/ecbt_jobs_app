@extends('layouts.layout')


@section('contents')




    <?php

    echo "<h2>edit</h2>";
//    var_dump($job_info);

    $job_info['images'] = array('img', 'img', 'img'); ?>
    <div class="container jobs_div_container jobs_bg_">
        <div class="row div_job_name_img">
            <div class="col-sm-2 form-group div_edit_job">
            </div>
            <div class="col-sm-8 div_job_info">
                <h4>{{$job_info['year']}}  {{$job_info['make']}} {{$job_info['model']}}</h4>
            </div>
            <div class="col-sm-2 form-group div_edit_job" style="display:inline;">
                <form method="post" action="/edit">
                    @csrf
                    <input type="submit" id="{{$job_info['id']}}" class="btn btn-outline-danger form-control btn_job_edit" value="Edit">
                    <input type="hidden" name="job_id" value="{{$job_info['id']}}">
                    <input type="hidden" name="edit_job" value="true">
                </form>
            </div>
        </div>
        <div class="row div_job_name_img">
            @foreach($job_info['images'] as $image)
                <div class="col-sm-4 div_job_info">
                    {{$image}}
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 div_job_info div_thruster_info text-justify">
                <h4>Thruster Info:</h4>
                {{$job_info['thruster_info']}}
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 div_job_info         }
 text-justify" >
                <h4>Wiring Info:</h4>
                {{$job_info['wiring_info']}}
            </div>
        </div>
    </div>









@endsection
