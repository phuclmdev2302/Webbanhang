<?php
// register.php
require_once(__DIR__ . '/../../database/config.php');
require_once(__DIR__ . '/../../database/helper.php');
require_once 'auth_controller.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Kiểm tra xác nhận mật khẩu
    if ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        $auth = new AuthController();
        $register = $auth->register($username, $password);

        if ($register === true) {
            header('Location: login.php');
            exit();
        } else {
            $error = "Username already exists!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <!-- Include your CSS styles here -->
    <style>
        /* Add your CSS styles based on your provided CSS */
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container h1 {
            text-align: center;
        }
        .container label {
            font-weight: bold;
        }
        .container input[type=text], 
        .container input[type=password] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .container p {
            text-align: center;
        }
        .container .registerbtn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .container .registerbtn:hover {
            background-color: #45a049;
        }
        .container .signin {
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <div class="container">
            <h1>Register</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <label for="confirm_password"><b>Confirm Password</b></label>
            <input type="password" placeholder="Confirm Password" name="confirm_password" required>

            <button type="submit" class="registerbtn">Register</button>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </div>

        <div class="container signin">
            <p>Already have an account? <a href="login.php">Sign in</a>.</p>
        </div>
    </form>
</body>
</html>
