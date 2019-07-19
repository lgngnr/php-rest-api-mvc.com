<?php

    namespace Vendor\Core;
    use Vendor\Controllers as Controllers;

    /**
     * Class Core
     * Create urls and load core controller
     * URL format: /controller/method/params
     */

    class Core
    {

        const DEFAULT_CONTROLLER = "Home";
        const DEFAULT_METHOD = "index";

        protected $current_controller = self::DEFAULT_CONTROLLER;
        protected $current_method = self::DEFAULT_METHOD;
        protected $params = [];

        public function __construct()
        {
            echo "Core construct";

            // GET parsed url
            $url = $this->getUrl();

            // Check if the controller exist
            if(file_exists("../Controllers/" . ucwords($url[0]) . '.php'))
            {
                // Update current controller
                $this->current_controller = ucwords($url[0]);
            }

            // Unset first index
            unset($url[0]);

            // Controller name include namespace
            $controller = "Controllers\\" . $this->current_controller;
            // Load the controller
            $this->current_controller = new $controller;

            // Check for method
            if(isset($url[1]))
            {
                // Check if method exists
                if(method_exists($this->current_controller, $url[1]))
                {
                    $this->current_method = $url[1];
                }
            }

            // Remove url[1]
            unset($url[1]);

            // Get params
            $this->params = $url ? array_values($url) : [];

            // Call current_method on current_controller
            call_user_func_array([
                $this->current_controller,
                $this->current_method
            ], $this->params);
        }

        /** 
         * Take the url from SUPERGLOBAL $_GET
         * Trim (final /) -> Sanitize -> Explode 
         * @return array
         */
        private function getUrl()
        {
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
            
        }
    }
?>