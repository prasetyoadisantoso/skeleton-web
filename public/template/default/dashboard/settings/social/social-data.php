<?php
$data = [
    "data" => [
        "0" => [
            "DT_RowIndex" => 1,
            "name" => "Facebook",
            "url" => "https://facebook.com/username",
            "action" => "01-0001",
        ],
        "1" => [
            "DT_RowIndex" => 2,
            "name" => "Whatsapp",
            "url" => "https://api.whatsapp.com/send",
            "action" => "01-0001",
        ],
        "2" => [
            "DT_RowIndex" => 3,
            "name" => "Twitter",
            "url" => "https://twitter.com/username",
            "action" => "01-0001",
        ],
    ],
    "draw" => 1,
    "recordsFiltered" => 2,
    "recordsTotal" => 2,
];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
