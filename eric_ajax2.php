<?php 
include 'eric_connection.php';

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length'];
$columnIndex = $_POST['order'][0]['column'];
$columnName = $_POST['columns'][$columnIndex]['data'];
$columnSortOrder = $_POST['order'][0]['dir'];
$searchValue = $_POST['search']['value'];

## Custom Field values
$searchByName = $_POST['searchByName'];
$searchByGender = $_POST['searchByGender'];
$searchByAge = $_POST['searchByAge'];
$searchByAddress = $_POST['searchByAddress'];
$searchByBirthday = $_POST['searchByBirthday'];
$searchByDepartment = $_POST['searchByDepartment'];

## Search 
$searchQuery = " WHERE 1 "; // Initialize the search query

// Build the search conditions
if (!empty($searchByName)) {
    $searchQuery .= " AND (firstName LIKE '%" . $searchByName . "%' ) ";
}
if ($searchByGender!='' ) {
    $searchQuery .= " AND (gender = " . $searchByGender . ") ";
}
if (!empty($searchByAge)) {
    $searchQuery .= " AND (age = '" . $searchByAge. "') ";
}
if (!empty($searchByAddress)) {
    $searchQuery .= " AND (address LIKE '%" . $searchByAddress . "%' ) ";
}
if (!empty($searchByDepartment)) {
    $searchQuery .= " AND (eric_db.departmentId = '" . $searchByDepartment . "') ";
}
if (!empty($searchByBirthday)) {
    $searchQuery .= " AND (birthday = '" . $searchByBirthday . "') ";
}

## Total number of records without filtering
$sel = mysqli_query($db, "SELECT COUNT(*) as allcount FROM eric_db INNER JOIN hr_department ON eric_db.departmentId = hr_department.departmentId");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$selFiltered = mysqli_query($db, "SELECT COUNT(*) as filterCount FROM eric_db INNER JOIN hr_department ON eric_db.departmentId = hr_department.departmentId " . $searchQuery);
$resFiltered = mysqli_fetch_assoc($selFiltered);
$totalRecordwithFilter = $resFiltered['filterCount'];

## Fetch records
$empQuery = "SELECT id, CONCAT(firstName,' ',lastName) as name, age, gender, birthday, address, departmentName FROM eric_db INNER JOIN hr_department ON eric_db.departmentId = hr_department.departmentId " . $searchQuery . " LIMIT $row, $rowperpage ";
$empRecords = mysqli_query($db, $empQuery);
// $resFiltered = $empRecords->num_rows;ss
$data = array();
    
while ($row = mysqli_fetch_assoc($empRecords)) {
    $id = $row['id'];
    $data[] = array(
        "id" => ++$_POST['start'], // Provide unique row ID for DataTables
        "name" => $row['name'],
        "age" => $row['age'],
        "gender" => ($row['gender'] == 0) ? 'Male' : 'Female',
        "address" => $row['address'],
        "birthday" => $row['birthday'],
        "departmentName" => $row['departmentName'],
        "action" => "<a href='eric_update.php?id=$id' class='btn btn-primary fw-bold btn-sm'><i class='fas fa-edit'></i></a>  
                    <a href='eric_function.php?ids=$id' class='btn btn-danger fw-bold btn-sm'><i class='delete fas fa-trash' style='color:#ffffff'></i></a>"
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "recordsTotal" => $totalRecords,
    "recordsFiltered" => $totalRecords,
    "data" => $data, // Change "aaData" to "data",
);

echo json_encode($response);
