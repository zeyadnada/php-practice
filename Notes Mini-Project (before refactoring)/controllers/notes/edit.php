<?php

use Core\Database;
use Core\Validator;

$heading = 'Edit Note';
$currentUserId = 1;

$config = require base_path('config.php');
$db = new Database($config['database']);

$note = $db->query(
    'SELECT * FROM notes where id = ?',
    [$_GET['id']]
)->findOrFail();

authorize($note['user_id'] === $currentUserId);

return view("notes/edit.view.php", [
    'heading' => $heading,
    'note' => $note,
    'errors' => []
]);