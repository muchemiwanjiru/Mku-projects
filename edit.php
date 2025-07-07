<?php
include 'db.php';

// Get the user ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $id);

    if ($stmt->execute()) {
        echo "User updated successfully. <a href='dashboard.php'>Back to Dashboard</a>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch existing data to prefill the form
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit();
}
?>

<!-- Update Form -->
<h2>Edit User</h2>
<form method="post">
  <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>
  <button type="submit">Update</button>
</form>
<a href="dashboard.php">Cancel</a>
