<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Connect to the database (replace 'your_host', 'your_username', 'your_password', and 'your_database' with your actual database credentials)
    $conn = mysqli_connect('localhost', 'root', '', 'delecious_food_order');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Update user profile in the update_profile table
    $sql = "UPDATE update_profile SET name = '$name' WHERE email = '$email'";
    if (mysqli_query($conn, $sql)) {
        // Profile updated successfully, redirect to user account page
        header("Location: user_account.html");
        exit;
    } else {
        // Error occurred during profile update, display error message
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
