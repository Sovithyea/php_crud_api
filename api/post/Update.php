<?php

    error_reporting(E_ALL);
    ini_set('display_error', 1);

    Header('Access-Control-Allow-Origin: *');
    Header('Content-Type: application/json');
    Header('Access-Controller-Allow-Method: POST');

    include_once('../../config/Database.php');
    include_once('../../models/Post.php');

    $database = new Database;
    $db = $database->connect();

    $post = new Post($db);

    $data = json_decode(file_get_contents('php://input'));
    
    if (isset($data))
    {
        $params = [
            'title' => $data->title,
            'description' => $data->description,
            'category_id' => $data->category_id,
            'id' => $data->id
        ];

        if($post->update($params))
        {
            echo json_encode(['message' => 'Post update successfully.']);
        }
    }