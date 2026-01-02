<?php

namespace Core;

use Core\Database;
use Core\Session;

class Authenticator
{
    public function attempt($email, $password)
    {
        $config = require base_path('config.php');
        $db = new Database($config['database']);

        //check if email already exists
        $existingUser = $db->query("select * from users where email = ?", [$email])->find();

        if ($existingUser) {
            // email already exists so verify password 
            if (password_verify($password, $existingUser['password'])) {
                $this->login([
                    'email' => $existingUser['email']
                ]);
                return true;
            }
        }

        return false;
    }

    function login($user)
    {
        //mark that User has logged in (session)
        $_SESSION['user'] = [
            'email' => $user['email']
        ];
    }

    function logout()
    {
        // make global session empty & destroying session file on server & delete session cookie on browser (by setting its expiration time to past time so browser removes it immediately) 
        Session::destroy();
    }
}
