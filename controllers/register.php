<?php
require 'vendor/autoload.php';
session_start();
$heading = 'HOME';
$config = require 'config.php';
$db = new Database($config['database']);
$usm = new Database($config['usm']);

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
    if ($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format.';
        } elseif (strlen($email) > 255) {
            $errors['email'] = 'Email is too long.';
        }
    }
    validate('password', $errors);
    validate('username', $errors);
    validate('first_name', $errors);
    validate('last_name', $errors);
    foreach ($users as $user) {
        if ($user['username'] == $_POST['username']) {
            $errors['username'] = 'username already taken.';
        } elseif ($user['email'] == $_POST['email']) {
            $errors['email'] = 'email already taken.';
        }
    }
    if (empty($errors)) {
        if ($email && $password && $username) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // $db->query("INSERT INTO user_accounts (first_name, last_name, username, email, password, role, register_type) VALUES (:first_name, :last_name, :username, :email, :password ,:role ,:register_type)", [
            //     'first_name' => $first_name,
            //     'last_name' => $last_name,
            //     'username' => $username,
            //     'email' => $email,
            //     'password' => $hashedPassword,
            //     'role' => 6,
            //     'register_type' => 'standard',
            // ]);

            $usm->query("INSERT INTO user_account (department_id, first_name, last_name, username, email, password, role, register_type) VALUES (:department_id, :first_name, :last_name, :username, :email, :password ,:role ,:register_type)", [
                'department_id' => 1,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => 'applicant',
                'register_type' => 'standard',
            ]);

            $success = true;
            header('Location: /');
        }
    }
}

require 'views/register.view.php';
