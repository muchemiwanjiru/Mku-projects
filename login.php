<?php
session_start();
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
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
    .login-box {
      background-color: red;
      color: white;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-form {
      background-color: white;
      padding: 25px;
      border-radius: 10px;
      width: 300px;
      color: black;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }
    h2 {
      margin-top: 0;
      text-align: center;
    }
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      width: 100%;
      padding: 10px;
      background-color: black;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #333;
    }
    .message {
      margin-top: 10px;
      text-align: center;
      font-weight: bold;
      color: red;
    }
  </style>
</head>
<body>

<div class="login-box">
  <div class="login-form">
    <h2>Login</h2>
    <form method="post" action="">
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Login</button>
    </form>

    <?php if (!empty($message)): ?>
      <div class="message"><?= $message ?></div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
