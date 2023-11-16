<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/version.php";
$path = $_SERVER['DOCUMENT_ROOT'] . "/" . v . "/Common Data/";
set_include_path($path);
include('PHP Modules/mysqliConnection.php');
include('PHP Modules/anthony_wholeNumber.php');
include('PHP Modules/anthony_retrieveText.php');
include('PHP Modules/gerald_functions.php');
include('PHP Modules/rose_prodfunctions.php');
ini_set("display_errors", "on");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href='../assets/bootstrap/css/bootstrap.css'>
    <title>Exercise 1</title>
</head>

<body>
    <div class="container-fluid">
        <div class="offset-md-4" style="height: 80vh; width: 80vh;">
            <form action="eric_secondExerciseGet.php" method="GET">
                <div class="form-label fw-bold text-center pt-4" style="font-size:24px">EXERSICE 1</div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Name:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Age:</label>
                            <input type="number" class="form-control" name="age" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <span class="form-label">Gender:</span>
                            <select class="form-select" name="gender" aria-label="Default select example">
                                <option hidden selected>Select</option>
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse bd-highlight pt-2">
                    <div class="bd-highlight"><button type="submit" name="submit" id="load" class="btn btn-primary fw-bold">Submit Form</button></div>
                </div>

        </div>
        </form>
    </div>
</body>

</html>