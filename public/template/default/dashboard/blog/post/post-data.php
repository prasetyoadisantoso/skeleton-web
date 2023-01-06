<?php
$data = [
    "data" => [
        "0" => [
            "DT_RowIndex" => 1,
            "title" => "Post 1",
            "image" => "../../../assets/img/beach-1.jpg",
            "published" => "01/01/2023",
            "action" => "01-0001",
        ],
        "1" => [
            "DT_RowIndex" => 2,
            "title" => "Post 2",
            "image" => "../../../assets/img/beach-2.jpg",
            "published" => "01/02/2023",
            "action" => "01-0001",
        ],

    ],
    "draw" => 1,
    "recordsFiltered" => 2,
    "recordsTotal" => 2,
];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
