<?php

use Core\Authenticator;
//log out user by
$user =new Authenticator;
$user->logout();

//redirect to home page
header('Location: /');
exit;