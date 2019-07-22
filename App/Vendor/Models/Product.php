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
                    VALUES(:name, :category_id, :description, :price)";
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
                $product->setId($this->db->lastInsertId());
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
                $product->setId($res->id);
                $product->setName($res->name);
                $product->setCategory_id($res->category_id);
                $product->setDescription($res->description);
                $product->setPrice($res->price);
                return $product;
            }
            else
            {
                // Something goes wrong
                return false;
            }
        }

        /**
         * update function crUd
         * modify fields for an existing record
         * 
         * @param Popo\Product $product
         * @return Popo\Product
         */
        public function update($product){
            // Prepare query
            $sql = "UPDATE products SET 
                        name= :name, 
                        category_id = :category_id,
                        description = :description,
                        price = :price
                    WHERE id = :id";
            // Prepare stmt
            $this->db->query($sql);
            //Bind Params
            $this->db->bind(':name', $product->getName());
            $this->db->bind(':category_id', $product->getCategory_id());
            $this->db->bind(':description', $product->getDescription());
            $this->db->bind(':price', $product->getPrice());
            $this->db->bind(':id', $product->getId());
            // Execute query
            if($this->db->execute())
            { // Success
                return $product;
            }
            else
            { // Failure
                return false;
            }
        }

        /**
         * delete function cruD
         * delete a product by a given id
         * @param int $id
         * @return bool success/failure
         */
        public function delete($id){
            // Prepare query
            $sql = "DELETE FROM products WHERE id = :id";
            // Prepare stmt
            $this->db->query($sql);
            // Bind param
            $this->db->bind(':id', $id);

            // Execute query, return tru/false
            return $this->db->execute();
        }

        /**
         * readAll function
         * return all products or a set if pagination
         * 
         * @param int $items - number products/page - default 20
         * $param int $page - page number
         * @return array of OBJs
         */
        public function readAll($page = null, $items = null){
            // Prepare query
            $sql = "SELECT * FROM products";
            // If $page is set, add pagination
            if($page && $page > 0) 
            {
                $sql .= " LIMIT :items OFFSET :offset";
                // Prepare query
                $this->db->query($sql);
                $items = $items ? intval($items) : 20;
                $offset = ($page - 1) * $items;
                $this->db->bind(':items', $items);
                $this->db->bind(':offset', $offset);
            }  
            else
            {   // Prepare query
                $this->db->query($sql);
            }  

            return $this->db->resultSet();
        }
    }
?>