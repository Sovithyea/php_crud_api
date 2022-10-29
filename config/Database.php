<?php

    class Database {

        private $host = 'localhost';
        private $db_name = 'php_crud_api';
        private $username = 'root';
        private $password = '';
        private $connection;

        public function connect()
        {
            try 
            {
                $this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name,$this->username, $this->password);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }

            return $this->connection;
        }

 
    }