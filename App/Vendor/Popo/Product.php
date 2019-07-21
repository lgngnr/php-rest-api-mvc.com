<?php
    namespace Vendor\Popo;

    class Product {
        private $id;
        private $name;
        private $category_id;
        private $description;
        private $price;

        public function __construct(
            $id = null, 
            $name = null, 
            $category_id = null, 
            $description =  null, 
            $price = null)
        {
            $this->id =$id;
            $this->name =$name;
            $this->category_id =$category_id;
            $this->description =$description;
            $this->price =$price;
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
    }

?>
