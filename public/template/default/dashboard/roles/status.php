<?php
$input = array("success", "failed");
$rand_keys = array_rand($input, 1);

$data = [
    "status" => $input[$rand_keys]
];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
