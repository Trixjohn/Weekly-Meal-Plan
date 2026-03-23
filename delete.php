<?php
include 'db.php';

$id = $_POST['id'];

$sql = "DELETE FROM weekly_meals WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Meal deleted successfully.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>