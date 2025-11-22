<?php
// Database connection configuration
$servername = "localhost";
$username = "root";  
$password = " ";  
$dbname = "database_dp";    

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.history.back();</script>";
        exit();
    }
    
    // Insert data into database
    $sql = "INSERT INTO contacts (first_name, last_name, email, phone, message, created_at) 
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$message', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        // Success message and redirect
        echo "<script>
                alert('Thank you! Your message has been sent successfully.');
                window.location.href = '../contact.html';
              </script>";
    } else {
        // Error message
        echo "<script>
                alert('Error: " . $conn->error . "');
                window.history.back();
              </script>";
    }
} else {
    // Redirect if accessed directly
    header("Location: ../contact.html");
    exit();
}

// Close connection
$conn->close();
?>