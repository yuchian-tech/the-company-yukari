<?php
/**
 * Code to connect to the database
 */

    class Database{
        private $server_name = "localhost";
        private $username = "root";  //database
        private $password = "root"; //add 'root' if you use Mac
        private $db_name = "the-company";
        protected $conn;

        public function __construct(){
            $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);

            if ($this->conn->connect_error){
                die("Unable to connect to the database. " . $this->conn->connect_error);
            }
        }


    }