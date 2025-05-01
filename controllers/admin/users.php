<?php
session_start();
$heading = 'User Accounts';
$config = require 'config.php';
$db = new Database($config['database']);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    validate('first_name', $errors);
    validate('last_name', $errors);
    validate('username', $errors);
    validate('email', $errors);
    validate('password', $errors);
    validate('role', $errors);
    if (empty($errors)) {
        $sweetalert = null;
        try {
            $validate = $db->query("SELECT username, email FROM user_accounts")->fetchAll();
            $isValid = true;
            foreach ($validate as $val) {
                if ($val['username'] == $_POST['username']) {
                    $isvalid = false;
                    throw new Exception('Error: The username already exists. Please choose a different username.');
                } else if ($val['email'] == $_POST['email']) {
                    $isvalid = false;
                    throw new Exception('Error: The email already exists. Please choose a different email.');
                }
            }
            if ($isValid) {
                if ($_POST['create'] ?? '' == true) {
                    $db->query("INSERT INTO user_accounts (first_name, last_name, username, email, password, role, register_type) VALUES (:first_name, :last_name, :username, :email, :password, :role, :register_type)", [
                        ':first_name' => trim($_POST['first_name']),
                        ':last_name' => trim($_POST['last_name']),
                        ':username' => trim($_POST['username']),
                        ':email' => rtrim($_POST['email']),
                        ':password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                        ':role' => $_POST['role'],
                        ':register_type' => 'created by admin',
                    ]);
                }
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    // if ($_POST['update'] ?? '' == true) {
    //     try {
    //         validate('username', $errors);
    //         validate('email', $errors);
    //         validate('role', $errors);

    //         if (!empty($errors)) {
    //             throw new Exception('Validation failed: Please check the entered information and try again.');
    //         }
    //     } catch (Exception $e) {
    //         $error = 'Error: ' . $e->getMessage();
    //     }
    //     if (empty($errors)) {
    //         try {
    //             $db->query("UPDATE user_accounts SET username = :username, email = :email, role = :role WHERE user_id = :user_id", [
    //                 ':username' => trim($_POST['username']),
    //                 ':email' => rtrim($_POST['email']),
    //                 ':role' => $_POST['role'],
    //                 ':user_id' => $_POST['user_id'],
    //             ]);
    //             $updated = true;
    //         } catch (PDOException $e) {
    //             if ($e->getCode() == 23000) {
    //                 $error = 'Error: The action could not be completed due to a data validation problem. Please ensure all related data is correct.';
    //             }
    //         }
    //     }
    // }

    if ($_POST['delete'] ?? '' == true) {
        try {
            $db->query("DELETE FROM user_accounts WHERE user_id = :user_id", [
                ':user_id' => $_POST['id'],
            ]);
            $delete = true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = 'Error: Action could not be completed. Please contact support for assistance.';
            }
        }
    }
}

$users = $db->query("SELECT * FROM user_accounts ORDER BY created_at DESC")->fetchAll();

require 'views/admin/users.view.php';
