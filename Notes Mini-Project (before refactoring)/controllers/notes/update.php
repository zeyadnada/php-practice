<?php

use Core\Database;
use Core\Validator;

$heading = 'My Notes';

// Temporary logged-in user ID (replace with real authentication later)
$currentUserId = 1;

$config = require base_path('config.php');
$db = new Database($config['database']);

// FETCH THE NOTE THE USER WANTS TO UPDATE
$note = $db->query(
    'SELECT * FROM notes WHERE id = ?',
    [$_POST['id']]
)->findOrFail();


// Make sure the logged-in user owns the note.
// authorize() will abort if the condition is false.
authorize($note['user_id'] === $currentUserId);


$errors = [];

// Check that the note body is a string between 1 and 100 characters.
if (!Validator::string($_POST['body'], 1, 100)) {
    $errors['body'] = 'Note body must be between 1 and 100 characters';
}

// If validation failed, re-render the form with error messages
if (! empty($errors)) {
    return view("notes/edit.view.php", [
        'heading' => 'Edit Note',
        'note' => $note,
        'errors' => $errors
    ]);
    exit; // stop executing this script
}

// Update  specific NOTE
$db->query(
    'UPDATE notes SET body = ? where id = ? ',
    [$_POST['body'], $_POST['id']]
);

// Redirect the user back to the notes list after updating
header('Location: /notes');
die(); // ensure no further code is executed