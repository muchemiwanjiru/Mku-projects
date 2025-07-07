<?php
include 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Check for existing username or email
    $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Username or Email already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
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
    .register-box {
      background-color: red;
      color: white;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .register-form {
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
    input[type="text"],
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
      font-weight: bold;
      text-align: center;
      color: green;
    }
    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="register-box">
  <div class="register-form">
    <h2>Register</h2>
    <form method="post" action="">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Register</button>
    </form>

    <?php if (!empty($message)): ?>
      <div class="<?= strpos($message, 'successful') !== false ? 'message' : 'error' ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>
  </div>
</div>

</body>
</html>
