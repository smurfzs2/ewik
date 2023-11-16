<?php
// include('eric_connection.php');
include $_SERVER['DOCUMENT_ROOT'] . "/version.php";
$path = $_SERVER['DOCUMENT_ROOT'] . "/" . v . "/Common Data/";
set_include_path($path);
include('PHP Modules/mysqliConnection.php');
include('PHP Modules/gerald_functions.php');
include('PHP Modules/anthony_retrieveText.php');
include("PHP Modules/anthony_wholeNumber.php");
ini_set("display_errors", "on");
function getWholeWeekExceptSunday($dateStr)
{
    $currentDate = new DateTime($dateStr);

    // Find the start day (Monday) of the week
    while ($currentDate->format('N') != 1) {
        $currentDate->modify('-1 day');
    }
    $startOfWeek = clone $currentDate;

    // Find the end day (Sunday) of the week (end of the week is the given date)
    $endOfWeek = new DateTime($dateStr);

    return array(
        'startOfWeek' => $startOfWeek->format('Y-m-d'),
        'endOfWeek' => $endOfWeek->format('Y-m-d')
    );
}
function generateTable($data, $skipColumns)
{
    if (empty($data)) {
        return;
    }

    echo '<table border="1" style="width:100%; font-size: 14px; font-family: sans-serif">';
    echo '<tr>';
    foreach ($data[0] as $key => $value) {
        if (!in_array($key, $skipColumns)) {
            echo '<th>' . ucfirst($key) . '</th>';
        }
    }
    echo '</tr>';

    foreach ($data as $row) {
        foreach ($row as $key => $value) {
            if (!in_array($key, $skipColumns)) {
                echo '<td>' . $value . '</td>';
            }
        }
        echo '</tr>';
    }

    echo '</table>';
}

// Example usage with '2023-08-04' as the given date:
// extract($getWholeWeekExceptSunday)

$dateStr = date('Y-m-d');
$result = getWholeWeekExceptSunday($dateStr);

extract($result);

echo $startOfWeek . $endOfWeek;
$startOfWeek = '2023-07-01';
$endOfWeek = '2023-07-31';      


$lotArray = $lotArrays = $countArrays = $displayArrays = array();
$sqlSelect = "SELECT customerAlias, ppic_workschedule.customerId, poNumber, lotNumber,partNumber,targetFinish, receiveDate, deliveryDate FROM `ppic_workschedule` INNER JOIN sales_customer ON sales_customer.customerId = ppic_workschedule.customerId
WHERE ppic_workschedule.`status` = 0 AND targetFinish BETWEEN '$startOfWeek' AND '$endOfWeek' AND `processCode` = 518 AND poNumber NOT LIKE 'IPOgeraldTest' GROUP BY poId ORDER BY targetFinish ASC";
echo "<br>";
$query = $db->query($sqlSelect);
if ($query->num_rows > 0) {
    while ($result = $query->fetch_assoc()) {
        $lotArray[] = $result['lotNumber'];
        $countArrays[] = $result['targetFinish'];
        $displayArrays[$result['targetFinish']][]= $result;
    }
}

$targetFinishCounts = array_count_values($countArrays);


$lotQuery = "'" . implode("','", $lotArray) . "'";
// foreach($lotArray as $key => $data){
$sqlSelect = "SELECT customerAlias, ppic_workschedule.customerId, poNumber, lotNumber,partNumber,targetFinish, receiveDate, deliveryDate 
FROM `ppic_workschedule` INNER JOIN sales_customer ON sales_customer.customerId = ppic_workschedule.customerId 
WHERE ppic_workschedule.`status` = 1 
AND `processCode` = 187 AND lotNumber IN ($lotQuery) GROUP BY poId ORDER BY targetFinish ASC";
// echo "<br>";
$query = $db->query($sqlSelect);
if ($query->num_rows > 0) {
    while ($result = $query->fetch_assoc()) {
        $lotArrays[] = $result;
        $lotArrays2[$result['targetFinish']][] = $result;
    }
}

$targetFinishCountss = array_count_values(array_column($lotArrays, 'targetFinish'));

// $counts = array_intersect(array_column($displayArrays, 'lotNumber'), array_column($lotArrays2, 'lotNumber'));

$mergedArray = array_merge_recursive($targetFinishCounts, $targetFinishCountss);
sort($mergedArray,'targetFinish');
echo '<table border=1 style="width:50%; height: 50%; font-size: 20px; font-family: sans-serif">';
echo '<tr><th>Target Finish Date</th><th>Raw LotNumber</th><th>Finish</th><th>Balance</th></tr>';
echo "<form id='formDisplay' method = 'post' action=''></form>";
$balance = 0;
foreach ($mergedArray as $date => $counts) {
    // if($counts[1])
    // Check if $counts is an array with two indexes
    if (is_array($counts) && count($counts) === 2) {
        $count1 = isset($counts[0]) ? $counts[0] : 0;
        $count2 = isset($counts[1]) ? $counts[1] : 0;
        $balance = $count1 - $count2;
    } else {
        // If $counts is not an array or has only one index, set $count1 to $counts and $count2 to 0
        $count1 = is_array($counts) ? $counts[0] : $counts;
        $count2 =  is_array($counts) ? $counts[1] : 0;

        $balance = $count1;
        // $balance = $count1 - $count2;
    }

    echo "<tr>
            <td>{$date}</td>
            <td><button type='submit' form='formDisplay' name='selectedDate' value='{$date}'>{$count1}</button></td>
            <td><button type='submit' form='formDisplay' name='selectedDate2' value='{$date}'>{$count2}</button></td>
            <td><button type='submit' form='formDisplay' name='balance' value='{$date}'>{$balance}</button></td>
        </tr>";
}

echo '</table>';

$skipColumns = ['customerId'];
$selectedData = "";
if(isset($_POST['selectedDate'])){//count1
    $selectedDate = $_POST['selectedDate'];
    $selectedData = isset($displayArrays[$selectedDate]) ? $displayArrays[$selectedDate] : [];
    echo $selectedDate;
    echo generateTable($selectedData, $skipColumns);
}
else if (isset($_POST['selectedDate2'])) {//count2
    $selectedDate = $_POST['selectedDate2'];
    $selectedData = isset($lotArrays2[$selectedDate]) ? $lotArrays2[$selectedDate] : [];
    echo $selectedDate;

    echo generateTable($selectedData, $skipColumns);
}
else if (isset($_POST['balance'])) {//balance
    $selectedDate = $_POST['balance'];
    $selectedData = isset($displayArrays[$selectedDate]) ? $displayArrays[$selectedDate] : [];
    $selectedData2 = isset($lotArrays2[$selectedDate]) ? $lotArrays2[$selectedDate] : [];

    $commonLotNumber = array_intersect(array_column($selectedData, 'lotNumber'), array_column($selectedData2, 'lotNumber'));

    echo $selectedDate;
    // Filter out rows from $array2 with common poId
    $filteredArray2 = array_filter($selectedData, function ($row) use ($commonLotNumber) {
        return !in_array($row['lotNumber'], $commonLotNumber);
    });

    echo generateTable($filteredArray2, $skipColumns);
    
}

echo "<pre>";
    //  print_r($mergedArray['2023-07-19']);
    // // print_r($targetFinishCountss['2023-07-19']);
    // print_r($displayArrays['2023-07-19']);
    print_r($lotArrays2);
    
    echo "</pre>";
print_r($commonLotNumber);
?>