<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include 'db.php';

// Restrict access to logged-in users only
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: Arial, sans-serif;
    }
    .dashboard-wrapper {
      background-color: red;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 0;
    }
    .dashboard-box {
      background-color: white;
      width: 90%;
      max-width: 900px;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }
    h2 {
      margin-top: 0;
      color: black;
      text-align: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f0f0f0;
    }
    .btn {
      padding: 6px 12px;
      text-decoration: none;
      border-radius: 5px;
      color: white;
      font-size: 14px;
    }
    .edit-btn {
      background-color: #007bff;
    }
    .delete-btn {
      background-color: #dc3545;
    }
    .logout-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: black;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    .logout-btn:hover {
      background-color: #333;
    }
  </style>
</head>
<body>

<div class="dashboard-wrapper">
  <div class="dashboard-box">
    <h2>Welcome, <?= htmlspecialchars($_SESSION["username"]) ?>!</h2>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = $conn->query("SELECT * FROM users");
        while ($row = $result->fetch_assoc()):
        ?>
          <tr>
            <td><?= $row["id"] ?></td>
            <td><?= htmlspecialchars($row["username"]) ?></td>
            <td><?= htmlspecialchars($row["email"]) ?></td>
            <td><?= $row["created_at"] ?></td>
            <td>
              <a class="btn edit-btn" href="edit.php?id=<?= $row["id"] ?>">Edit</a>
              <a class="btn delete-btn" href="delete.php?id=<?= $row["id"] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <a class="logout-btn" href="logout.php">Logout</a>
  </div>
</div>

</body>
</html>
