<?php
require 'vendor/autoload.php';
session_start();

$config = require 'config.php';
$db = new Database($config['database']);
$usm = new Database($config['usm']);

$client = new Google\Client();
$client->setClientId($config['google']['client_id']);
$client->setClientSecret($config['google']['client_secret']);
$client->setRedirectUri($config['google']['redirect_uri']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['login'] ?? '' == true) {

        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $errors = [];

        validate('email', $errors);
        validate('password', $errors);

        if (!empty($errors)) {
            header('location: /');
            exit();
        }

        try {
            $user = $usm->query('SELECT * FROM user_account WHERE email = :email', [
                ':email' => $email,
            ])->fetch();

            if (!$user) {
                $errors['email'] = 'Email or password is incorrect';
            } elseif (!password_verify($password, $user['password'])) {
                $errors['password'] = 'Password is incorrect';
            }

            if (empty($errors) && $user) {
                if ($user['role'] === 'admin') {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    header("Location: /admin/");
                    exit();
                } elseif ($user['role'] === 'manager') {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    header('Location: /manager/');
                    exit();
                } elseif ($user['role'] === 'recruiter') {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    header("Location: /hr/");
                    exit();
                } elseif ($user['role'] === 'hiring manager') {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    header('Location: /hr_hiring/');
                    exit();
                } elseif ($user['role'] === 'applicant') {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
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
