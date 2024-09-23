<?php
session_start();
include_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $candidate = $_POST['candidate'];

    $database = new Database();
    $conn = $database->getConnection();

    // Check if user has already voted
    $query = "SELECT has_voted FROM users WHERE id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user['has_voted']) {
        header("Location: index.php?error=already_voted");
        exit;
    }

    // Record the vote
    $vote_query = "INSERT INTO votes (user_id, candidate) VALUES (:user_id, :candidate)";
    $vote_stmt = $conn->prepare($vote_query);
    $vote_stmt->bindParam(':user_id', $user_id);
    $vote_stmt->bindParam(':candidate', $candidate);
    $vote_stmt->execute();

    // Mark the user as voted
    $update_query = "UPDATE users SET has_voted = 1 WHERE id = :user_id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':user_id', $user_id);
    $update_stmt->execute();

    // Redirect back to the home page with success message
    header("Location: index.php?success=vote_cast");
    exit;
}
?>
