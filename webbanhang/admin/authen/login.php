<?php
// login.php
require_once(__DIR__ . '/../../database/config.php');
require_once(__DIR__ . '/../../database/helper.php');
require_once 'auth_controller.php';

session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra xác thực không phải người máy (CAPTCHA)
    if (isset($_POST['checkbox']) && $_POST['checkbox'] == 'checked') {
        // Tiếp tục với đăng nhập
        $auth = new AuthController();
        $login = $auth->login($username, $password);

        if ($login) {
            $role = $auth->getUserRole($username);
            if ($role === 'admin') {
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = $username;
                header('Location: ../index.php');
                exit();
            } else {
                $error = "You do not have permission to access the admin area!";
            }
        } else {
            $error = "Invalid username or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        /* Paste your CSS styles here */
        /* Bordered form */
        form {
            border: 3px solid #f1f1f1;
        }

        /* Full-width inputs */
        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Set a style for all buttons */
        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        /* Add a hover effect for buttons */
        button:hover {
            opacity: 0.8;
        }

        /* Extra style for the cancel button (red) */
        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        /* Center the avatar image inside this container */
        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
        }

        /* Avatar image */
        img.avatar {
            width: 40%;
            border-radius: 50%;
        }

        /* Add padding to containers */
        .container {
            padding: 16px;
        }

        /* The "Forgot password" text */
        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <div class="imgcontainer">
            <img src="img_avatar2.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <label><input type="checkbox" name="checkbox" value="checked"> I'm not a robot</label>

            <button type="submit">Login</button>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </div>
    </form>
</body>
</html>
