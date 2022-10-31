<?php

    error_reporting(E_ALL);
    ini_set('display_error', 1);

    Header('Access-Control-Allow-Origin: *');
    Header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');

    include_once('../../config/Database.php');
    include_once('../../models/Post.php');

    $database = new Database;
    $db = $database->connect();

    $posts = new Post($db);

    $data = $posts->create();

    if($data->rowCount())
    {
        $categories = [];
        $res = [];
        while($row = $data->fetch(PDO::FETCH_OBJ))
        {
            // print_r($row);
            $categories[$row->id] = [
                'id' => $row->id,
                'name' => $row->name
            ];
            array_push($res, $categories[$row->id]);
        }
        // var_dump($posts);
        // $dataa.array_push($posts);
        echo json_encode(['categories' => $res]);
    }
    else
    {
        echo json_encode(['message' => 'No posts found.']);
    }

