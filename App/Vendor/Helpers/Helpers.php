<?php
    namespace Vendor\Helpers;

    use Firebase\JWT\JWT;
    use Firebase\JWT\DomainException;
    use Firebase\JWT\InvalidArgumentException;
    use Firebase\JWT\UnexpectedValueException;

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

        /**
         * generateToken function
         * generate JWT token
         * @param array $data
         *
         * @return string
         */
        public static function generateToken($data)
        {
            $time = time();
            $exp = $time + TOKEN_EXP;
            return JWT::encode($data, TOKEN_SECRET, 'HS256', null, [
                'iat' => $time,
                'exp' => $exp
            ]);
        }

        /**
         * validateToken function
         *
         * @param string $token
         * 
         * @throws DomainException
         * @throws InvalidArgumentException
         * @throws UnexpectedValueException
         * @return string
         */
        public static function validateToken($token)
        {
            try
            {
                return JWT::decode($token, TOKEN_SECRET);
            }
            catch(DomainException | InvalidArgumentException | UnexpectedValueException $e )
            {
                // Invalid token or expired send 401 back
                self::unauthorized();
            }
            
        }
    }
?>