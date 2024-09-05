<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "delecious_food_order";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form data to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert data into the contact_us table
    $sql = "INSERT INTO contact_us (name, email, message) VALUES ('$name', '$email', '$message')";
    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        echo "<script>alert('Your message has been sent successfully. We will get back to you soon.');</script>";
    } else {
        // Error inserting data
        echo "<script>alert('Oops! Something went wrong. Please try again later.');</script>";
    }

    // Insert data into the login table (assuming the email is unique)
    $sql_login = "INSERT INTO login (email) VALUES ('$email')";
    $conn->query($sql_login);

    // Insert data into the sign_up table
    $sql_signup = "INSERT INTO sign_up (name, email) VALUES ('$name', '$email')";
    $conn->query($sql_signup);

    // Insert data into the update_profile table
    $sql_update_profile = "INSERT INTO update_profile (name, email) VALUES ('$name', '$email')";
    $conn->query($sql_update_profile);

    // Insert data into the change_password table
    $sql_change_password = "INSERT INTO change_password (current_password, new_password, confirm_password, user_id) VALUES ('', '', '', (SELECT user_id FROM sign_up WHERE email='$email'))";
    $conn->query($sql_change_password);
}

// Close database connection
$conn->close();
?>
