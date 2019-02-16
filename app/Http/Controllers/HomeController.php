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

            $make_id = $this->process_make($data['Boat_Make']);

        }
        echo "<h1>here</h1>";
        exit;
    }

    protected function process_make($boat_make = ""){

        // prepare input
        $this->trim_down_strtolower_input($boat_make);
        // determine - is this value stored already?
        //$b_new_value = $this->is_new_value( $boat_make, 'name', "boat_makes");
        // TODO: replace below with above
        $b_new_value = $this->is_new_value( $boat_make, 'name', "boat_makes");

//        $this->pre_var_dump($b_new_value, 'new val: ', true);
        // try to store if this value does not exist - either way return make_id
        if( $b_new_value ){
            $new_make = new \App\BoatMake();
            $new_make->name = $boat_make;
            $new_make->save();
        } else{
            $new_make = \App\BoatMake::byName($boat_make);
        }
        return($new_make->id);
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
