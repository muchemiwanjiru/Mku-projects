<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare delete query
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "User deleted successfully. <a href='dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "Error deleting user: " . $stmt->error;
    }
} else {
    echo "No user ID specified.";
}
?>
