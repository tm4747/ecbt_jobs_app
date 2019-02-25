<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class JobsController extends Controller
{

    public function edit(Request $request){

//        echo "<h4>id: $request->job_id</h4>"; exit;
//        $this_job = \App\JobInfo::byId($request->job_id);
//        var_dump($this_job); exit;

        $job_info = $this->get_this_job_info($request->job_id);

//        var_dump($job_info); exit;

        return view('jobs.edit', compact('job_info'));

    }

    protected function get_this_job_info($job_id){

        $this_job = \App\JobInfo::byId($job_id);
        $this_make = \App\BoatMake::byId($this_job->make_id);
//        var_dump($this_make); exit;
        $this_model = \App\BoatModel::byId($this_job->model_id);
        $this_thruster_type = \App\ThrusterType::byId($this_job->thruster_type_id);

        return array(
            'id' => $job_id,
            'make' => $this_make->name,
            'year' => $this_job->year,
            'model'=> $this_model->name,
            'thruster_type' => $this_thruster_type->name,
            'thruster_info' => $this_job->thruster_info,
            'wiring_info' => $this_job->wiring_info,
            'done_on' => $this_job->done_on_date
        );
    }


    public function index(Request $request){

        $filters= $this->get_filters($request);
        // these will hold all values for filters - are reduced with filter upon filtering
        $boat_makes = $boat_models = $boat_years = $boat_thruster_types = array();
        $jobs = $this->get_jobs($filters, $boat_makes, $boat_models, $boat_years, $boat_thruster_types );

//        $this->pre_var_dump($boat_makes, 'jobs', true);

        return view('jobs.index', compact('jobs', 'filters', 'boat_makes', 'boat_models', 'boat_years', 'boat_thruster_types'));
    }

// public function filter(Request $request){
//
//exit;
//        $filters= $this->get_filters($request);
//        // these will hold all values for filters - are reduced with filter upon filtering
//        $boat_makes = $boat_models = $boat_years = $boat_thruster_types = array();
//        $jobs = $this->get_jobs($filters, $boat_makes, $boat_models, $boat_years, $boat_thruster_types );
//
////        $this->pre_var_dump($boat_makes, 'jobs', true);
//
//        return view('jobs.index', compact('jobs', 'filters', 'boat_makes', 'boat_models', 'boat_years', 'boat_thruster_types'));
//    }

    protected function get_filters($request){
        $filters = $make_filters = $model_filters = $year_filters = $thruster_type_filters = array();
        if(!empty($request['make_filter'])){
// ONLY 1 Make request
            //            foreach ($request['make_filter'] as $value){
                $make_filters[] = $request['make_filter'];
//            }
        }
        if(!empty($request['model_filter'])){
            foreach ($request['model_filter'] as $value){
                $model_filters[] = $value;
            }
        }
        if(!empty($request['year_filter'])){
            foreach ($request['year_filter'] as $value){
                $year_filters[] = $value;
            }
        }
        if(!empty($request['thruster_type_filter'])){
            foreach ($request['thruster_type_filter'] as $value){
                $thruster_type_filters[] = $value;
            }
        }
        return array(
            "make" => $make_filters,
            "model"=> $model_filters,
            "year" => $year_filters,
            "thruster_type"=>$thruster_type_filters
        );
    }

    protected function get_jobs($filters = array(), &$boat_makes, &$boat_models, &$boat_years, &$boat_thruster_types){
        $a_jobs = array();
        $job_data = DB::table('job_infos')->select('id', 'make_id', 'model_id', 'year', 'thruster_type_id', 'wiring_info', 'thruster_info', 'done_on_date')->get();
        if(!empty($job_data) && !$job_data->isEmpty()){
            foreach ( $job_data as $data ){
                $this_make_name = DB::table('boat_makes')->where('id', $data->make_id)->pluck('name')->first();
                $this_model_name = DB::table('boat_models')->where('id', $data->model_id)->pluck('name')->first();
                $this_thruster_type_name = DB::table('thruster_types')->where('id', $data->thruster_type_id)->pluck('name')->first();

                $this_job = array(
                    'id'                => $data->id,
                    'make'              => !empty( $this_make_name ) ? $this_make_name : "" ,
                    'model'             => !empty( $this_model_name ) ? $this_model_name : "" ,
                    'year'              => !empty( $data->year ) ? $data->year : "",
                    'thruster_type'     => !empty( $this_thruster_type_name ) ? $this_thruster_type_name : "" ,
                    'wiring_info'       => !empty( $data->wiring_info) ? $data->wiring_info : "",
                    'thruster_info'     => !empty( $data->thruster_info) ? $data->thruster_info : "",
                    'date'              => !empty( $data->done_on_date) ? $data->done_on_date: "",
                );
//                $this->pre_var_dump($this_job, 'thisjob');
                // APPLY FILTERS
                $b_remove = false;
//                $this->pre_var_dump($filters, 'filters');
                foreach($filters as $key=>$values){
                    if($key == 'make'){
//                        echo "<h5>make filter  --- job make: " . $this_job['make']['name']; var_dump( $values );
                        if(!empty($values)){
                            if(!in_array($this_job['make'], $values)){
//                                echo "<h6>remove1</h6>";
                                $b_remove = true;
                            }
                        }
                    } else if($key == 'model'){
//                        echo "<h5>model filter  --- job model: " . $this_job['model']['name']; var_dump( $values );

                        if(!empty($values)){
                            if(!in_array($this_job['model'], $values)){
                                $b_remove = true;
//                                echo "<h6>remove2</h6>";
                            }
                        }
                    } else if($key == 'year'){
//                        echo "<h5>year filter  --- job year: " . $this_job['year']; var_dump( $values );

                        if(!empty($values)){
                            if(!in_array($this_job['year'], $values)){
                                $b_remove = true;
//                                echo "<h6>remove3</h6>";
                            }
                        }
                    } else if($key == 'thruster_type'){
                        if(!empty($values)){
                            if(!in_array($this_job['thruster_type'], $values)){
                                $b_remove = true;
//                                echo "<h6>remove4</h6>";
                            }
                        }
                    }
                }
                // IF we've determined not to filter this one out, add to jobs array and filter values
//                echo "REMOVE: $b_remove";
                if( $b_remove != true ){
                    if( !in_array( $this_job['make'], $boat_makes) ){
                        $boat_makes[] = $this_job['make'];
                    }
                    if( !in_array( $this_job['model'], $boat_models) ){
                        $boat_models[] = $this_job['model'];
                    }
                    if( !in_array( $this_job['year'], $boat_years) ){
                        $boat_years[] = $this_job['year'];
                    }
                    if( !in_array( $this_job['thruster_type'], $boat_thruster_types) ){
                        $boat_thruster_types[] = $this_job['thruster_type'];
                    }
                    $a_jobs[] = $this_job;
                }
            }
        }
//        $this->pre_var_dump($a_jobs, 'jobs', true);

        return $a_jobs;
    }

    public function pre_var_dump($var, $heading="", $exit = false){
        echo "<pre><h2>$heading</h2>";
        var_dump($var);
        echo "</pre>";
        if($exit == true){
            exit;
        }
    }


    public function create(){
        return view('jobs.create');

    }
    public function store( $id ){

        return view('jobs.edit', 'id');

    }

    public function update($id){
        echo "<h4>id: $id</h4>"; exit;

        return view('jobs.edit', 'id');

    }
}
