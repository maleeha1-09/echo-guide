<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obstacle Detection System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar">
    <div class="brand">Echo Guide</div>
    <div class="nav-links">
        <?php if(isAuthenticated()): ?>
            <a href="dashboard.php">Dashboard</a>
            <?php if(isAdmin()): ?>
                <a href="users.php">Users</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>