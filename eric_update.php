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
include('eric_function.php');
include('eric_connection.php');
$id = $_GET['id'];
echo $sqlSelect = "SELECT * FROM eric_db WHERE id = $id";
$query = $db->query($sqlSelect);
$result = $query->fetch_assoc();


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
            <form action="eric_function.php" method="post">
                <div class="form-label fw-bold text-center pt-4" style="font-size:24px">UPDATE FORM</div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">First Name:</label>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="text" class="form-control" value="<?php echo $result['firstName']; ?>" name="firstname" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Last Name:</label>
                            <input type="text" class="form-control" value="<?php echo $result['lastName']; ?>" name="lastname" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Age:</label>
                            <input type="number" class="form-control" value="<?php echo $result['age']; ?>" name=" age" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <span class="form-label">Gender:</span>
                            <select class="form-select" name="gender" aria-label="Default select example">
                                <option value="<?php echo $result['gender'] ?> " disable hidden><?php echo ($result['gender'] == 0) ? 'Male' : 'Female'; ?></option>
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Birthday:</label>
                            <input type="date" value="<?php echo $result['birthday']; ?> " class=" form-control" name="birthday" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Address:</label>
                            <input type="text" class="form-control" value="<?php echo $result['address']; ?> " name=" address" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse bd-highlight pt-2">
                    <div class="bd-highlight"><button type="submit" name="update" id="load" class="btn btn-primary fw-bold">update Form</button></div>
                </div>

        </div>
        </form>
    </div>
</body>

</html>