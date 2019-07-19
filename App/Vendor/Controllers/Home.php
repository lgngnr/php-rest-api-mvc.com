<?php
    namespace Vendor\Controllers;
    use Vendor\Core as Core;

    /**
     * Home Controller class
     * Handle home page
     */
    class Home extends Core\Controller
    {
        /**
         * index function
         * It loads home/index view
         * @return void
         */
        public function index()
        {
            $this->view("home/index");
        }
    }
?>