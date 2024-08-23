<?php

if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
} else {
    require_once '../vendor/autoload.php';
}

if (file_exists('models/User.php')) {
    require_once 'models/User.php';
} else {
    require_once '../models/User.php';
}

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoginController
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Create a new User object
            $user = new User();

            // Check if the user is authenticated
            if ($user->authenticate($username, $password)) {
                // Create a logger
                $logger = new Logger('login_logger');
                $logger->pushHandler(new StreamHandler('storage/logs/login.log', Logger::INFO));

                // Log the login attempt
                $logger->info('Login attempt', ['username' => $username]);

                // Redirect to the home page
                header('Location: views/home.php');
                exit;
            } else {
                // Display an error message
                echo 'Invalid username or password';
            }
        } else {
            // Display the login form
            require_once 'views/login.php';
        }
    }
}

$controller = new LoginController();
$controller->index();
