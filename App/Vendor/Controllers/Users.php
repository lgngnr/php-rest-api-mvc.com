<?php

namespace Vendor\Controllers;

use Vendor\Core as Core;
use Vendor\Helpers\Helpers;

/**
 * User Controller class
 * Handle login and token issue
 */
class Users extends Core\Controller
{
    private $userModel;

    /**
     * __construct function
     * Istantiate User Model
     */
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    /**
     * login function
     * Retrive json login credentials, verify it and issue a token
     * @return void
     */
    public function login()
    {

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            // send 405 method Not Allowed
            return Helpers::methodNotAllowed('POST');
        }

        // Get raw data
        $data = json_decode(file_get_contents("php://input"));

        //Sanitize data
        $data->email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
        // Later set Password rule
        $data->password = $data->password;

        // Authenticate
        $res = $this->userModel->authenticate($data->email, $data->password);

        // Check for success
        if ($res) {
            // Send back auth header
            Helpers::authorized($res);
        } else {
            // Invalid credential send 401 Unauthorized back
            Helpers::unauthorized();
        }
    }

    /**
     * register function
     * register a new user
     * @return void
     */
    public function register(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            // send 405 method Not Allowed
            return Helpers::methodNotAllowed('POST');
        }

        // Get raw data
        $data = json_decode(file_get_contents("php://input"));

        //Sanitize data
        $data->name = filter_var($data->name, FILTER_SANITIZE_STRING);
        $data->email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
        // Later set Password rule
        $data->password = $data->password;

        // Register
        $res = $this->userModel->register($data->name, $data->email, $data->password);

        // Check for success
        if ($res) {
            $this->view(
                "users/index",
                array(
                    'message' => "New user created"
                )
            );
        } else {
            $this->view(
                "users/index",
                array(
                    'message' => "Wrong data"
                )
            );
        }
    }
}
