<?php
    use PHPUnit\Framework\TestCase;
    use Vendor\Popo;
    use Vendor\Models;

    // Load config
    require_once dirname(dirname(__DIR__)) . "/App/Vendor/Config/config.php";

    /**
     * ProductTest class
     * Test cases CRUD ops for Models\Product
     */
    class ProductTest extends TestCase
    {
        // Test values
        private const ID_TEST = 0;
        private const NAME_TEST = 'test title';
        private const CATEGORY_ID_TEST = 654;
        private const DESCRIPTION_TEST = 'test description';
        private const PRICE_TEST = 9.9;

        private $productModel;

        /**
         * setUp function
         * Istantiate new Models\Product
         *
         * @return void
         */
        public function setUp() : void
        {
            $this->productModel = new Models\Product;
        }

        /**
         * testCreate function
         * It should add new product, return id for testRead
         *
         * @return string
         */
        public function testCreate()
        {
            // Istantiate new Popo\Product
            $product = new Popo\Product(
                self::ID_TEST,
                self::NAME_TEST,
                self::CATEGORY_ID_TEST,
                self::DESCRIPTION_TEST,
                self::PRICE_TEST
            );
            $res = $this->productModel->create($product);
            // Check for failure, it return false
            $this->assertNotFalse($res);
            // Check correct set of id, lastInsertId return a string
            $this->assertIsString($res->getId());
            return $res->getId();
        }

        /**
         * testRead function
         * It should return the product inserted in testCreate
         * 
         * @param string $id
         * 
         * @depends testCreate
         * @return string $id
         */
        public function testRead($id){

            // Read the product
            $product = $this->productModel->read($id);
            // Check for failure
            $this->assertNotFalse($product);
            // Check integrity
            $this->assertEquals($product->getId(), $id);
            $this->assertEquals($product->getName(), self::NAME_TEST);
            $this->assertEquals($product->getCategory_id(), self::CATEGORY_ID_TEST);
            $this->assertEquals($product->getDescription(), self::DESCRIPTION_TEST);
            $this->assertEquals($product->getPrice(), self::PRICE_TEST);
            return $id;
        }

    }
?>