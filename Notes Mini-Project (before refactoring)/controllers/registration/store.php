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
if (!Validator::string($password, 8, 255)) {
    $errors['password'] = "Password must be at least 8 characters long";
}
if (!empty($errors)) {
    view('registration/create.view.php', [
        'errors' => $errors
    ]);
    exit;
}

//check if email already exists
$existingUser = $db->query("select * from users where email = ?", [$email])->find();

if ($existingUser) {
    // email already exists
    $errors['email'] = "Email already in use";
    view('registration/create.view.php', [
        'errors' => $errors
    ]);
    exit;
} else {
    // Insert new user into database
    $db->query("insert into users (email, password) values (?, ?)", [
        $email,
        password_hash($password, PASSWORD_BCRYPT)
    ]);

    //mark that User has logged in (session)
    $_SESSION['logged_in'] = true;
    $_SESSION['user'] = [
        'email' => $email
    ];

    // Redirect to login page after successful registration
    header('Location: /');
    exit;
}
