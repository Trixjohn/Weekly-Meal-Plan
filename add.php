<?php
include 'db.php';

$day_name = $_POST['day_name'];
$breakfast = $_POST['breakfast'];
$lunch = $_POST['lunch'];
$dinner = $_POST['dinner'];

$sql = "INSERT INTO weekly_meals (day_name, breakfast, lunch, dinner)
        VALUES ('$day_name', '$breakfast', '$lunch', '$dinner')";

if ($conn->query($sql) === TRUE) {
    echo "Meal added successfully.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>