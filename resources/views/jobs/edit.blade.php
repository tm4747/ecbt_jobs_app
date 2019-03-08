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

    echo "<h2>edit job</h2>";

//        var_dump($job_info); exit;
//    $a_all_thruster_types = !empty($a_all_thruster_types) ? $a_all_thruster_types : array( 'b55', 'b75');
    $job_info['images'] = !empty( $job_info['images'] ) ? $job_info['images'] :  array( array('id'=>"", 'path'=>"")); ?>

    <div class="container-fluid jobs_div_container jobs_bg_">
        <div style="display:none;">
            <form id="form_create_job_info" method="post">
                @csrf
                <input id="new_job_make" name="make_name">
            </form>
        </div>
        <form method="post" id="form_main" action="/edit/{{$job_info['id']}}">
            @csrf
            @method('PATCH')
        {{--TOP ROW - BOAT YEAR MAKE MODEL AND UPDATE BUTTON--}}
        <div class="row div_job_name_img">
            <div class="col-sm-12 col-xs-12 div_job_info">
                <h4>{{$job_info['year']}}  {{$job_info['make']}} {{$job_info['model']}}</h4>
            </div>
        </div>
        {{-- MAKE --}}
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify">
                <br>
                <label for="this_make">Make: </label>
                <select name="make_name" id="this_make" class="form-control">
                    <option value="">Unknown</option>
                    @foreach($a_all_makes as $make)
                        <option value="{{$make}}" <?php echo ( $make == $job_info['make'] ) ? 'selected="selected"' : ""; ?> >{{$make}}</option>
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
        <div class="row" id="div_add_new_make">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify" >
                <button class="btn btn-outline-primary form-control" id="btn_add_new_make" value="New Make">Add New Make</button>
            </div>
        </div>
        {{--ADD NEW MAKE--}}
        <div class="row" style="display:none" id="div_this_new_make">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify">
                <button class="btn btn-outline-danger form-control" id="btn_hide_add_new_make" value="Hide New Make">Hide - Add New Make</button>
                <br><br>
                <label for="this_new_make">New Make: </label><br>
                <input class="form-control" type="text" id="this_new_make" name="new_make">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <hr>
            </div>
        </div>
        {{-- MODEL --}}
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify">
                <br>
                <label for="this_model">Model: </label>
                <select name="model_name" id="this_model" class="form-control">
                    <option value="">Unknown</option>
                    @foreach($a_all_models as $model)
                        <option value="{{$model}}" <?php echo ( $model == $job_info['model'] ) ? 'selected="selected"' : ""; ?> >{{$model}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" id="div_add_new_model">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify" >
                <button class="btn btn-outline-primary form-control" id="btn_add_new_model" value="New model">Add New Model</button>
            </div>
        </div>
        {{--ADD NEW model--}}
        <div class="row" style="display:none" id="div_this_new_model">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify">
                <button class="btn btn-outline-danger form-control" id="btn_hide_add_new_model" value="Hide New model">Hide - Add New Model</button>
                <br><br>
                <label for="this_new_model">New Model: </label><br>
                <input class="form-control" type="text" id="this_new_model" name="new_model">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <hr>
            </div>
        </div>
        {{-- BOAT YEAR    --}}
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group text-justify">
                <label for="this_boat_year">Boat Year: </label>
                <input id="this_boat_year" name="boat_year" type="number" class="form-control " value="{{$job_info['year']}}">
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
                <br>
                <label for="this_thruster_installed">Thruster Installed: </label>
                <select name="thruster_installed" class="form-control">
                    <option value="">Unknown</option>
                    @foreach($a_all_thruster_types as $thruster)
                        <option value="{{$thruster['id']}}" <?php echo ( $thruster['name'] == $job_info['thruster_type'] ) ? 'selected="selected"' : ""; ?> >{{$thruster['name']}}</option>
                    @endforeach
                </select>
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
        <form method="post" id="form_images" action="/edit/{{$job_info['id']}}" enctype="multipart/form-data" >
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-6 col-sm-12 form-group ">
                    <input type="file" name="filenames[]" id="input_file_upload" class="form-control" multiple="multiple">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 form-group">
                    <input type="submit" class="btn btn-primary form-control" id="btn_upload_images" value="Upload Images">
                </div>
            </div>
        </form>

            <div class="row div_job_name_img">
                @foreach($job_info['images'] as $image)
                    <div class="col-sm-4 div_job_info">
                        <img src="{{ URL::to( '/images/'. $image['path'] )}}" width="200px"><br>
                        <form method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="delete_image" value="{{$image['id']}}">
                            <input type="hidden" name="job_id" value="{{$job_info['id']}}">
                            <input type="submit" class="btn btn-danger form-input delete_image_button" value="delete" style="width:200px;margin-top:10px;">
                        </form>
                    </div>
                @endforeach
            </div>

    </div>





<script>
    $( function() {
        $( "#this_date_installed" ).datepicker();
    } );

    $('#btn_upload_images').on('click', function(e){
        e.preventDefault();
        if( $('#input_file_upload').val() !== undefined && $('#input_file_upload').val() !== "" && $('#input_file_upload').val() !== null ){
            $('#form_images').submit();
        }
    });



    $( "#this_date_installed" ).datepicker({ dateFormat: 'yy-mm-dd' });

    $(document).ready(function(){

        // on click - delete image
        $('.delete_image_button').on('click', function(e){

            if( ! confirm('are you sure you want to delete this image?')){
                e.preventDefault();
            }
        });

        // on change - make select
        $('#this_make').on('change', function(){
            $('#new_job_make').val($('#this_make').val());
            alert( $('#new_job_make').val() );
            $('#form_create_job_info').submit();
        });


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

        // handle new make
        $('#btn_add_new_make').on('click', function(){
            // alert('click');
            $('#div_add_new_make').toggle();
            $('#div_this_new_make').toggle();
            return false;
        });
        $('#btn_hide_add_new_make').on('click', function(){
            // alert('click');
            $('#div_add_new_make').toggle();
            $('#div_this_new_make').toggle();
            return false;
        });

        // handle new model
        $('#btn_add_new_model').on('click', function(){
            // alert('click');
            $('#div_add_new_model').toggle();
            $('#div_this_new_model').toggle();
            return false;
        });
        $('#btn_hide_add_new_model').on('click', function(){
            // alert('click');
            $('#div_add_new_model').toggle();
            $('#div_this_new_model').toggle();
            return false;
        });



    });
</script>

</div>

@endsection
