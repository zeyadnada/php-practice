<?php

require 'functions.php';

// require 'router.php';
require 'Database.php';

$config = require('config.php');
$db = new Database($config['database']);

$id = $_GET['id'] ?? null;

//prepare SQL with named placeholders
$query = 'SELECT * FROM posts WHERE id = ?';
//OR: $query = 'SELECT * FROM posts WHERE id = :id';

//execute SQL with an array of parameters
$posts = $db->query($query, [$id])->fetchAll();
//$posts = $db->query($query,['id'=>$id])->fetchAll();

dd($posts);