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
            $sql = "SELECT * FROM products WHERE id = :id";
            $this->assertTrue($this->db->query($sql));
            $this->assertTrue($this->db->bind(':id', 1));
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
            $sql = "SELECT * FROM products WHERE id = :id";
            // Preprare stmt
            $this->db->query($sql);
            // Bind params
            $this->db->bind(':id', 2);
            // Execute & fetch single row
            $record = $this->db->single();
            $this->assertIsObject($record);
        }

        /**
         * testRowCount function, it should return an integer
         * @test
         */
        public function testRowCount()
        {
            // Test query
            $sql = "SELECT * FROM products";
            $this->assertTrue($this->db->query($sql));
            $records = $this->db->single();
            $this->assertIsInt($this->db->rowCount());
        }

        public function testLastInsertId(){
            $sql = "INSERT INTO products(name, category_id, description, price) 
                    VALUES(:name, :category_id, :description, :price)";
            $this->db->query($sql);
            $this->db->bind(':name', "test");
            $this->db->bind(':category_id', 0);
            $this->db->bind(':description', "test");
            $this->db->bind(':price', 1.0);
            // Checking execution
            if($this->db->execute())
            {   // Success
                $lastInsertId = $this->db->lastInsertId();
                $this->assertIsString($lastInsertId);
            }
            else
            {   // Fail
                print("query execution fail");
            }
            
        }
    }
?>