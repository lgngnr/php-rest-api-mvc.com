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
        private $name;
        private $category_id;
        private $description;
        private $price;

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
         * @return Product 
         */
        public function create($data)
        {
            // Prepare query
            $sql = "INSERT 
                    INTO products(name, category_id, description, price)
                    VALUES(:name, :category_id, :description, : price)";
            // Prepare statement
            $this->db->query($sql);
            // Bind params
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':category_id', $data['category_id']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':price', $data['price']);
            // Execute query & check result
            if($this->db->execute())
            {
                // Fill model
                $this->name = $data['name'];
                $this->category_id = $data['category_id'];
                $this->description = $data['description'];
                $this->price = $data['price'];
                return $this;
            }
            else
            {
                // Something goes wrong
                return false;
            }
        }


        /**
         * Get the value of name
         */ 
        public function getName()
        {
                return $this->name;
        }

        /**
         * Get the value of category_id
         */ 
        public function getCategory_id()
        {
                return $this->category_id;
        }

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Get the value of price
         */ 
        public function getPrice()
        {
                return $this->price;
        }
    }
?>