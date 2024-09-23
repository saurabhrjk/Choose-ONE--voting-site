<?php
session_start();
include_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $conn = $database->getConnection();

    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the username or email already exists
    $check_query = "SELECT * FROM users WHERE username = :username OR email = :email";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bindParam(':username', $username);
    $check_stmt->bindParam(':email', $email);
    $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        // If username or email already exists, redirect back to registration with an error
        header("Location: register.php?error=exists");
        exit;
    } else {
        // Insert new user into the database
        $insert_query = "INSERT INTO users (username, name, email, password) VALUES (:username, :name, :email, :password)";
        $insert_stmt = $conn->prepare($insert_query);
        $insert_stmt->bindParam(':username', $username);
        $insert_stmt->bindParam(':name', $name);
        $insert_stmt->bindParam(':email', $email);
        $insert_stmt->bindParam(':password', $password);

        if ($insert_stmt->execute()) {
            // Redirect to login page after successful registration
            header("Location: login.php?success=registered");
            exit;
        } else {
            // Redirect back to registration with an error if the registration fails
            header("Location: register.php?error=failed");
            exit;
        }
    }
}
?>
