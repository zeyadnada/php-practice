<?php

$heading = 'Create Note';
require 'Validator.php';
$config = require('config.php');
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentUserId = 1; // This should be replaced with actual user authentication logic

    $errors = [];

    if (!Validator::string($_POST['body'], 1, 100)) {
        $errors['body'] = 'Note body must be between 1 and 100 characters';
    }

    if (empty($errors)) {

        $db->query(
            'INSERT INTO notes (body, user_id) VALUES (?,?)',
            [$_POST['body'], $currentUserId]
        );
    }
}

require 'views/notes/create.view.php';