<?php

namespace Vendor\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\DomainException;
use Firebase\JWT\InvalidArgumentException;
use Firebase\JWT\UnexpectedValueException;
use LogicException;
use PHPUnit\TextUI\Exception;

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
    public static function unauthorized($msg = null)
    {
        http_response_code(401);
        if ($msg) {
            echo json_encode(['message' => $msg]);
        }
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
        foreach ($methods as $method) {
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
    public static function setAuthorizationToken($token)
    {
        header("Authorization: Bearer $token");
    }


    public static function getTokenFromHeaderAuth()
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            return str_replace("Bearer ", "", trim($_SERVER['HTTP_AUTHORIZATION']));
        } else {
            return false;
        }
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
        try {
            $payload =  JWT::decode($token, TOKEN_SECRET, ['HS256']);
            return $payload;
        } catch (\Exception | \UnexpectedValueException $e) {
            // Invalid token or expired send 401 back
            self::unauthorized();
            return false;
        }
    }

    /**
     * authorize function
     * Retrieve auth token, validate it
     * @return boolean
     */
    public static function authorize()
    {
        // GET token from header Authorization
        $token = self::getTokenFromHeaderAuth();

        // Validate it, will throw managed exception and 401 back
        if ($token && self::validateToken(($token))) {
            return true;
        }
        else 
        {
            return false;
        }
    }
}
