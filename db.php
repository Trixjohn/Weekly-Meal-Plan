<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'mealplan';
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die('connection failed
    '. $conn->connect_error);

}
?>