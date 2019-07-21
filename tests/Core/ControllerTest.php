<?php
    use PHPUnit\Framework\TestCase;
    use Vendor\Core\Controller;
    use Vendor\Models\Product;

    // Load config
    require_once dirname(dirname(__DIR__)) . "/App/Vendor/Config/config.php";
    
    /**
     * ControllerTest class
     * Unit Test: model(), view()
     */
    class ControllerTest extends TestCase
    {
        private const INDEX_FILE = APP_ROOT . "/Vendor/Views/home/index.php";
        private $controller;

        /**
         * setUp function
         * Create an istance of Controller
         * @return void
         */
        public function setUp() : void
        {
            $this->controller = new Controller;
        }

        /**
         * testModel function
         * It should load the model requested in param if exist
         * It shouldn't load the model if not exist
         * 
         */
        public function testModel()
        {
            $model = $this->controller->model('Product');
            // Should get a model istance
            $this->assertNotNull($model);
            // Should be a Models\Product istance
            $this->assertInstanceOf(Product::class, $model);

            $model = $this->controller->model('XXX');
            // Should get a null
            $this->assertNull($model);
        }

        /**
         * testView function
         * It should load the view required in param
         * @test
         */
        public function testView()
        {
            // It should load home/index view
            $view = $this->controller->view('home/index');
            
            // Loading Views/home/index.php
            $indexFile = $this->loadView(self::INDEX_FILE);

            // $view shlould contain index.php content
            $this->assertEquals($indexFile, $view);
        }

        private function loadView($file){
            require_once $file;
        }
    }
?>