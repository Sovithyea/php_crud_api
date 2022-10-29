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

    if(isset($_GET['id']))
    {
        $data = $post->show($_GET['id']);
        // var_dump($data);
        if($data->rowCount())
        {
            $post = [];
            
            while($row = $data->fetch(PDO::FETCH_OBJ))
            {
                $post = [
                    'id' => $row->id,
                    'category_name' => $row->category,
                    'description' => $row->description,
                    'title'=> $row->title,
                    'created_at' => $row->created_at
                ];
            }

            echo json_encode($post);

        }
        else
        {
            echo json_encode(['message' => 'No post data found.']);
        }
    }