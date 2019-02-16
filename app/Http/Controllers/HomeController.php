<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function index(){


        return view('home');
    }

    public function view_old_data(){

        $old_data = $this->get_old_data();


        return view('transfer', compact('old_data'));
    }



    public function get_data(){

        $old_data = $this->get_old_data();
        $this->store_old_data($old_data);



        return view('transfer', compact('old_data'));
    }

    protected function store_old_data($old_data){

//        $this->pre_var_dump($old_data, 'old data', true);
        foreach($old_data as $data){

            $make_id = $this->process_field($data['Boat_Make'], 'name', 'boat_makes', "\App\BoatMake");
            $model_id = $this->process_field($data['Boat_Model'], 'name', 'boat_models', "\App\BoatModel", "make_id", $make_id);
            $data['Unit_Installed'] = ( !empty( $data['Unit_Installed'] ) && strtolower($data['Unit_Installed']) != 'none' ) ? $data['Unit_Installed'] : "unspecified";
            $thruster_type_id = $this->process_field($data['Unit_Installed'], 'name', 'thruster_types', "\App\ThrusterType");
            $job_info_id = $this->process_job_info($make_id, $model_id, $thruster_type_id, $data['Boat_Year'], $data['Thruster_Info'], $data['Wiring_Info']);


        }
        echo "<h1>here</h1>";
        exit;
    }


    protected function process_job_info($make_id, $model_id, $thruster_type_id, $boat_year="", $thruster_info="", $wiring_info=""){

        $this->trim_down_strtolower_input($boat_year);
        $this->keep_only_numbers($boat_year);
        // store new job
        $new_job = new \App\JobInfo();
        $new_job->make_id = $make_id;
        $new_job->model_id = $model_id;
        $new_job->year = $boat_year;
        $new_job->thruster_type_id = $thruster_type_id;
        $new_job->thruster_info = $thruster_info;
        $new_job->wiring_info = $wiring_info;
        $new_job->save();
        return($new_job->id);
    }

    protected function keep_only_numbers(&$boat_year){
        // remove any spaces, characters other than numbers
        $boat_year = preg_replace('/[^0-9]/', '', $boat_year);
        $boat_year = !empty($boat_year) ? $boat_year : 0;
    }

    protected function process_field($var = "", $field, $table, $model, $second_field="", $second_val=""){

        // prepare input
        $this->trim_down_strtolower_input($var);
        // determine - is this value stored already?
        //$b_new_value = $this->is_new_value( $var, 'name', "boat_makes");
        // TODO: replace below with above
        $b_new_value = $this->is_new_value( $var, $field, $table);

//        $this->pre_var_dump($b_new_value, 'new val: ', true);
        // try to store if this value does not exist - either way return make_id
        if( $b_new_value ){
            $new_val = new $model();
            $new_val->$field = $var;
            if(!empty($second_field)){
                $new_val->$second_field = $second_val;
            }
            $new_val->save();
        } else{
            $new_val = $model::byName($var);
        }
        return($new_val->id);
    }


    protected function is_new_value( $val, $field, $table ){
        $exists = DB::table($table)->select($field)->where($field, '=', $val)->first();
//        var_dump($exists); exit;
        if( !empty($exists)) {
            // val found - not new
            return false;
        } else{
            // no val found - new val
            return true;
        }
    }

    protected function try_to_store_make($boat_make, $a_all_makes){
//        $this->try_to_store_make($boat_make, $a_all_makes);

    }

    protected function get_all_makes(){
        $a_all_makes = DB::table('boat_makes')->pluck('name');
        return $a_all_makes;
    }

    // remove certain characters and multiple spaces, also trim whitespaces from beg & end
    protected function trim_down_strtolower_input(&$var){
        $var = trim($var);
        $var = preg_replace('!\s+!', ' ', $var);
        $var = str_replace(".", "", $var);
        $var = str_replace(",", "", $var);
        $var = str_replace("- ", "-", $var);
        $var = str_replace(" - ", "-", $var);
        $var = str_replace(" -", "-", $var);
        $var = strtolower($var);
    }




    public function pre_var_dump( $var, $header = "", $exit = false){
        echo "<pre><h2>$header</h2>";
        var_dump($var);
        echo "</pre>";
        if($exit == true){
            exit;
        }
    }



    protected function get_old_data(){

        $a_all_jobs = $a_jobs_table1 = $a_jobs_table2 = array();
        $jobs = DB::connection('mysql2')->table('jobs')->select()->get();
        $jobs2 = DB::connection('mysql2')->table('jobs2')->select()->get();

        foreach ($jobs as $job) {
            $a_all_jobs[] = array(
                "Boat_Make" => $job->Boat_Make,
                "Boat_Model" => $job->Boat_Model,
                "Boat_Year" => $job->Boat_Year,
                "Unit_Installed" => $job->Unit_Installed,
                "Thruster_Info" => $job->Thruster_Info,
                "Wiring_Info" =>  $job->Wiring_Info
            );

        }

        foreach ($jobs2 as $job) {
            $a_this_job = array(
                "Boat_Make" => $job->Boat_Make,
                "Boat_Model" => $job->Boat_Model,
                "Boat_Year" => $job->Boat_Year,
                "Unit_Installed" => $job->Unit_Installed,
                "Thruster_Info" => $job->Thruster_Info,
                "Wiring_Info" =>  $job->Wiring_Info
            );
            if(!in_array($a_this_job, $a_all_jobs)){
                $a_all_jobs[] = $a_this_job;
            }
        }
        return $a_all_jobs;




    }

}
