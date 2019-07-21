<?php
    namespace Vendor\Models;
    use Vendor\Core\Database;
    use Vendor\Popo;
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
         * @param Popo\Product $product
         * @return Product 
         */
        public function create($product)
        {
            // Prepare query
            $sql = "INSERT 
                    INTO products(name, category_id, description, price)
                    VALUES(:name, :category_id, :description, : price)";
            // Prepare statement
            $this->db->query($sql);
            // Bind params
            $this->db->bind(':name', $product->getName());
            $this->db->bind(':category_id', $product->getCategory_id());
            $this->db->bind(':description', $product->getDescription());
            $this->db->bind(':price', $product->getPrice());
            // Execute query & check result
            if($this->db->execute())
            {
                // Fill model
                $product->setId = $this->db->lastInsertId();
                return $product;
            }
            else
            {
                // Something goes wrong
                return false;
            }
        }

        /**
         * read() function cRud
         * Get a product
         * @param int $id
         * @return Popo\Product 
         */
        public function read($id)
        {
            // Prepare query
            $sql = "SELECT * FROM products WHERE id = :id";
            // Prepare statement
            $this->db->query($sql);
            // Bind params
            $this->db->bind(':id', $id);
            // Execute query & check result
            $res = $this->db->single();
            if($res)
            {
                // Create new Product POPO
                $product = new Popo\Product;
                // Fill model
                $product->seId = $res->id;
                $product->setName = $res->name;
                $product->setCategory_id = $res->category_id;
                $product->setDescription = $res->description;
                $product->setPrice = $res->price;
                return $product;
            }
            else
            {
                // Something goes wrong
                return false;
            }
        }
        
    }
?>