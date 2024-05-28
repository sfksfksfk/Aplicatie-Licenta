<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT image_name FROM images";
$result = $conn->query($sql);

$imageNames = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $imageNames[] = $row['image_name'];
    }
}

$conn->close();
echo json_encode($imageNames);
?>
