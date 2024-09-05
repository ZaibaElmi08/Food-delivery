<?php
// Start session (assuming you're using sessions for user authentication)
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if new password matches the confirm password
    if ($newPassword != $confirmPassword) {
        echo "New password and confirm password do not match.";
        exit;
    }

    // Check if user is logged in and retrieve the user ID from the session
    if (!isset($_SESSION['user_id'])) {
        echo "User not logged in.";
        exit;
    }
    $userId = $_SESSION['user_id'];

    // Connect to the database (replace 'your_host', 'your_username', 'your_password', and 'your_database' with your actual database credentials)
    $conn = mysqli_connect('localhost', 'root', '', 'delecious_food_order');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Update user password in the change_password table
    $sql = "UPDATE change_password SET new_password = ? WHERE user_id = ? AND current_password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $newPassword, $userId, $currentPassword);

    if ($stmt->execute()) {
        // Password changed successfully, redirect to user account page
        header("Location: user_account.html");
        exit;
    } else {
        // Error occurred during password change, display error message
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
