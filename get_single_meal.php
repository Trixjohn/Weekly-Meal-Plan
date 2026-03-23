<?php
include 'db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM weekly_meals WHERE id = $id";
$result = $conn->query($sql);

$meal = $result->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($meal);

$conn->close();
?>