<?php
$data = [
  ["id" => 1, "content" => "Data 1"],
  ["id" => 2, "content" => "Data 2"],
  ["id" => 3, "content" => "Data 3"],
  // Add more data entries as needed
];

// Send the data in JSON format
header("Content-Type: application/json");
echo json_encode($data);
?>