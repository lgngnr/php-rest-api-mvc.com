<?php
    namespace Vendor\Models;
    use Vendor\Core\Database;
    /**
     * Product Model class
     * 
     * Istantiate DB connection, implements Product CRUD operations
     */
    class Product
    {
        private $db;

        /**
         * __construct() function
         * Istantiate DB connection
         */
        public function __construct()
        {
            $this->db = new Database;
        }

    }
?>