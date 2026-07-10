<?php
include 'config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted permanently!'); window.location.href='archive-users.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.'); window.location.href='archive-users.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='archive-users.php';</script>";
}
