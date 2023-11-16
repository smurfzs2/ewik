<?php
include('eric_connection.php');

$query = $db->query("SELECT count(id) FROM eric_db");
$totalRecords = $query->fetch_row()[0];

$length = $_GET['length'];
$start = $_GET['start'];

 $sql = "SELECT id, CONCAT(firstName,' ',lastName) as name, age, gender, birthday,address, departmentName FROM eric_db INNER JOIN hr_department ON eric_db.departmentId = hr_department.departmentId   ";

if (isset($_GET['search']) && !empty($_GET['search']['value'])) {
    $search = $_GET['search']['value'];
    $sql .= sprintf(" WHERE firstName like '%s' OR address like '%s' OR departmentName like '%s'", '%' . $db->real_escape_string($search) . '%', '%' . $db->real_escape_string($search) .'%', '%' . $db->real_escape_string($search) . '%');
}
$sql .= " LIMIT $start, $length";
$query = $db->query($sql);
$result = [];
$i = 0;
while ($row = $query->fetch_assoc()) {
    $id = $row['id'];
    $result[] = [
        ++$i,
        $row['name'],
        $row['age'],
        ($row['gender']==0)?'Male':'Female',
        $row['birthday'],
        $row['address'],
        $row['departmentName'],
        " <a href='eric_update.php?id=$id' class='btn btn-primary fw-bold'> edit  </a>  
            <a href='eric_function.php?ids=$id' class='btn btn-warning fw-bold'> delete  </a> "
    ];
}

echo json_encode([
    'draw' => $_GET['draw'],
    'recordsTotal' => $totalRecords,
    'recordsFiltered' => $totalRecords,
    'data' => $result,
]);
