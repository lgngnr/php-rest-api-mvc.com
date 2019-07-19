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

        /**
         * query function
         * Create a prepared statement
         *
         * @param [string] $sql
         * @return void
         * @throws PDOException
         */
        public function query($sql)
        {
            try
            {
                $this->stmt = $this->conn->prepare($sql);
            }
            catch(PDOException $e)
            {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        /**
         * bind function
         * Bind values to stmt
         *
         * @param [string] $param
         * @param [variable] $value
         * @param [int] $type
         * @return void
         */
        public function bind($param, $value, $type = null)
        {
            if(is_null($type))
            {
                // Bind correct param type
                switch(true)
                {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($type):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($type):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }

            try
            {
                $this->stmst->bindValue($param, $value, $type);
            }
            catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }


    }
?>