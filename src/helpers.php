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
