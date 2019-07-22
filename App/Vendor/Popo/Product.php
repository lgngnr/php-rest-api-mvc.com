<?php
    namespace Vendor\Popo;

use stdClass;

class Product {
        private $id;
        private $name;
        private $category_id;
        private $description;
        private $price;

        public function __construct(
            $id = 0, 
            $name = '', 
            $category_id = 0, 
            $description =  '', 
            $price = 0.0)
        {
            $this->id = $id;
            $this->name = $name;
            $this->category_id = $category_id;
            $this->description = $description;
            $this->price = $price;
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

            /**
             * Get the value of name
             */ 
            public function getName()
            {
                        return $this->name;
            }

            /**
             * Set the value of name
             *
             * @return  self
             */ 
            public function setName($name)
            {
                        $this->name = $name;

                        return $this;
            }

            /**
             * Get the value of category_id
             */ 
            public function getCategory_id()
            {
                        return $this->category_id;
            }

            /**
             * Set the value of category_id
             *
             * @return  self
             */ 
            public function setCategory_id($category_id)
            {
                        $this->category_id = $category_id;

                        return $this;
            }

        /**
         * Get the value of description
         */ 
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @return  self
         */ 
        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }

        /**
         * Get the value of price
         */ 
        public function getPrice()
        {
                return $this->price;
        }

        /**
         * Set the value of price
         *
         * @return  self
         */ 
        public function setPrice($price)
        {
                $this->price = $price;

                return $this;
        }

        public function __toString(){
                return "id=>" . $this->getId()
                        . "\n name=> " . $this->getName()
                        . "\n category_id=> " . $this->getCategory_id()
                        . "\n description=> " . $this->getDescription()
                        . "\n price=> " . $this->getPrice();
        }

        /**
         * __getObj function
         * Fill an sdtClass with product property
         *
         * @return obj
         */
        public function __getObj()
        {
                $obj = new stdClass;
                $obj->id = $this->getId(); 
                $obj->name = $this->getName(); 
                $obj->category_id = $this->getCategory_id(); 
                $obj->description = $this->getDescription(); 
                $obj->price = $this->getPrice(); 
                return $obj;
        }
    }

?>
