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

    $posts = new Post($db);

    $data = $posts->index();
    
    if($data->rowCount())
    {
        $posts = [];
        
        while($row = $data->fetch(PDO::FETCH_OBJ))
        {
            // print_r($row);
            $posts[$row->id] = [
                'id' => $row->id,
                'category_name' => $row->category,
                'description' => $row->description,
                'title'=> $row->title,
                'created_at' => $row->created_at
            ];
        }
        // var_dump($posts);
        echo json_encode($posts);
    }
    else
    {
        echo json_encode(['message' => 'No posts found.']);
    }

