<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Perform authentication (replace this with your actual authentication logic)
    if ($email == "example@example.com" && $password == "password123") {
        // Authentication successful, proceed with database insertion
        // Connect to the database
        $dsn = "mysql:host=localhost;dbname=delecious_food_order";
        $username = "root";
        $db_password = "";

        try {
            $pdo = new PDO($dsn, $username, $db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert user data into the database
            $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email, $password]);

            // Redirect to user account page
            header("Location: account.html");
            exit();
        } catch (PDOException $e) {
            // Redirect back to login page with error message if database insertion fails
            header("Location: form.html?error=database_error");
            exit();
        }
    } else {
        // Authentication failed, redirect back to login page with error message
        header("Location: form.html?error=authentication_error");
        exit();
    }
} else {
    // If the form is not submitted, redirect back to the form page
    header("Location: form.html");
    exit();
}
?>
