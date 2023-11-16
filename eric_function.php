<?php
if(isset($_POST['insert'])){
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $age = $_POST['age'];
    $gender = ($_POST['gender']=='')?'0':$_POST['gender'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];

    insertData($firstName,$lastName,$age,$gender,$birthday,$address);
}
if (isset($_POST['update'])) {
    $ids = $_POST['id'];
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $age = $_POST['age'];
    $gender = ($_POST['gender'] == '') ? '0' : $_POST['gender'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];

    updateData($ids,$firstName, $lastName, $age, $gender, $birthday, $address);
}
if (isset($_GET['ids'])) {

    deleteData($_GET['ids']);
}
function filterData($filter)
{
    include('eric_connection.php');

    echo $sqlSelect = "SELECT id,firstName,lastName,age,gender,birthday,address,departmentName FROM eric_db INNER JOIN hr_department ON eric_db.departmentId = hr_department.departmentId $filter";
    $query = $db->query($sqlSelect);
    $i = 0;
    if ($query->num_rows > 0) {
        while ($result = $query->fetch_assoc()) {
            $id = $result['id'];
            echo "<tr> ";
            echo  "<td>" . ++$i . "</td>";
            echo  "<td>" . $result['firstName'] . " </td>";
            echo  "<td>" . $result['lastName'] . " </td>";
            echo  "<td>" . $result['age'] . "</td>";
            echo ($result['gender'] == 0) ? '<td>Male</td>' : '<td>Female</td>';
            echo  "<td>" . $result['address'] . "</td>";
            echo  "<td>" . $result['birthday'] . "</td>";
            echo  "<td>" . $result['departmentName'] . "</td>";
            echo  "<td>    
            <a href='eric_update.php?id=$id' class='btn btn-primary fw-bold'> edit  </a>  
            <a href='eric_function.php?ids=$id' class='btn btn-warning fw-bold'> delete  </a> 
             </td>";
            echo "</tr>";
        }
    }
}
function insertData($f,$l,$age,$gender,$b,$address){
    include('eric_connection.php');

    $sqlInsert = "INSERT INTO eric_db (firstName,lastName,age,gender,address,birthday) VALUES 
    ('".$f."','".$l."',$age,$gender,'".$address."','".$b."')";

    $query = $db->query($sqlInsert);

    if ($query) {
        // echo 'success';
        header('location:eric_quickTable2.php');
    } else {
        echo 'failed'.$db->error.$sql;
    }

}
function getData(){
    include('eric_connection.php');

    $sqlSelect = "SELECT id,firstName,lastName,age,gender,birthday,address,departmentName FROM eric_db INNER JOIN hr_department ON eric_db.departmentId = hr_department.departmentId";
    $query = $db->query($sqlSelect);
    $i = 0;
    if ($query->num_rows > 0)
    {
        while($result = $query->fetch_assoc()){
            $id = $result['id'];
            echo "<tr> ";
            echo  "<td>".++$i."</td>";
            echo  "<td>".$result['firstName']." </td>";
            echo  "<td>".$result['lastName']." </td>";
            echo  "<td>".$result['age']."</td>";
            echo  ($result['gender'] == 0)? '<td>Male</td>': '<td>Female</td>';
            echo  "<td>".$result['address']."</td>";
            echo  "<td>".$result['birthday']."</td>";
            echo  "<td>" . $result['departmentName'] . "</td>";
            echo  "<td>    
            <a href='eric_update.php?id=$id' class='btn btn-primary fw-bold'> edit  </a>  
            <a href='eric_function.php?ids=$id' class='btn btn-warning fw-bold'> delete  </a> 
             </td>";
            echo "</tr>";
        }
    }
    else
     echo $db->error;
}
function updateData($ids,$f,$l,$age,$gender,$b,$address){
   
    include('eric_connection.php');
    $sqlUpdate = "UPDATE eric_db SET firstname = '$f', lastName='$l', age=$age, gender= $gender, address='$address', birthday = '$b' WHERE id = $ids ";
    $query = $db->query($sqlUpdate);

    if($query)
    {
        header('location:eric_quickTable2.php');
    } 
}
function deleteData($id){
    include('eric_connection.php');

   echo $sqlDelete = "DELETE FROM eric_db WHERE id = $id";
    $query = $db->query($sqlDelete);
    if($query)
    {
        header('location:eric_quickTable2.php');
    }
}
function getNamesData(){
    include('eric_connection.php');
    $sqlSelect = "SELECT DISTINCT CONCAT(firstName,' ',lastName) AS names FROM eric_db";
    $query = $db->query($sqlSelect);
    $i = 0;
    if ($query->num_rows > 0) {
        while ($result = $query->fetch_assoc()) {
            echo  "<option value=" . $result['names'].">" . $result['names'] . " </option>";
        }
    }
}
function getAgeData()
{
    include('eric_connection.php');
    $sqlSelect = "SELECT DISTINCT age FROM eric_db";
    $query = $db->query($sqlSelect);
    $i = 0;
    if ($query->num_rows > 0) {
        while ($result = $query->fetch_assoc()) {
            echo  "<option value=" . $result['age'] . ">" . $result['age']. " </option>";
        }
    }
}
function getAddressData()
{
    include('eric_connection.php');
    $sqlSelect = "SELECT DISTINCT address FROM eric_db";
    $query = $db->query($sqlSelect);
    $i = 0;
    if ($query->num_rows > 0) {
        while ($result = $query->fetch_assoc()) {
            echo  "<option value='" . $result['address'] . "'>" . $result['address'] . " </option>";
        }
    }
}
function getBdateData()
{
    include('eric_connection.php');
    $sqlSelect = "SELECT DISTINCT birthday  FROM eric_db";
    $query = $db->query($sqlSelect);
    $i = 0;
    if ($query->num_rows > 0) {
        while ($result = $query->fetch_assoc()) {
            echo  "<option value=" . $result['birthday'] . ">" . $result['birthday'] . " </option>";
        }
    }
}
function getDepartmentData()
{
    include('eric_connection.php');
    $sqlSelect = "SELECT departmentId, departmentName FROM hr_department";
    $query = $db->query($sqlSelect);
    $i = 0;
    if ($query->num_rows > 0) {
        while ($result = $query->fetch_assoc()) {
            echo  "<option value=" .$result['departmentId'] . ">" . $result['departmentName'] . " </option>";
        }
    }
}
function barGraphData(){
    include('eric_connection.php');
    // $query = $db->query("SELECT count(*) as total, gender FROM eric_db group by gender");
    $query = $db->query("SELECT count(*) as total,departmentName FROM eric_db INNER JOIN hr_department ON eric_db.departmentId = hr_department.departmentId group by departmentName");
    $data = array();
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $data[] = ['departments' => $row['departmentName'], 'value' => (int)$row['total']];
        }
        echo $data = json_encode($data);
    }
}
function clusteredGraphData(){
    include('eric_connection.php');
    // $query = $db->query("SELECT count(*) as total, gender FROM eric_db group by gender");
    $query = $db->query("SELECT sum(gender = 0) as male,sum(gender = 1) as female,departmentName FROM eric_db INNER JOIN hr_department ON eric_db.departmentId = hr_department.departmentId group by departmentName");
    $data = array();
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $data[] = ['departments' => $row['departmentName'], 'male' => (int)$row['male'], 'female' => (int)$row['female'],];
        }
        echo $data = json_encode($data);
    }
}
?>