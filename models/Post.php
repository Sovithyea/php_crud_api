<?php

    error_reporting(E_ALL);
    ini_set('display _error', 1);

    class Post {
        public $id;
        public $category_id;
        public $title;
        public $description;
        public $create_at;

        private $connection;
        private $table = 'posts';

        public function __construct($db)
        {
            $this->connection = $db;
        }

        public function index()
        {
            $query = 'SELECT
                categories.name as category,
                posts.id,
                posts.title,
                posts.description,
                posts.category_id,
                posts.created_at
                FROM '.$this->table.' posts LEFT JOIN
                categories ON posts.category_id = categories.id    
                ORDER BY
                posts.created_at DESC
            ';

            $posts = $this->connection->prepare($query);
            $posts->execute();
            return $posts;
        }

        public function create()
        {
            $query = 'SELECT id, name FROM categories';

            $categories = $this->connection->prepare($query);

            $categories->execute();
            // var_dump($categories);
            return $categories;
        }

        public function store($params)
        {
            try
            {
                // var_dump($params);
                $this->title = $params['title'];
                $this->category_id = $params['category_id'];
                $this->description = $params['description'];
                $query = 'INSERT INTO '.$this->table.'
                    SET
                        title = :title,
                        category_id = :category_id,
                        description = :description
                ';

                $post = $this->connection->prepare($query);

                $post->bindValue('title', $this->title);
                $post->bindValue('description', $this->description);
                $post->bindValue('category_id', $this->category_id);

                if($post->execute())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function show($id)
        {
            $this->id = $id;

            $query = 'SELECT
                categories.name as category,
                posts.id,
                posts.title,
                posts.description,
                posts.category_id,
                posts.created_at
                FROM '.$this->table.' posts LEFT JOIN
                categories ON posts.category_id = categories.id 
                WHERE posts.id = :id
                LIMIT 0, 1
            ';
            // var_dump($this->id);
            $post = $this->connection->prepare($query);
            $post->bindParam('id', $this->id);
            $post->execute();
            return $post;
        }

        public function edit($id)
        {
            $this->id = $id;

            // $query = 'SELECT
            //     posts.id,
            //     posts.title,
            //     posts.description,
            //     posts.category_id,
            //     FROM '.$this->table.' 
            //     WHERE posts.id = :id
            //     LIMIT 0, 1
            // ';
                $query = 'SELECT * FROM posts, categories';
            // var_dump($this->id);
            $tables = $this->connection->prepare($query);
            $tables->bindParam('id', $this->id);
            $tables->execute();
            return $tables;
        }

        public function update($params)
        {
            try
            {
                // var_dump($params);
                $this->title = $params['title'];
                $this->category_id = $params['category_id'];
                $this->description = $params['description'];
                $this->id = $params['id'];
                $query = 'UPDATE '.$this->table.'
                    SET
                        title = :title,
                        category_id = :category_id,
                        description = :description
                    WHERE id = :id
                ';

                $post = $this->connection->prepare($query);

                $post->bindValue('title', $this->title);
                $post->bindValue('description', $this->description);
                $post->bindValue('category_id', $this->category_id);
                $post->bindParam('id', $this->id);
                if($post->execute())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function destroy($id)
        {
            $this->id = $id;

            $query = 'DELETE FROM '.$this->table.'
                WHERE posts.id = :id
            ';

            $post = $this->connection->prepare($query);
            $post->bindParam('id', $this->id);
            $post->execute();
            
            return $post;   
        }
    }