<?php 
    namespace Vendor\Core;

    /**
     * Controller interface
     * Define methods for base Controller
     * METHOD model() load the model
     * METHOD view() load the view
     */
    interface IController
    {

        public function model($model);
        public function view($view);

    }
?>