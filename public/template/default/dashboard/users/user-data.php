<?php
$data = [
    "data" => [
        "0" => [
            "DT_RowIndex" => 1,
            "action" => "01-0001",
            "name" => "Administrator Department",
            "image" => "../../assets/img/profile.png",
            "email" => "admin@email.com",
        ],
        "1" => [
            "DT_RowIndex" => 2,
            "action" => "01-0002",
            "name" => "Best Client",
            "image" => "../../assets/img/profile.png",
            "email" => "client@email.com",
        ],
    ],
    "draw" => 1,
    "recordsFiltered" => 2,
    "recordsTotal" => 2,
];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
