<?php
    namespace Vendor\Core;

    /**
     * Controller class implements IController interface
     * Implements methods model() and view()
     */
    class Controller implements IController
    {
        /**
         * model function
         * 
         * Istantiate the model and return it
         *
         * @param [Vendor\Models] $model
         * @return Vendor\Models, null if not exist
         */
        public function model($model)
        {
            $class = "Vendor\Models\\" . $model;
            if(class_exists($class))
            {
                return new $class;
            }else{
                return null;
            }
        }

        /**
         * view function
         * It loads the view
         *
         * @param [string] $view
         * @param array $data
         * @return void
         */
        public function view($view, $data=[])
        {
            if(file_exists(APP_ROOT . "/Vendor/Views/$view.php"))
            {
                require_once APP_ROOT . "/Vendor/Views/$view.php";
            } 
            else
            {
                die("view $view not found");
            }
        }
    }
?>