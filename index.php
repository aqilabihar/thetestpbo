<?php

require_once 'controllers/Logincontroller.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $uri);

$controller = 'LoginController';
$method = 'index';

if (!empty($segments[1])) {
    $controller = ucfirst($segments[1]) . 'Controller';
}

if (!empty($segments[2])) {
    $method = $segments[2];
}

$controllerClass = $controller;

if (class_exists($controllerClass)) {
    $controllerObject = new $controllerClass();

    if (method_exists($controllerObject, $method)) {
        $controllerObject->$method();
    } else {
        echo 'Method not found';
    }
} else {
    echo 'Controller not found';
}
