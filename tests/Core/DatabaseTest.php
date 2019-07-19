<?php
    use PHPUnit\Framework\TestCase;
    use Vendor\Core\Database;

    // Load config
    require_once dirname(dirname(__DIR__)) . "/App/Vendor/Config/config.php";

    /**
     * DatabaseTest class
     * Test case:
     * 
     */
    class DatabaseTest extends TestCase
    {
        private $db;

        /**
         * testIstantiateDb function
         * @test
         */
        public function testIstantiateDb()
        {
            $this->db = new Database;
            $this->assertInstanceOf(Database::class, $this->db);
        }

        /**
         * testQuery function, should return true
         * @depends testIstantiateDb
         * @test
         */
        public function testQuery()
        {
            $this->db = new Database;
            // Test query
            $sql = "SELECT * FROM products";
            $this->assertTrue($this->db->query($sql));

        }

        
    }
?>