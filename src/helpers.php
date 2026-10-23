<?php

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function view($name, $data = [])
{
    extract($data);

    ob_start();
    require BASE_PATH . '/views/' . $name . '.php';
    $content = ob_get_clean();

    require BASE_PATH . '/views/layout.php';
}

function redirect($path)
{
    header('Location: ' . $path);
    exit;
}
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function verify_csrf()
{
    if(!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        http_response_code(419);
        exit('Page expired. Go back and try again.');
    }
}