<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm
{

    protected $errors = [];

    public function validate($email, $password)
    {
        if (!Validator::email($email)) {
            $this->errors['email'] = "Email is not valid";
        }
        if (!Validator::string($password)) {
            $this->errors['password'] = "Password provide a valid password";
        }
        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($field, $message)
    {
        $this->errors[$field] = $message;
    }
}
