<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hr_1&2_learning_management_and_training_management1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>