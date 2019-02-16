@extends('layouts.layout')


@section('contents')


<?php
echo "<h2>transfer</h2>";
?>

        <form method="post">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="get_data" value="1">
                    <input type="submit" class="btn btn-primary" value="get data">
                </div>
            </div>
        </form>


<?php
echo "<div class='container-fluid'>";
foreach ($old_data as $key => $job) {
    echo "<div class='row'>";
    echo "<div class='col-lg-1'><h1>$key</h1>" . $job['Boat_Make'] . " </div>";
    echo "<div class='col-lg-1'>" . $job['Boat_Model'] . " </div>";
    echo "<div class='col-lg-1'>" . $job['Boat_Year'] . " </div>";
    echo "<div class='col-lg-1'>" . $job['Unit_Installed'] . " </div>";
    echo "<div class='col-lg-4'>" . $job['Thruster_Info'] . " </div>";
    echo "<div class='col-lg-4'>" . $job['Wiring_Info'] . " </div>";
    echo "</div><hr>";
}
echo "</div>";
?>





@endsection
