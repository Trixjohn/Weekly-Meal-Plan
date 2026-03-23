<?php
include 'db.php';

$sql = "SELECT * FROM weekly_meals ORDER BY FIELD(day_name, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')";
$result = $conn->query($sql);

$meals = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $meals[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($meals);

$conn->close();
?>