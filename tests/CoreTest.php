<?php 
    use PHPUnit\Framework\TestCase;
    use Vendor\Core\Core;

    /**
     * Example Test Case writeen mainly to test namespacing
     */
    class CoreTest extends TestCase
    {
        /** 
         * It should create an istance of Vendor\Core\Core Class 
         * @test
         * */
        public function testContruct(){
            $core = new Core;
            $this->assertInstanceOf(Core::class, $core);
        }
    }
?>