<?php

use Core\Response;

function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function isCurrentPage($url)
{
    return $_SERVER['REQUEST_URI'] === $url;
}

//Render an error page and stop execution
function abort($code = 404)
{
    http_response_code($code);
    require base_path("views/{$code}.php");
    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (!$condition) {
        abort($status);
    }
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);  // import variables from an associative array, the keys become variable names and the values become variable values
    require base_path("views/{$path}");
}

function login($user)
{
    //mark that User has logged in (session)
    $_SESSION['user'] = [
        'email' => $user['email']
    ];
}

function logout()
{
    // make global session empty
    $_SESSION = [];

    //destroying session file on server
    session_destroy();

    //delete session cookie on browser (by setting its expiration time to past time so browser removes it immediately) 
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}