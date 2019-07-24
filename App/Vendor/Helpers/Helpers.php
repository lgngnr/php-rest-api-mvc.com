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
            header('location: /' . $path);
        }

        /**
         * unauthorized function
         * send 401 Unauthorized back
         * @return void
         */
        public static function unauthorized(){
            http_response_code(401);
        }

        /**
         * methodNotAllowed function
         * 405 Method Not Allowed back
         * @param array ...$methods method allowed GET,POST,...
         * @return void
         */
        public static function methodNotAllowed(...$methods)
        {
            http_response_code(405);
            $allowed = '';
            foreach($methods as $method){
                $allowed .= "$method,";
            }
            // Strip last ,
            $allowed = rtrim($allowed, ',');
            header('Access-Control-Allow-Method: ' . $allowed);
        }

        /**
         * authorized function
         * 405 Method Not Allowed back
         * @param array ...$methods method allowed GET,POST,...
         * @return void
         */
        public static function authorized($token){
            header("Authorization: Bearer $token");
        }
    }
?>