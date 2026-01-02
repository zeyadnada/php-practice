<?php

use Core\Database;
use Core\Validator;

$config = require base_path('config.php');
$db = new Database($config['database']);

$email = $_POST['email'];
$password = $_POST['password'];

// Validate The Form InputS
$errors = [];
if (!Validator::email($email)) {
    $errors['email'] = "Email is not valid";
}
if (!Validator::string($password)) {
    $errors['password'] = "Password provide a valid password";
}
if (!empty($errors)) {
    view('session/create.view.php', [
        'errors' => $errors
    ]);
    exit;
}

//check if email already exists
$existingUser = $db->query("select * from users where email = ?", [$email])->find();

if ($existingUser) {
    // email already exists so verify password 
    if (password_verify($password, $existingUser['password'])) {
        login([
            'email' => $existingUser['email']
        ]);
        header('Location: /');
        exit;
    }
}

view('session/create.view.php', [
    'errors' => ['email' => 'Invalid email or password']
]);