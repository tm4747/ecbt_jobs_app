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

    echo "<h2>edit</h2>";
//    var_dump($job_info); exit;
//    $a_all_thruster_types = !empty($a_all_thruster_types) ? $a_all_thruster_types : array( 'b55', 'b75');
    $job_info['images'] = array('img', 'img', 'img'); ?>

    <div class="container-fluid jobs_div_container jobs_bg_">
        <form method="post" >
            @csrf
            @method('PATCH')
        {{--TOP ROW - BOAT YEAR MAKE MODEL AND UPDATE BUTTON--}}
        <div class="row div_job_name_img">
            <div class="col-sm-12 col-xs-12 div_job_info">
                <h4>{{$job_info['year']}}  {{$job_info['make']}} {{$job_info['model']}}</h4>
            </div>
        </div>
        {{--EDIT SHORT FIELDS - THRUSTER INSTALLED, --}}
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify">
                <br>
                <label for="this_thruster_installed">Thruster Installed: </label>
                <select name="thruster_installed" class="form-control">
                    <option value="">Unknown</option>
                    @foreach($a_all_thruster_types as $thruster)
                        <option value="{{$thruster['id']}}" <?php echo ( $thruster['name'] == $job_info['thruster_type'] ) ? 'selected="selected"' : ""; ?> >{{$thruster['name']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="offset-md-3 col-md-3 col-sm-12 col-xs-12 form-group div_edit_job" style="display:inline;">

                <?php $handle = !empty($job_info['id']) ? "Update" : "Save"; ?>
                <input type="submit" id="{{$job_info['id']}}" class="btn btn-outline-danger form-control btn_job_edit" value="{{$handle}} Job info">
                <input type="hidden" name="job_id" value="{{$job_info['id']}}">
                <input type="hidden" name="edit_job" value="true">
            </div>
        </div>
        <div class="row" id="div_add_new_thruster_type">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <button class="btn btn-outline-primary form-control" id="btn_add_new_thruster_type" value="New Thruster Type">Add New Thruster Type</button>
            </div>
        </div>
        {{--ADD NEW THRUSTER TYPE--}}
        <div class="row" style="display:none" id="div_this_new_thruster_type">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify">
                <button class="btn btn-outline-danger form-control" id="btn_hide_add_new_thruster_type" value="Hide New Thruster Type">Hide - Add New Thruster Type</button>
                <br><br>
                <label for="this_new_thruster_type">New Thruster Type: </label><br>
                <input class="form-control" type="text" id="this_new_thruster_type" name="new_thruster_type">
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
                <label for="this_date_installed">Date Installed: </label>
                <input id="this_date_installed" name="date_installed" type="text" class="form-control datepicker" value="{{$job_info['done_on']}}">
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
                <label for="this_thruster_info">Thruster Info:</label><br>
                <textarea name="thruster_info" class="job_info form-control" rows="20" id="this_thruster_info">{{$job_info['thruster_info']}}</textarea>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 div_job_info text-justify form-group" >
                <label for="this_wiring_info">Wiring Info:</label><br>
                <textarea name="wiring_info"  class="form-control job_info" rows="20" id="this_wiring_info">{{$job_info['wiring_info']}}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group div_edit_job" style="display:inline;">

                <?php $handle = !empty($job_info['id']) ? "Update" : "Save"; ?>
                <input type="submit" id="{{$job_info['id']}}" class="btn btn-outline-danger form-control btn_job_edit" value="{{$handle}} Job info">
                <input type="hidden" name="job_id" value="{{$job_info['id']}}">
                <input type="hidden" name="edit_job" value="true">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <hr style="visibility:hidden">
                <hr>
            </div>
        </div>
        </form>

        {{--IMAGES    --}}
        <div class="row div_job_name_img">
            @foreach($job_info['images'] as $image)
                <div class="col-sm-4 div_job_info">
                    {{$image}}
                </div>
            @endforeach
        </div>

    </div>





<script>
    $( function() {
        $( "#this_date_installed" ).datepicker();
    } );

    $( "#this_date_installed" ).datepicker({ dateFormat: 'yy-mm-dd' });

    $(document).ready(function(){
        // alert('something');
        $('#btn_add_new_thruster_type').on('click', function(){
            // alert('click');
            $('#div_add_new_thruster_type').toggle();
            $('#div_this_new_thruster_type').toggle();
            return false;
        });
        $('#btn_hide_add_new_thruster_type').on('click', function(){
            // alert('click');
            $('#div_add_new_thruster_type').toggle();
            $('#div_this_new_thruster_type').toggle();
            return false;
        });



    });
</script>

</div>

@endsection
