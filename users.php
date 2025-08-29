<?php
include('includes/config.php');
include('includes/auth.php');

// Redirect if not authenticated or not admin
redirectIfNotAuthenticated();
if (!isAdmin()) {
    $_SESSION['error'] = "Unauthorized access!";
    header("Location: dashboard.php");
    exit();
}

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $user_id = intval($_GET['delete_id']);
    
    // Prevent self-deletion
    if ($user_id == $_SESSION['user_id']) {
        $_SESSION['error'] = "You cannot delete your own account";
    } else {
        try {
            $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "User deleted successfully";
            } else {
                $_SESSION['error'] = "Error deleting user: " . $conn->error;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Database error: " . $e->getMessage();
        }
    }
    header("Location: users.php");
    exit();
}

// Get all users
$query = "SELECT id, username, role, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<?php include('includes/header.php'); ?>
<body>
    <div class="container">
        <h1>Manage Users</h1>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="sensor-data">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td>
                                <span class="role-badge <?= htmlspecialchars($user['role']) ?>">
                                    <?= ucfirst(htmlspecialchars($user['role'])) ?>
                                </span>
                            </td>
                            <td><?= date('M j, Y H:i', strtotime($user['created_at'])) ?></td>
                            <td>
                                <a href="users.php?delete_id=<?= $user['id'] ?>" 
                                   class="btn btn-danger"
                                   onclick="return confirm('Are you sure you want to permanently delete this user?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="admin-links" style="margin-top: 2rem;">
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
</body>
</html>