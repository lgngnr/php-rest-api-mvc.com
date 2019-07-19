<?php

    /**
     * Database class
     * Handle PDO connection and query
     */
    class Database
    {
        private $db_host = DB_HOST;
        private $db_name = DB_NAME;
        private $db_user = DB_USER;
        private $db_pass = DB_PASS;

        private $conn;
        private $stmt;
        private $error;

        public function __construct()
        {
            // prepare dns and options
            $dns = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            // Create connection
            try
            {
                $this->conn = new PDO($dns, $this->db_user, $this->db_pass, $options);
            }
            catch(PDOException $e)
            {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

    }
?>