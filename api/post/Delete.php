<?php

    error_reporting(E_ALL);
    ini_set('display_error', 1);

    Header('Access-Control-Allow-Origin: *');
    Header('Content-Type: application/json');

    include_once('../../config/Database.php');
    include_once('../../models/Post.php');

    $database = new Database;
    $db = $database->connect();

    $post = new Post($db);
    
    if (isset($_GET['id']))
    {
        if($post->destroy($_GET['id']))
        {
            echo json_encode('1 post has been delete.');
        }
        else
        {
            echo json_encode('Cannot find post.');
        }
    }
    else 
    {
        echo json_encode('hi');
    }