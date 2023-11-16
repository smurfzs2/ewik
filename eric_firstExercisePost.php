<?php

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = ($_POST['gender'] == 0) ? 'Male' : 'Female';


    // echo "I am " . $name . ", I am" . $age . "years old and I am.";
    // echo ($gender == 0) ? 'Male' : 'Female';
}


?>


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
// eric_lotNUmberList.php
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
                            <label for="" class="form-label">Name: <?php echo $name; ?> </label>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="" class="form-label">Age: <?php echo $age; ?> </label>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="" class="form-label">Gender: <?php echo $gender; ?> </label>

                        </div>
                    </div>
                </div>

                <div class="d-flex flex-row-reverse bd-highlight pt-2">
                    <div class="bd-highlight">
                        <a href="eric_secondExerciseGet.php?<?php echo 'name='.$name.'&age='.$age.'&gender='.$gender;?>" class="btn btn-primary fw-bold">link text</a>
                        <!-- <button type="submit" name="submit" id="load" class="btn btn-primary fw-bold">GET DATA</button> -->
                    </div>
                </div>

        </div>
        </form>
    </div>
</body>

</html>