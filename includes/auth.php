<?php
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function redirectIfNotAuthenticated() {
    if (!isAuthenticated()) {
        header("Location: login.php");
        exit();
    }
}


?>