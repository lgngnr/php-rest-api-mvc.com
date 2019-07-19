<?php
    namespace Vendor\Helpers;

    /**
     * Helpers class
     * 
     * Implements utilities in static function
     */
    class Helpers
    {
        /**
         * redirect function
         *
         * redirect to another controller
         * 
         * @param [string] $path
         * @return void
         */
        public static function redirect($path)
        {
            header('location: ' . URL_ROOT . "/$path");
        }
    }
?>