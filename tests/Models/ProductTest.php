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
        // UPDATE values
        private const UPDATE = '_updated';
        private const UPDATE_CATEGORY_ID = 111;
        private const UPDATE_PRICE = 11.11;

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

        /**
         * testUpdate function
         * It should update the previous inserted test product
         *
         * @param string $id
         * @depends testRead
         * @return string $id
         */
        public function testUpdate($id)
        {
            // Read the product
            $product = $this->productModel->read($id);
            $product->setName($product->getName() . self::UPDATE);
            $product->setCategory_id(self::UPDATE_CATEGORY_ID);
            $product->setDescription($product->getDescription() . self::UPDATE);
            $product->setPrice(self::UPDATE_PRICE);

            // Update product
            $res = $this->productModel->update($product);
            // Check for failure
            $this->assertNotFalse($res);

            // Read the product
            $productUpdated = $this->productModel->read($id);
            // Check fields updated
            $this->assertEquals($productUpdated->getName(), $product->getName());
            $this->assertEquals($productUpdated->getCategory_id(), $product->getCategory_id());
            $this->assertEquals($productUpdated->getDescription(), $product->getDescription());
            $this->assertEquals($productUpdated->getPrice(), $product->getPrice());
            return $id;
        }

        /**
         * testDelete function
         * It should delete the previous updated post
         * 
         * @param string $id
         * @depends testUpdate
         * @return void
         */
        public function testDelete($id)
        {
            // Delete the product
            $res = $this->productModel->delete($id);

            // Check for failure
            $this->assertNotFalse($res);

            // Check if not exist in db
            $product = $this->productModel->read($id);
            // Check if is null
            $this->assertFalse($product);
        }

        /**
         * testReadAll function
         * It should return all products
         * 
         * @return void
         */
        public function testReadAllNoPagination(){
            // Insert dummy products
            $product1 = new Popo\Product(
                self::ID_TEST,
                self::NAME_TEST,
                self::CATEGORY_ID_TEST,
                self::DESCRIPTION_TEST,
                self::PRICE_TEST
            );
            $product2 = new Popo\Product(
                self::ID_TEST,
                self::NAME_TEST,
                self::CATEGORY_ID_TEST,
                self::DESCRIPTION_TEST,
                self::PRICE_TEST
            );

            // Add products1
            $product1 = $this->productModel->create($product1);
            // Check for failure
            $this->assertNotFalse($product1);
            // Add products2
            $product2 = $this->productModel->create($product2);
            // Check for failure
            $this->assertNotFalse($product2);

            // Read all
            $records = $this->productModel->readAll();
            // Check if return an array
            $this->assertIsArray($records);
            // Check if array items are two
            $this->assertGreaterThanOrEqual(2, count($records));

            // Delete inserted test products
            $this->productModel->delete($product1->getId());
            $this->productModel->delete($product2->getId());
        }

        /**
         * testReadAllWithPagination function
         * It should return products limit by LMITI per page
         * Products table must be empty
         * @return void
         */
        public function testReadAllWithPagination(){
            // Insert dummy products
            $product1 = new Popo\Product(
                self::ID_TEST,
                self::NAME_TEST,
                self::CATEGORY_ID_TEST,
                self::DESCRIPTION_TEST,
                self::PRICE_TEST
            );
            $product2 = new Popo\Product(
                self::ID_TEST,
                self::NAME_TEST,
                self::CATEGORY_ID_TEST,
                self::DESCRIPTION_TEST,
                self::PRICE_TEST
            );

            // Add products1
            $product1 = $this->productModel->create($product1);
            // Check for failure
            $this->assertNotFalse($product1);
            // Add products2
            $product2 = $this->productModel->create($product2);
            // Check for failure
            $this->assertNotFalse($product2);

            // Read 1 record/page page 1
            $records = $this->productModel->readAll(1,1);
            // Check if return an array
            $this->assertIsArray($records);
            // Check if array contain 1 item
            $this->assertEquals(1, count($records));
            // $records[0] should be $product1
            $this->assertEquals($product1->getId(), $records[0]->id);

            // Read 1 record/page page 2
            $records = $this->productModel->readAll(1,2);
            // Check if return an array
            $this->assertIsArray($records);
            // Check if array contain 1 item
            $this->assertEquals(1, count($records));
            // $records[0] should be $product2
            $this->assertEquals($product2->getId(), $records[0]->id);

            // Delete inserted test products
            $this->productModel->delete($product1->getId());
            $this->productModel->delete($product2->getId());
        }
    }
?>