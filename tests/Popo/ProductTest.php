<?php
    use PHPUnit\Framework\TestCase;
    use Vendor\Popo\Product;

    /**
     * ProductTest class
     * Test POPO Product
     * Istantiate it, get and set properties
     */
    class ProductTest extends TestCase
    {
        // Init Value for product
        private const ID = 123;
        private const NAME = 'init title';
        private const CATEGORY_ID = 456;
        private const DESCRIPTION = 'init description';
        private const PRICE = 1.1;

        // Test Value for product
        private const ID_TEST = 987;
        private const NAME_TEST = 'test title';
        private const CATEGORY_ID_TEST = 654;
        private const DESCRIPTION_TEST = 'test description';
        private const PRICE_TEST = 9.9;

        private $product;

        /**
         * setUp function
         * Istantiate a new Product
         * @return void
         */
        public function setUp() : void
        {
            $this->product = new Product(
                self::ID, 
                self::NAME, 
                self::CATEGORY_ID, 
                self::DESCRIPTION, 
                self::PRICE);
        }

        /**
         * testConstruct function
         * It should return a Popo\Product istance
         *
         * @return void
         */
        public function testConstruct()
        {
            $this->assertInstanceOf(Product::class, $this->product);
        }

        /**
         * testGetId function
         * it should return the init value of id
         * @return void
         */
        public function testGetId()
        {
            $this->assertEquals($this->product->getId(), self::ID);
        }

        /**
         * testGetId function
         * it should set new id value 
         * @return void
         */
        public function testSetId()
        {
            // Set test id
            $this->product->setId(self::ID_TEST);
            $this->assertEquals($this->product->getId(), self::ID_TEST);
            // Restore init id
            $this->product->setId(self::ID);
        }

        /**
         * testGetName function
         * it should return the init value of Name
         * @return void
         */
        public function testGetName()
        {
            $this->assertEquals($this->product->getName(), self::NAME);
        }

        /**
         * testSetName function
         * it should set new Name value 
         * @return void
         */
        public function testSetName()
        {
            // Set test id
            $this->product->setName(self::NAME_TEST);
            $this->assertEquals($this->product->getName(), self::NAME_TEST);
            // Restore init id
            $this->product->setName(self::NAME);
        }

        /**
         * testGetCategory_id function
         * it should return the init value of Category_id
         * @return void
         */
        public function testGetCategory_id()
        {
            $this->assertEquals($this->product->getCategory_id(), self::CATEGORY_ID);
        }

        /**
         * testSetCategory_id function
         * it should set new Category_id value 
         * @return void
         */
        public function testSetCategory_id()
        {
            // Set test id
            $this->product->setCategory_id(self::CATEGORY_ID_TEST);
            $this->assertEquals($this->product->getCategory_id(), self::CATEGORY_ID_TEST);
            // Restore init id
            $this->product->setCategory_id(self::CATEGORY_ID);
        }

        /**
         * testGetDescription function
         * it should return the init value of Description
         * @return void
         */
        public function testGetDescription()
        {
            $this->assertEquals($this->product->getDescription(), self::DESCRIPTION);
        }

        /**
         * testSetDescription function
         * it should set new Description value 
         * @return void
         */
        public function testSetDescription()
        {
            // Set test id
            $this->product->setDescription(self::DESCRIPTION_TEST);
            $this->assertEquals($this->product->getDescription(), self::DESCRIPTION_TEST);
            // Restore init id
            $this->product->setDescription(self::DESCRIPTION);
        }

        /**
         * testGetPrice function
         * it should return the init value of Price
         * @return void
         */
        public function testGetPrice()
        {
            $this->assertEquals($this->product->getPrice(), self::PRICE);
        }

        /**
         * testSetPrice function
         * it should set new Price value 
         * @return void
         */
        public function testSetPrice()
        {
            // Set test id
            $this->product->setPrice(self::PRICE_TEST);
            $this->assertEquals($this->product->getPrice(), self::PRICE_TEST);
            // Restore init id
            $this->product->setPrice(self::PRICE);
        }

    }
?>