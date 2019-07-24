<?php
    namespace Vendor\Models;

    use Firebase\JWT;
    use Vendor\Core\Database;

    /**
     * User class
     * Handle login and token issue
     */
    class User
    {

        private $db;

        public function __construct()
        {
            $this->db =  new Database;
        }

        /**
         * authenticate function
         * Check if there's a user and verify pass then generate auth token
         * @param string $email
         * @param string $password
         *
         * @return mixed, string or false
         */
        public function authenticate($email, $password)
        {
            // Set query
            $sql = "SELECT password from users WHERE email = :email";
            // Prepare STMT
            $this->db->query($sql);
            // Bind param
            $this->db->bind(':email', $email);
            // Execute
            $res = $this->db->single();
            // Check if there's a user and verify pass
            if($res)
            {
                if(password_verify($password, $res->password))
                {
                    // Generate auth token
                    return JWT::sign($email, '123456');
                }
                else
                {
                    // Invalid credential
                    return false;
                } 
            }
            else
            {
                // No user found
                return false;
            }

        }

        public function register($name, $email, $password){
             // Set query
             $sql = "INSERT INTO users(name, email, password) VALUES (:name, :email, :password)";
             // Prepare STMT
             $this->db->query($sql);
             // Bind param
             $this->db->bind(':name', $name);
             $this->db->bind(':email', $email);
             $this->db->bind(':password', $password);
             // Execute
             return $this->db->execute();
        }

    }
