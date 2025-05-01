<?php
session_start();
require 'vendor/autoload.php';

$config = require 'config.php';

$client = new Google\Client();
$client->setClientId($config['google']['client_id']);
$client->setClientSecret($config['google']['client_secret']);
$client->setRedirectUri($config['google']['redirect_uri']);

if (isset($_GET['code'])) {
    $db = new Database($config['database']);
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $oauth = new Google\Service\Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    $user = $db->query('SELECT * FROM user_accounts WHERE email = :email', [
        ':email' => $userInfo->email,
    ])->fetch();

    if (!$user) {
        $db->query("INSERT INTO user_accounts (username, email, role, register_type) VALUES (:username, :email, :role, :register_type)", [
            ":username" => $userInfo->name,
            ":email" => $userInfo->email,
            ":role" => 6,
            ":register_type" => 'google',
        ]);
    }

    $user_role = $db->query('SELECT * FROM user_accounts WHERE email = :email', [
        ':email' => $userInfo->email,
    ])->fetch();

    if ($user_role['role'] === 2) {
        $_SESSION['user_id'] = $user_role['user_id'];
        $_SESSION['username'] = $user_role['username'];
        $_SESSION['role'] = 'ADMIN';
        header("Location: /admin/");
        exit();
    } elseif ($user_role['role'] === 3) {
        $_SESSION['user_id'] = $user_role['user_id'];
        $_SESSION['username'] = $user_role['username'];
        $_SESSION['role'] = 'Manager';
        header("Location: /manager/");
        exit();
    } elseif ($user_role['role'] === 4) {
        $_SESSION['user_id'] = $user_role['user_id'];
        $_SESSION['username'] = $user_role['username'];
        $_SESSION['role'] = 'HR';
        header("Location: /hr/");
        exit();
    } elseif ($user_role['role'] === 5) {
        $_SESSION['user_id'] = $user_role['user_id'];
        $_SESSION['username'] = $user_role['username'];
        $_SESSION['role'] = 'HIRING MANAGER';
        header('Location: /hr_hiring/');
        exit();
    } elseif ($user_role['role'] === 6) {
        $_SESSION['user_id'] = $user_role['user_id'];
        $_SESSION['username'] = $user_role['username'];
        $_SESSION['role'] = 'USER';
        header('Location: /home');
        exit();
    }
} else {
    echo "Error: Authorization code not received.";
}
