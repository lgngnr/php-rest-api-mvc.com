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

        public function setUp() : void
        {
            $this->db = new Database; 
        }

        /**
         * testIstantiateDb function
         * @test
         */
        public function testIstantiateDb()
        {
            $this->assertInstanceOf(Database::class, $this->db);
        }

        /**
         * testQuery function, should return true
         * @test
         */
        public function testQuery()
        {
            // Test query
            $sql = "SELECT * FROM products";
            $this->assertTrue($this->db->query($sql));
        }

        /**
         * testBind function, it should return true if bind complete
         * @test
         */
        public function testBind()
        {
            // Test query
            $sql = "INSERT 
                    INTO products(name, category_id, description, price) 
                    VALUES(:name, :category_id, :description, :price)";
            $this->assertTrue($this->db->query($sql));
            $this->assertTrue($this->db->bind(':name', "test"));
            $this->assertTrue($this->db->bind(':name', 0));
            $this->assertTrue($this->db->bind(':name', "test"));
            $this->assertTrue($this->db->bind(':name', 1.0));
        }

        /**
         * testExecute function, it should return true if query executed
         * @test
         */
        public function testExecute()
        {
            // Test query
            $sql = "SELECT * FROM products";
            $this->assertTrue($this->db->query($sql));
            $this->assertTrue($this->db->execute());
        }

        /**
         * testResultSet function, it should return array of objs
         * @test
         */
        public function testResultSet()
        {
            // Test query
            $sql = "SELECT * FROM products";
            $this->assertTrue($this->db->query($sql));
            $records = $this->db->resultSet();
            $this->assertIsArray($records);
            foreach($records as $record){
                $this->assertIsObject($record);
            }
        }

        /**
         * testSingle function, it should return an obj
         * @test
         */
        public function testSingle()
        {
            // Test query
            $sql = "SELECT * FROM products";
            $this->assertTrue($this->db->query($sql));
            $records = $this->db->resultSet();
            $this->assertIsArray($records);
            foreach($records as $record){
                $this->assertIsObject($record);
            }
        }
    }
?>