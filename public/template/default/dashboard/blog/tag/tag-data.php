<?php
$data = [
    "data" => [
        "0" => [
            "DT_RowIndex" => 1,
            "name" => "good news",
            "slug" => "good-news",
            "action" => "01-0001",
        ],
        "1" => [
            "DT_RowIndex" => 2,
            "name" => "update news",
            "slug" => "update-news",
            "action" => "01-0001",
        ],
        "2" => [
            "DT_RowIndex" => 3,
            "name" => "new post",
            "slug" => "new-post",
            "action" => "01-0001",
        ],

    ],
    "draw" => 1,
    "recordsFiltered" => 2,
    "recordsTotal" => 2,
];
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
