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

        /**
         * create() function Crud
         * Insert new product
         *
         * @return void
         */
        public function create($data)
        {
            $this->db->query("INSERT 
                INTO products(name, category_id, description, price)
                VALUES(:name, :category_id, :description, : price)");
        }

    }
?>