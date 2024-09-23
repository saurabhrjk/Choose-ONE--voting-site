<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$database = new Database();
$conn = $database->getConnection();

// Fetch user profile information
$user_query = "SELECT username,name, email FROM users WHERE id = :user_id";
$user_stmt = $conn->prepare($user_query);
$user_stmt->bindParam(':user_id', $user_id);
$user_stmt->execute();
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose ONE-Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
	body{
        background-color: #f4f4f4;
	}
	
    .rakesh1{
        background-color:#fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        border-radius : 10px;
        padding-top:1px;
        padding-bottom:10px;
        margin-top:50px;
    }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'components/navbar.php'; ?>

    <div class="container rakesh1" >
        <h2 class="my-4" class="heading">User Profile</h2>
        
                <h5>Username : <?php echo htmlspecialchars($user['username']);?></h5><br>
                <p>Name : <?php echo htmlspecialchars($user['name']);?></p>
                <p >Email : <?php echo htmlspecialchars($user['email']); ?></p>
          
    </div>

    <?php include 'components/footer.php'; ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
