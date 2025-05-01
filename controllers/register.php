<?php
require 'vendor/autoload.php';
session_start();
$heading = 'HOME';
$config = require 'config.php';
$db = new Database($config['database']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $users = $db->query('SELECT username,email FROM user_accounts')->fetchAll();
    $errors = [];
    $success = false;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    validate('email', $errors);
    validate('password', $errors);
    validate('username', $errors);
    validate('first_name', $errors);
    validate('last_name', $errors);
    foreach ($users as $user) {
        if ($user['username'] == $_POST['username']) {
            $errors['username'] = 'username already taken.';
            // dd($errors);
        } elseif ($user['email'] == $_POST['email']) {
            $errors['email'] = 'email already taken.';
            // dd($errors);
        }
    }
    // dd($_POST);
    if (empty($errors)) {
        if ($email && $password && $username) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->query("INSERT INTO user_accounts (first_name, last_name, username, email, password, role, register_type) VALUES (:first_name, :last_name, :username, :email, :password ,:role ,:register_type)", [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => 3,
                'register_type' => 'standard',
            ]);

            $_SESSION['user_id'] = $db->pdo->lastInsertId();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = 3;

            $success = true;
            header('Location: /');
        }
    }
}

require 'views/register.view.php';
