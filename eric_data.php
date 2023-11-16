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
// eric_lotNUmberList.php
if (isset($_POST['filter'])) {
    // if(isset($_POST['']))
    $nameFilter = ($_POST['name'] != "") ?  " AND firstName LIKE '%" . $_POST['name'] . "%'" : "";
    $ageFilter = ($_POST['age'] != "") ? " AND age = " . $_POST['age'] : "";
    $genderFilter = ($_POST['gender'] != "") ?  " AND gender = " . $_POST['gender'] : "";
    $addressFilter = ($_POST['address'] != "") ?  " AND address LIKE '%" . $_POST['address'] . "%        '" : "";
    $birthdayilter = ($_POST['birthday'] != "") ?   " AND birthday LIKE '" . $_POST['birthday'] . "'" : "";
    $departmentFilter = ($_POST['department'] != "") ?   " AND eric_db.departmentId=" . $_POST['department'] : "";

    echo $_POST['name'];
    echo $_POST['address'];
    echo $filter = "WHERE 1 = 1" . $nameFilter . " " . $ageFilter . " " . $genderFilter . " " . $addressFilter . " " . $birthdayilter . " " . $departmentFilter;
}

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
    <form action="eric_data.php" method="post">
        <div class="container-fluid p-5">
            <div class="d-flex flex-row-reverse bd-highlight">
                <div class="p-2 bd-highlight">
                    <a href='eric_csv.php' class='btn btn-primary fw-bold'> CSV </a>
                </div>
                <div class="p-2 bd-highlight">
                    <a href='eric_pdf.php' class='btn btn-primary fw-bold'> PDF </a>
                </div>
                <div class="p-2 bd-highlight">
                    <a href='eric_pieGraph.php' class='btn btn-warning fw-bold'> Pie Graph</a>
                </div>
                <div class="p-2 bd-highlight">
                    <a href='eric_barGraph.php' class='btn btn-success fw-bold'> Bar Graph</a>
                </div>
                <div class="p-2 bd-highlight">
                    <a href='eric_clusteredGraph.php' class='btn btn-info fw-bold'> Clustered Graph</a>
                </div>
                <div class="p-2 bd-highlight">
                    <div class="bd-highlight"><button type="submit" name="filter" class="btn btn-primary fw-bold">SORT</button></div>
                </div>
                <div class="p-2 bd-highlight">
                    <select class="form-select" value="<?php echo $_POST['name']; ?>" name="name">
                        <!-- <option hidden selected>Name</option> -->
                        <option value=""></option>
                        <?php echo getNamesData(); ?>
                    </select>
                </div>
                <div class="p-2 bd-highlight">
                    <select class="form-select" value="<?php echo $_POST['age']; ?>" name="age">
                        <!-- <option hidden selected>Age</option> -->
                        <option value=""></option>
                        <?php echo getAgeData(); ?>
                    </select>
                </div>
                <div class="p-2 bd-highlight">
                    <select class="form-select" value="<?php echo $_POST['gender']; ?>" name="gender">
                        <!-- <option hidden sele cted>Gender</option> -->
                        <option value=""></option>
                        <option value="0">Male</option>
                        <option value="1">Female</option>
                    </select>
                </div>
                <div class="p-2 bd-highlight">
                    <select class="form-select" value="<?php echo $_POST['birthday']; ?>" name="birthday">
                        <!-- <option hidden selected>Birthday</option> -->
                        <option value=""></option>
                        <?php echo getBdateData(); ?>
                    </select>
                </div>
                <div class="p-2 bd-highlight">
                    <select class="form-select" value="<?php echo $_POST['address']; ?>" name="address">
                        <!-- <option hidden>Address</option> -->
                        <option value=""></option>
                        <?php echo getaddressData(); ?>
                    </select>
                </div>
                <div class="p-2 bd-highlight">
                    <select class="form-select" value="<?php echo $_POST['']; ?>" name="department">
                        <!-- <option hidden>Address</option> -->
                        <option value=""></option>
                        <?php echo getDepartmentData(); ?>
                        <?php  ?>
                    </select>
                </div>
    </form>
    </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Age</th>
                <th scope="col">Gender</th>
                <th scope="col">Address</th>
                <th scope="col">Birthday</th>
                <th scope="col">Department</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php ($filter != "") ? filterData($filter) : getData(); ?>
        </tbody>
    </table>

    </div>
</body>

</html>