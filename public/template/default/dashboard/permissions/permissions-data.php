<?php
$data = [
    "data" => [
        "0" => [
            "DT_RowIndex" => 1,
            "action" => "01-0001",
            "permissions" => "user show"
        ],
        "1" => [
            "DT_RowIndex" => 2,
            "action" => "01-0001",
            "permissions" => "user create"
        ],
        "2" => [
            "DT_RowIndex" => 3,
            "action" => "01-0001",
            "permissions" => "user edit"
        ],
        "3" => [
            "DT_RowIndex" => 4,
            "action" => "01-0001",
            "permissions" => "user delete"
        ],
        "4" => [
            "DT_RowIndex" => 5,
            "action" => "01-0001",
            "permissions" => "role show"
        ],
        "5" => [
            "DT_RowIndex" => 6,
            "action" => "01-0001",
            "permissions" => "role create"
        ],
        "6" => [
            "DT_RowIndex" => 7,
            "action" => "01-0001",
            "permissions" => "role edit"
        ],
        "7" => [
            "DT_RowIndex" => 8,
            "action" => "01-0001",
            "permissions" => "role delete"
        ],

    ],
    "draw" => 1,
    "recordsFiltered" => 2,
    "recordsTotal" => 2,
];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
