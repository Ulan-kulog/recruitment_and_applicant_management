<?php
require 'vendor/autoload.php';
session_start();

$config = require 'config.php';
$db = new Database($config['database']);

$client = new Google\Client();
$client->setClientId($config['google']['client_id']);
$client->setClientSecret($config['google']['client_secret']);
$client->setRedirectUri($config['google']['redirect_uri']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['login'] ?? '' == true) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $errors = [];

        validate('email', $errors);
        validate('password', $errors);

        if (!empty($errors)) {
            header('location: /');
            exit();
        }
        try {
            $user = $db->query('SELECT * FROM user_accounts WHERE email = :email', [
                ':email' => $email,
            ])->fetch();

            if ($user === false) {
                $errors['email'] = 'Email not found';
            } elseif (!password_verify($password, $user['password'])) {
                $errors['password'] = 'Password is incorrect';
            }
            if (empty($errors) && $user) {
                if ($user['role'] === 2) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = 'ADMIN';
                    header("Location: /admin/");
                    exit();
                } elseif ($user['role'] === 3) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = 'Manager';
                    header('Location: /manager/');
                    exit();
                } elseif ($user['role'] === 4) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = 'HR';
                    header("Location: /hr/");
                    exit();
                } elseif ($user['role'] === 5) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = 'Hiring Manager';
                    header('Location: /hr_hiring/');
                    exit();
                } elseif ($user['role'] === 6) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = 'User';
                    header('Location: /home');
                    exit();
                }
            }
        } catch (Exception $e) {
            error_log('Database Error: ' . $e->getMessage());
            $errors['database'] = 'An unexpected error occurred. Please try again later.';
        }
    }
    if ($_POST['google'] ?? '' == true) {
        $client = new Google\Client();
        $client->setClientId($config['google']['client_id']);
        $client->setClientSecret($config['google']['client_secret']);
        $client->setRedirectUri($config['google']['redirect_uri']);
        $client->addScope("email");
        $client->addScope("profile");
        $authUrl = $client->createAuthUrl();
        header('Location: ' . $authUrl);
        exit();
    }
}

require 'views/index.view.php';
