<?php 
 
// Load the database configuration file 
include 'eric_connection.php'; 
 
// Fetch records from database 
$query = $db->query("SELECT * FROM eric_db"); 
 
if($query->num_rows > 0){ 
    // $delimiter = ","; 
    $filename = "eric_adata" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('ID','FIRSTNAME','LASTNAME','AGE','GENDER','BIRHTDAY','ADDRESS'); 
    fputcsv($f, $fields, ","); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    // $data = [];
    while($row = $query->fetch_assoc()){ 
        $gender = ($row['gender'] == 0)?'Male':'Female'; 
       $lineData = array($row['id'], $row['firstName'], $row['lastName'], $row['age'], $gender, $row['birthday'], $row['address']); 
       fputcsv($f, $lineData, ",");
        //$data [] = '{country:'."'$gender',age:".$row['age']."}";
    } 
    // echo '<PRE>';
    //  print_r($data);
    // echo '</PRE>';
    // Move back to beginning of file 
   fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
   header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit;
?>
