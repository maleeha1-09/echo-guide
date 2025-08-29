<?php
include('includes/config.php');
include('includes/auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = 'user';

    // Validation
    if(empty($username) || empty($password)) {
        $error = "All fields are required";
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        if($stmt->get_result()->num_rows > 0) {
            $error = "Username already exists";
        } else {
            // Create user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashed_password, $role);
            
            if($stmt->execute()) {
                $_SESSION['success'] = "Registration successful! Please login.";
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed: " . $conn->error;
            }
        }
    }
}
?>

<?php include('includes/header.php'); ?>
<div class="container">
    <h2>Register</h2>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form class="auth-form" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn">Register</button>
        <p style="margin-top: 1rem;">
            Already have an account? <a href="login.php">Login here</a>
        </p>
    </form>
</div>
<?php include('includes/footer.php'); ?>