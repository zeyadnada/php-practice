<?php

use Core\Database;
use Core\Validator;

$heading = 'My Notes';

// Temporary logged-in user ID (replace with real authentication later)
$currentUserId = 1;

$config = require base_path('config.php');
$db = new Database($config['database']);

// FETCH THE NOTE THE USER WANTS TO DELETE
$note = $db->query(
    'SELECT * FROM notes WHERE id = ?',
    [$_POST['id']]
)->findOrFail();


// Make sure the logged-in user owns the note.
// authorize() will abort if the condition is false.
authorize($note['user_id'] === $currentUserId);


// DELETE THE NOTE
$db->query('DELETE FROM notes WHERE id = ?', [$_POST['id']]);

// After deleting → redirect back to notes list
header('Location: /notes');
die();
