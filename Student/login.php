<?php
session_start();
include "pdo.php";

$error = "";
$email = "";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | StudentHub</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }

        .logo {
            width: 60px;
            height: 60px;
            background: #2563eb;
            color: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: auto;
        }

        h1 {
            text-align: center;
            margin-top: 15px;
            color: #111827;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin: 8px 0 30px;
        }

        .error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #374151;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }

        .login-btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-btn:hover {
            background: #1d4ed8;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
        }

        .footer a {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="login-box">

    <div class="logo">🎓</div>

    <h1>StudentHub</h1>

    <p class="subtitle">
        Sign in to manage your students
    </p>

    <?php if ($error): ?>
        <div class="error">
            ⚠️ <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label for="email">Email Address</label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                value="<?php echo htmlspecialchars($email); ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
            >
        </div>

        <button type="submit" name="login" class="login-btn">
            🔑 Login
        </button>

    </form>

    <div class="footer">
        Don't have an account?
        <a href="register.php">Register</a>
    </div>

</div>

</body>
</html>

