@extends('layouts.layout')


@section('contents')

    <style>
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

    <?php //var_dump($filters); ?>

    <form method="post">
        @csrf
        <div class="row" <?php echo ( empty($filters['make']) && empty($filters['model']) && empty($filters['year']) ) ? 'style="display:none"' : ""; ?> >
            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                <input type="submit" class="btn btn-outline-danger form-control" id="btn_remove_filters" value="Remove Filter">
            </div>
        </div>
    </form>

            {{-- IF - ONLY SHOW MAKE SELECTOR IF THERE IS NO MAKE FILTER--}}
            @if( empty( $filters["make"] ) )
                <form method="post" id="form_make_filter">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 text-justify">
                            <h4>
                                Select Make:
                            </h4>
                        </div>
                    </div>
                <div class="row ">
                    <div class="col-lg-12">
                        <select class="form-control jobs_select" id="make_filter_select" name="make_filter" >
                            <option value="">select boat makes</option>
                            @foreach($boat_makes as $make)
                                <option value="{{$make}}">{{$make}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                </form>
            {{--ELSE - THERE IS A MAKE FILTER SELECTED - SHOW OTHER FILTER SELECTIONS    --}}
            @else
                <form method="post" id="form_other_filters">
                    @csrf
                    <div id="model_div" <?php echo !empty( $filters["model"] ) ? 'style="display:none"' : "" ; ?> >
                        <div class="row">
                            <div class="col-lg-12 text-justify">
                                <h4>
                                    Select Model:
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($boat_models as $model)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 form-group ">
                                <span class="force_same_line">
                                    <label for="boat_make_{{$model}}">{{$model}}</label>
                                    <input id="boat_make_{{$model}}" class="filter_checkbox" type="checkbox"
                                           name="model_filter[]" value="{{$model}}"
                                    <?php echo in_array($model, $filters['model']) ? 'checked="checked"' : ""; ?> >
                                </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="year_div" <?php echo ( !empty( $filters["year"] ) || empty( $filters["model"] ) ) ? 'style="display:none"' : "" ; ?> >
                        <div class="row">
                            <div class="col-lg-12 text-justify">
                                <h4>
                                    Select Year:
                                </h4>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($boat_years as $year)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 form-group ">
                                <span class="force_same_line">
                                    <label for="boat_year_{{$year}}">{{$year}}</label>
                                    <input id="boat_year_{{$year}}" class="filter_checkbox" type="checkbox" name="year_filter[]" value="{{$year}}"
                                           <?php echo in_array($year, $filters['year']) ? 'checked="checked"' : ""; ?> >
                                </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                <div class="row " <?php echo ( empty( $filters["year"] ) || empty( $filters["model"] ) ) ? "" : 'style="display:none"'; ?>>
                    <div class="col-sm-4 col-xs-6 form-group ">
                        <input type="submit" class="btn btn-primary form-control" value="Apply Filters" >
                        <input type="hidden" name = "make_filter" value="{{$filters["make"][0]}}">
                    </div>
                </div>
                </form>
            @endif
    <div class="row">
        <div class="col-sm-12">
            <hr>
        </div>
    </div>
    {{--WHAT ARE WE SHOWING?--}}
    <div class="row">
            <?php
            $b_first_model = $b_first_year = true;
            if( !empty( $filters["make"] ) ){
                echo '<div class="col-sm-3 col-xs-12 text-justify">';
                echo "<h5>Make: " . $filters['make'][0] . "</h5></div>";
                if( !empty($filters["model"]) ){
                    echo '<div class="col-sm-6 col-xs-12 text-justify">';
                    echo "<h5>Models: ";
                    foreach ( $filters["model"] as $model ){
                        if($b_first_model){
                            echo $model;
                            $b_first_model = false;
                        } else{
                            echo " , " . $model;
                        }
                    }
                    echo "</h4></div>";
                }
                if( !empty($filters["year"]) ){
                    echo '<div class="col-sm-3 col-xs-12 text-justify">';
                    echo "<h5>Years: ";
                    foreach ( $filters["year"] as $year ){
                        if($b_first_year){
                            echo $year;
                            $b_first_year = false;
                        } else{
                            echo " , " . $year;
                        }
                    }
                    echo "</h4></div>";
                }
            } else{
                echo '<div class="col-sm-4 col-xs-12 text-justify">';
                echo "<h4>Show All:</h4></div>";
            } ?>
    </div>
    {{--END - WHAT ARE WE SHOWING--}}

<?php $jobs_count = 0 ?>
    @foreach($jobs as $job)
        <?php $job['images'] = array('img', 'img', 'img'); ?>
        <div class="container jobs_div_container jobs_bg_<?php echo $jobs_count % 2 == 0 ? 'light' : 'dark' ; ?>">
            <div class="row div_job_name_img">
                <div class="col-sm-2 form-group div_edit_job">
                </div>
                <div class="col-sm-8 div_job_info">
                    <h4>{{$job['year']}}  {{$job['make']}} {{$job['model']}}</h4>
                </div>
                <div class="col-sm-2 form-group div_edit_job" style="display:inline;">
                    <form method="post" action="/edit/{{$job['id']}}">
                        @csrf
                        <input type="submit" id="{{$job['id']}}" class="btn btn-outline-danger form-control btn_job_edit" value="Edit">
                        <input type="hidden" name="job_id" value="{{$job['id']}}">
                        <input type="hidden" name="edit_job" value="true">
                    </form>
                </div>
            </div>
            <div class="row div_job_name_img">
                @foreach($job['images'] as $image)
                    <div class="col-sm-4 div_job_info">
                        {{$image}}
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 div_job_info div_thruster_info text-justify">
                    <h4>Thruster Info:</h4>
                    {{$job['thruster_info']}}
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 div_job_info         }
 text-justify" >
                    <h4>Wiring Info:</h4>
                    {{$job['wiring_info']}}
                </div>
            </div>
        </div>
        {{--EMPTY LINE--}}
        <div class="container ">
            <div class="row ">
                <div class="col-sm-12">
                    <hr style = "color:#f1f1f1">
                </div>
            </div>
        </div>
        <?php $jobs_count++; ?>
    @endforeach


    <?php
    echo "<pre># of jobs: "; var_dump(count($jobs)); echo "</pre>";
    ?>

<script>

    $(document).ready(function(){

        // Edit job button
        $('.btn_job_edit').on('click', function(e){
            // e.preventDefault();
            // alert($(this).attr('id'));
        });

        // Make filter apply
        $('#make_filter_select').on('change', function(){
            if($(this).val() != "" ){
                // alert($(this).val());
                $('#form_make_filter').submit();
            }
        });

        // handle remove filters buttons
        $('#btn_remove_make_filter').on('click', function (e) {
           e.preventDefault();
           alert('clic');
        });
        $('#btn_remove_model_filter').on('click', function (e) {
           e.preventDefault();
           alert('clic');
        });
        $('#btn_remove_year_filter').on('click', function (e) {
           e.preventDefault();
           alert('clic');
        });
        $('#btn_remove_thruster_filter').on('click', function (e) {
           e.preventDefault();
           alert('clic');
        });
        $('#btn_remove_all_filters').on('click', function (e) {
           e.preventDefault();
           alert('clic');
        });



    });

</script>




@endsection
