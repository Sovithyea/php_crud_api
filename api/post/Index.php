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

    $data = $posts->index();
    
    if($data->rowCount())
    {
        $posts = [];
        $res = [];
        while($row = $data->fetch(PDO::FETCH_OBJ))
        {
            $posts[$row->id] = [
                'id' => $row->id,
                'category_name' => $row->category,
                'description' => $row->description,
                'title'=> $row->title,
                'created_at' => $row->created_at
            ];
            array_push($res, $posts[$row->id]);
        }
        // var_dump($posts);
        // $dataa.array_push($posts);
        echo json_encode(["data"=>$res]);
    }
    else
    {
        echo json_encode(['message' => 'No posts found.']);
    }

