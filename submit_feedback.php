<?php
// Ensure the form data is properly captured
$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$feedback = isset($_POST['feedback']) ? $_POST['feedback'] : '';
$rating = isset($_POST['rating']) ? $_POST['rating'] : '';

if ($name === '' || $email === '' || $feedback === '' || $rating === '') {
    die("All form fields are required.");
}

// Database connection parameters
$servername = "localhost";
$username = "home"; // replace with your actual username
$password = "eUITzQc0K!x4c)*!"; // replace with your actual password
$dbname = "campaign_feedback";

// Establish a connection to the campaign_feedback database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback, rating) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $name, $email, $feedback, $rating);

// Execute the statement
if ($stmt->execute()) {
    echo "Thank you for your feedback!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
