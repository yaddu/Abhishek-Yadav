<?php
// Database credentials
$host = 'localhost';         // MySQL server (usually localhost)
$username = 'root';          // MySQL username (default is 'root' on local servers)
$password = '';              // MySQL password (default is an empty string on local servers)
$dbname = 'user_registration'; // The name of the database you created

// Create a connection to MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate passwords
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone_number, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $email, $phone_number, $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and the connection
    $stmt->close();
    $conn->close();
}
?>
