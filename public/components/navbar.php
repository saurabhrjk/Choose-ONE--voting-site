<?php
//session_start();
?>
<style>
    nav {
    background-color: #333;
    color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}   
</style>

<nav class="navbar navbar-expand-lg navbar-light rakesh">
    <a class="navbar-brand" style="color:white;" href="index.php">Choose ONE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="navbar-text" style="color:white;">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php" style="color:white;">
                    <i class="fas fa-user"></i> Profile
                </a>
            </li>
            <li class="nav-item" >
                <form action="logout.php" method="POST" class="form-inline" >
                    <button type="submit" class="btn btn-link nav-link" style="color:white;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>



