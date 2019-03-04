<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class JobsController extends Controller
{

    /**************** WEB FUNCTION BEGIN *********************/

    public function index(Request $request){

        $filters= $this->get_filters($request);
        // these will hold all values for filters - are reduced with filter upon filtering
        $boat_makes = $boat_models = $boat_years = $boat_thruster_types = array();
        $jobs = $this->get_jobs($filters, $boat_makes, $boat_models, $boat_years, $boat_thruster_types );

        return view('jobs.index', compact('jobs', 'filters', 'boat_makes', 'boat_models', 'boat_years', 'boat_thruster_types'));
    }

    public function view($id, Request $request){

        $job_info = $this->get_this_job_info($id);
        $a_all_thruster_types = $this->get_all_thruster_types();

        $a_all_makes = $this->get_all_makes();

        $a_all_models = $this->get_all_models_per_make( $job_info['make_id'] );

        return view('jobs.view', compact('job_info', 'a_all_thruster_types', 'a_all_models', 'a_all_makes'));
    }


    public function create(){

        $job_info = $this->get_empty_job_info();
        $a_all_makes = $this->get_all_makes();
        $a_all_models = array();
        $a_all_thruster_types = $this->get_all_thruster_types();

        return view('jobs.edit', compact('job_info', 'a_all_thruster_types', 'a_all_makes', 'a_all_models'));
    }

    protected function get_all_makes(){
        $a_all_makes = array();
        $makes_data = DB::table('boat_makes')->get();
        foreach($makes_data as $data){
            $a_all_makes[] = $data->name;
        }
        sort($a_all_makes);
        return $a_all_makes;
    }

    protected function get_empty_job_info(){
        return array(
            'id' => "",
            'make' => "",
            'year' => "",
            'model'=> "",
            'thruster_type' => "",
            'thruster_info' => "",
            'wiring_info' => "",
            'done_on' => "",
            'images' => array()
        );
    }


    public function store( Request $request){
        $id = $this->save_job_info("", $request);

        $job_info = $this->get_this_job_info($id);

        $a_all_makes = $this->get_all_makes();
        $a_all_models = $this->get_all_models_per_make( $job_info['make_id'] );
        $a_all_thruster_types = $this->get_all_thruster_types();

        return view('jobs.edit', compact('job_info', 'a_all_thruster_types', 'a_all_makes', 'a_all_models'));

    }


    public function edit($id, Request $request){

        $job_info = $this->get_this_job_info($id);
        $a_all_thruster_types = $this->get_all_thruster_types();

        $a_all_makes = $this->get_all_makes();

        $a_all_models = $this->get_all_models_per_make( $job_info['make_id'] );

        return view('jobs.edit', compact('job_info', 'a_all_thruster_types', 'a_all_models', 'a_all_makes'));
    }

    protected function get_all_models_per_make( $make_id ){
        $a_models = array();
        $models_data = DB::table('boat_models')->where('make_id', $make_id)->get();
        foreach($models_data as $model){
            $a_models[] = $model->name;
        }
        sort($a_models);

        return $a_models;
    }


    public function update($id, Request $request){

        if($request->hasfile('filenames')){

            foreach($request->file('filenames') as $image) {
                $this->pre_var_dump($image);
                $name=$image->getClientOriginalName();
                $image->move(public_path().'/images/' . $id, $name);
                $new_image = new \App\Image();
                $new_image->job_info_id = $id;
                $new_image->image_path = "$id/$name";
                $new_image->save();
            }
        } else {
            $this->save_job_info($id, $request);
        }

        $job_info = $this->get_this_job_info($id);

        $a_all_makes = $this->get_all_makes();
        $a_all_models = $this->get_all_models_per_make( $job_info['make_id'] );

        $a_all_thruster_types = $this->get_all_thruster_types();

        return view('jobs.edit', compact('job_info', 'a_all_thruster_types', 'a_all_makes', 'a_all_models'));

    }
    /**************** WEB FUNCTIONS END *********************/





    /**************** AUX FUNCTION BEGIN *********************/
    protected function save_job_info($id = "", $request){

        echo $id;
        if(!empty($id)){
            $this_job = \App\JobInfo::byId($id);
            echo "<h4>update job</h4>";
        } else {
            $this_job = new \App\JobInfo();
            echo "<h4>create new job</h4>";
        }
        // HANDLE SAVE / UPDATE MAKE
        if(!empty($request->new_make)){
            $new_make = new \App\BoatMake();
            $new_make->name = $request->new_make;
            $new_make->save();
            $this_job->make_id = $new_make->id;
        } elseif(!empty($request->make_name)){
            $this_make = \App\BoatMake::byName($request->make_name);
            $make_id = $this_make->id;
            $this_job->make_id = $make_id;
        }
        // HANDLE SAVE / UPDATE MODEL
        if(!empty($request->new_model) && !empty($this_job->make_id) ){
            $new_model = new \App\BoatModel();
            $new_model->name = $request->new_model;
            $new_model->make_id = $this_job->make_id;
            $new_model->save();
            $this_job->model_id = $new_model->id;
        } else if(!empty($request->model_name)){
            $this_model = \App\BoatModel::byName($request->model_name);
            $model_id = $this_model->id;
            $this_job->model_id = $model_id;
        }
        // HANDLE SAVE / UPDATE BOAT YEAR
        $this_job->year = !empty($request->boat_year) ? $request->boat_year : "0";
        // HANDLE SAVE / UPDATE THRUSTER TYPE
        $thruster_id = "";
        if(!empty($request->new_thruster_type)){
            $thruster_type = new \App\ThrusterType();
            $thruster_type->name = $request->new_thruster_type;
            $thruster_type->save();
            $thruster_id = $thruster_type->id;
        } else if( !empty( $request->thruster_installed ) ){
            $thruster_id = $request->thruster_installed;
        }
        if(!empty($thruster_id)){
            $this_job->thruster_type_id = $thruster_id;
        }
        // HANDLE SAVE / UPDATE WIRING INFO
        $this_job->wiring_info = !empty($request->wiring_info) ? $request->wiring_info : "";
        // HANDLE SAVE / UPDATE THRUSTER INFO
        $this_job->thruster_info = !empty($request->thruster_info) ? $request->thruster_info : "";
        // HANDLE SAVE / UPDATE DATE INSTALLED
        $this_job->done_on_date = !empty($request->date_installed) ? $request->date_installed : null;
        $this_job->save();
        return $this_job->id;
    }



    protected function get_all_thruster_types(){
        $a_all_thruster_types = array();
        $a_all_thruster_types_data = DB::table('thruster_types')->orderBy('name')->get();
        foreach($a_all_thruster_types_data as $thruster_types){
            $a_all_thruster_types[] = array(
              'name' =>   $thruster_types->name,
                'id' => $thruster_types->id
            );
        }
        sort($a_all_thruster_types);
        return $a_all_thruster_types;
    }



    protected function get_this_job_info($job_id){

        $this_job = \App\JobInfo::byId($job_id);
        $this_make = \App\BoatMake::byId($this_job->make_id);
//        var_dump($this_make); exit;
        if(!empty($this_job->model_id) ){
            $this_model = \App\BoatModel::byId($this_job->model_id);
        }
        if(!empty($this_job->thruster_type_id) ){
            $this_thruster_type = \App\ThrusterType::byId($this_job->thruster_type_id);
        }

        $images = array();
        $image_data = DB::table('images')->where('job_info_id', $job_id)->get();

        foreach($image_data as $image){
            $images[] = array(
                'id' => $image->id,
                'path' => $image->image_path
            );
        }

        $a_all_job_info = array(
            'id' => $job_id,
            'make_id' => $this_job->make_id,
            'make' => $this_make->name,
            'year' => !empty( $this_job->year ) ? $this_job->year : 0,
            'model'=> !empty( $this_model->name ) ? $this_model->name : null,
            'thruster_type' => !empty( $this_thruster_type->name ) ? $this_thruster_type->name : null,
            'thruster_info' => $this_job->thruster_info,
            'wiring_info' => $this_job->wiring_info,
            'done_on' => $this_job->done_on_date,
            'images' => $images
        );

        return $a_all_job_info;
    }



    protected function get_filters($request){
        $filters = $make_filters = $model_filters = $year_filters = $thruster_type_filters = array();
        if(!empty($request['make_filter'])){
        // ONLY 1 Make request
        $make_filters[] = $request['make_filter'];
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

                // get number of images
//                $count_images = 0;
//                $images = array();
                $image_data = DB::table('images')->where('job_info_id', $data->id)->get();
                $count_images = count($image_data);

                $this_job = array(
                    'id'                => $data->id,
                    'make'              => !empty( $this_make_name ) ? $this_make_name : "" ,
                    'model'             => !empty( $this_model_name ) ? $this_model_name : "" ,
                    'year'              => !empty( $data->year ) ? $data->year : "",
                    'thruster_type'     => !empty( $this_thruster_type_name ) ? $this_thruster_type_name : "" ,
                    'wiring_info'       => !empty( $data->wiring_info) ? $data->wiring_info : "",
                    'thruster_info'     => !empty( $data->thruster_info) ? $data->thruster_info : "",
                    'date'              => !empty( $data->done_on_date) ? $data->done_on_date: "",
                    'count_images'        => $count_images
                );
                // APPLY FILTERS
                $b_remove = false;
                foreach($filters as $key=>$values){
                    if($key == 'make'){
                        if(!empty($values)){
                            if(!in_array($this_job['make'], $values)){
//                                echo "<h6>remove1</h6>";
                                $b_remove = true;
                            }
                        }
                    } else if($key == 'model'){

                        if(!empty($values)){
                            if(!in_array($this_job['model'], $values)){
                                $b_remove = true;
                            }
                        }
                    } else if($key == 'year'){

                        if(!empty($values)){
                            if(!in_array($this_job['year'], $values)){
                                $b_remove = true;
                            }
                        }
                    } else if($key == 'thruster_type'){
                        if(!empty($values)){
                            if(!in_array($this_job['thruster_type'], $values)){
                                $b_remove = true;
                            }
                        }
                    }
                }
                // IF we've determined not to filter this one out, add to jobs array and filter values
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
        sort($boat_makes);
        sort($boat_models);
        sort($boat_years);
        sort($boat_thruster_types);
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

}
