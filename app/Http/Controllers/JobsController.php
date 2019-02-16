<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index(){

        return view('jobs.index');
    }
    public function create(){
        return view('jobs.create');

    }
    public function store( $id ){

        return view('jobs.edit', 'id');

    }
    public function edit($id){

        echo "<h4>id: $id</h4>"; exit;

        return view('jobs.edit', 'id');

    }
    public function update($id){
        echo "<h4>id: $id</h4>"; exit;

        return view('jobs.edit', 'id');

    }
}
