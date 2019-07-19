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

        /**
         * __construct function
         * Istantiace a new PDO persistent connection
         * @throws PDOException
         */
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
         */
        public function query($sql)
        {
            $this->stmt = $this->conn->prepare($sql);
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

            $this->stmt->bindValue($param, $value, $type);
        }

        /**
         * execute function
         * execute the prepared statement
         * @return boolean
         */
        public function execute()
        {
            return $this->stmt->execute();
        }

        /**
         * resultSet function
         * Execute the prepared statement, return records as array of obj
         *
         * @return array
         */
        public function resultSet()
        {
            $this->stmt->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        /**
         * single function
         * Execut prepared statement, return record as obj
         * @return object
         */
        public function single()
        {
            $this->stmt->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        /**
         * rowCount function
         *  Return numer of records
         * @return integer
         */
        public function rowCount()
        {
            return $this->stmt->rowCount();
        }

    }
?>