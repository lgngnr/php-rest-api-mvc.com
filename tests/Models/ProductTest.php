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
         * It should add new product
         *
         * @return void
         */
        public function testCreate()
        {
            // Istantiate new Popo\Product
            $product = new Popo\Product(
                0,
                'TITLE test product model',
                0,
                'BODY test product model',
                1.1
            );
            $res = $this->productModel->create($product);
            // Check for failure, it return false
            $this->assertNotFalse($res);
            // Check correct set of id, lastInsertId return a string
            $this->assertIsString($res->getId());
        }

    }
?>