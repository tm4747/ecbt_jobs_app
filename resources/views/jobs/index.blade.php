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
        .jobs_select{
            rows:10;
        }
        .btn-outline-danger{
            color:black;
            font-weight: bold;
        }
    </style>

    <?php
    echo "<h2>show all</h2>";

    if(!empty(old("make_filter"))){
        echo "<pre>old make filter"; var_dump(old("make_filter")); echo "</pre>";
    }
    ?>
        <form method="post" id="form_make_filter">
            <div class="row">
                <div class="col-sm-2 col-xs-2 form-group">
                    <input type="button" class="btn btn-outline-danger form-control" id="btn_remove_make_filter" value="Remove Filter">
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

            <div class="row">
                <div class="col-md-3 col-sm-6 form-group">
                    <form method="post">
                        <select class="form-control" name="model_filter[]" multiple="multiple">
                            <option value="">select boat models</option>
                            @foreach($boat_models as $model)
                                <option value="{{$model}}">{{$model}}</option>
                            @endforeach
                        </select>
                        {{--@foreach($boat_makes as $make)--}}
                            {{--<div class="col-lg-1 col-md-2 col-sm-3 col-xs-4 ">--}}
                            {{--<span class="">--}}
                                {{--<label for="boat_make_{{$make}}">{{$make}}</label>--}}
                                {{--<input id="boat_make_{{$make}}" type="checkbox" name="make_filter[]" value="{{$make}}">--}}
                            {{--</span>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                        <hr>
                        <div class="row">
                            <div class="col-sm-2 col-xs-2 form-group">
                                <input type="submit" class="btn btn-primary form-control" value="Apply Filter">
                            </div>
                            <div class="col-sm-2 col-xs-2 form-group">
                                <input type="button" class="btn btn-danger form-control" id="btn_remove_model_filter" value="Remove Filter">
                            </div>
                        </div>
                        <hr>
                    </form>
                </div>
                <div class="col-md-3 col-sm-6 form-group">
                    <form method="post">
                        <select class="form-control" name="year_filter[]" multiple="multiple">
                            <option value="">select boat years</option>
                            @foreach($boat_years as $year)
                                <option value="{{$year}}">{{$year}}</option>
                            @endforeach
                        </select>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4 col-xs-8 form-group">
                                <input type="submit" class="btn btn-primary form-control" value="Apply Filter">
                            </div>
                            <div class="col-sm-4 col-xs-8 form-group">
                                <input type="button" class="btn btn-danger form-control" id="btn_remove_year_filter" value="Remove Filter">
                            </div>
                        </div>
                        <hr>
                    </form>
                </div>
                <div class="col-md-3 col-sm-6 form-group">
                    <form method="post">
                        <select class="form-control" name="thruster_type_filter[]" multiple="multiple">
                            <option value="">select thruster types</option>
                            @foreach($boat_thruster_types as $thruster_type)
                                <option value="{{$thruster_type}}">{{$thruster_type}}</option>
                            @endforeach
                        </select>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4 col-xs-8 form-group">
                                <input type="submit" class="btn btn-primary form-control" value="Apply Filter">
                            </div>
                            <div class="col-sm-4 col-xs-8 form-group">
                                <input type="button" class="btn btn-danger form-control" id="btn_remove_thruster_filter" value="Remove Filter">
                            </div>
                        </div>
                        <hr>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 form-group">
                    <input type="button" class="btn btn-danger form-control" id="btn_remove_all_filters" value="Remove All Filters">
                </div>
            </div>


    <?php
    echo "<pre>"; var_dump($jobs); echo "</pre>";
    ?>

<script>

    $(document).ready(function(){


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
