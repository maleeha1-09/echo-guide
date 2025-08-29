<?php
include('includes/config.php');
include('includes/auth.php');
redirectIfNotAuthenticated();

$query = "SELECT * FROM sensor_data ORDER BY timestamp DESC LIMIT 50";
$result = $conn->query($query);

// Handle data deletion
if (isset($_POST['delete_data']) && isAdmin()) {
    try {
        $stmt = $conn->prepare("DELETE FROM sensor_data");
        if ($stmt->execute()) {
            $_SESSION['success'] = "All sensor data deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting data: " . $conn->error;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<?php include('includes/header.php'); ?>
<head>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="refresh" content="5">
</head>
<body>
    <div class="container">
        <h1>Obstacle Detection Dashboard</h1>
        <div class="data-controls">
    <?php if(isAdmin()): ?>
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete ALL sensor data?')">
            <button type="submit" name="delete_data" class="btn btn-danger">
                Delete All Previous Data
            </button>
        </form>
    <?php endif; ?>
</div>
        <div class="sensor-data">
            <table>
                <tr>
                    <th>Timestamp</th>
                    <th>Distance (cm)</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= date('Y-m-d H:i:s', strtotime($row['timestamp'])) ?></td>
                    <td><?= $row['distance'] ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <?php if(isAdmin()): ?>
        <div class="admin-links">
            <a href="users.php">Manage Users</a>
        </div>
        <?php endif; ?>
        <a href="logout.php" class="logout">Logout</a>
    </div>
     <?php include('includes/footer.php'); ?>
</body>
</html>