<?php
$data = [
    "data" => [
        "0" => [
            "DT_RowIndex" => 1,
            "action" => "01-0001",
            "roles" => "Administrator",
            "permissions" => [
                'user show',
                'user create',
                'user edit',
                'user delete'
            ]
        ],
        "1" => [
            "DT_RowIndex" => 2,
            "action" => "01-0002",
            "roles" => "Client",
            "permissions" => [
                'user show'
            ]
        ],
    ],
    "draw" => 1,
    "recordsFiltered" => 2,
    "recordsTotal" => 2,
];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
