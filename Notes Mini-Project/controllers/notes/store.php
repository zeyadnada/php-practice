<?php

use Core\Database;
use Core\Validator;

$config = require base_path('config.php');
$db = new Database($config['database']);

// Temporary user ID (replace later when adding real authentication)
$currentUserId = 1;

// Array to hold validation errors
$errors = [];

// Check that the note body is a string between 1 and 100 characters.
if (!Validator::string($_POST['body'], 1, 100)) {
    $errors['body'] = 'Note body must be between 1 and 100 characters';
}

// If validation failed, re-render the form with error messages
if (! empty($errors)) {
    return view("notes/create.view.php", [
        'heading' => 'Create Note',
        'errors' => $errors
    ]);
    exit; // stop executing this script
}

// INSERT NEW NOTE INTO DATABASE
if (empty($errors)) {

    // Insert the note into the database using a prepared statement
    $db->query(
        'INSERT INTO notes (body, user_id) VALUES (?, ?)',
        [$_POST['body'], $currentUserId]
    );

    // Redirect the user back to the notes list after creation
    header('Location: /notes');
    die(); // ensure no further code is executed
}
