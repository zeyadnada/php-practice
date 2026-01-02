<?php

use Http\Forms\LoginForm;
use Core\Authenticator;
use Core\Session;

// Get the email and password from the submitted POST request
$email = $_POST['email'];
$password = $_POST['password'];

// Create an instance of the LoginForm class to handle validation
$form = new LoginForm();

// Validate the form input (email and password)
if ($form->validate($email, $password)) {
    // If the form inputs are valid, attempt to authenticate the user
    $auth = new Authenticator();

    // Try to authenticate with the provided email and password
    if ($auth->attempt($email, $password)) {
        // If authentication is successful, redirect the user to the home page
        redirect('/');
    }

    // If authentication fails, set an error for the email field
    $form->error('email', 'Invalid email or password');
}

// If validation fails or authentication fails, redirect to  the login form with errors

Session::flash('errors', $form->errors());
Session::flash('old', [
    'email' => $email
]);
redirect('/login');
