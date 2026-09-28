<?php
session_start();
include "pdo.php";

$errors = [];
$name = "";
$email = "";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($name === "") {
        $errors['name'] = "Name is required.";
    }

    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "A valid email is required.";
    } else {

        $check = $conn->prepare(
            "SELECT * FROM users WHERE email = ?"
        );

        $check->execute([$email]);

        if ($check->fetch()) {
            $errors['email'] = "This email is already registered.";
        }
    }

    if (strlen($password) < 6) {
        $errors['password'] =
            "Password must be at least 6 characters.";
    }

    if (empty($errors)) {

        $hashedPassword =
            password_hash($password, PASSWORD_DEFAULT);

        $sql =
            "INSERT INTO users (name, email, password)
             VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            $name,
            $email,
            $hashedPassword
        ]);

        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register | Students</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #4f46e5
                );

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;
        }

        .register-box {
            width: 100%;
            max-width: 450px;

            background: white;

            padding: 40px;

            border-radius: 18px;

            box-shadow:
                0 20px 50px
                rgba(0,0,0,0.2);
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

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            font-weight: bold;

            color: #374151;
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

            box-shadow:
                0 0 0 3px
                rgba(37,99,235,0.12);
        }

        .error {
            color: #dc2626;

            font-size: 13px;

            margin-top: 6px;
        }

        .register-btn {
            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 8px;

            background: #2563eb;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            margin-top: 5px;
        }

        .register-btn:hover {
            background: #1d4ed8;
        }

        .footer {
            text-align: center;

            margin-top: 25px;

            padding-top: 20px;

            border-top:
                1px solid #e5e7eb;

            color: #6b7280;
        }

        .footer a {
            color: #2563eb;

            font-weight: bold;

            text-decoration: none;
        }

        @media (max-width: 500px) {

            .register-box {
                padding: 28px 20px;
            }

        }

    </style>

</head>

<body>

<div class="register-box">

    <div class="logo">🎓</div>

    <h1>Create Account</h1>

    <p class="subtitle">
        Join StudentHub to manage students
    </p>

    <form method="POST">

        <div class="form-group">

            <label for="name">
                Full Name
            </label>

            <input
                type="text"
                id="name"
                name="name"
                placeholder="Enter your name"
                value="<?php echo htmlspecialchars($name); ?>"
                required
            >

            <?php if (isset($errors['name'])): ?>

                <div class="error">
                    <?php echo $errors['name']; ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="email">
                Email Address
            </label>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email"
                value="<?php echo htmlspecialchars($email); ?>"
                required
            >

            <?php if (isset($errors['email'])): ?>

                <div class="error">
                    <?php echo $errors['email']; ?>
                </div>

            <?php endif; ?>

        </div>


        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimum 6 characters"
                required
            >

            <?php if (isset($errors['password'])): ?>

                <div class="error">
                    <?php echo $errors['password']; ?>
                </div>

            <?php endif; ?>

        </div>


        <button
            type="submit"
            name="register"
            class="register-btn"
        >
            ✓ Create Account
        </button>

    </form>


    <div class="footer">

        Already have an account?

        <a href="login.php">
            Login
        </a>

    </div>

</div>

</body>
</html>
