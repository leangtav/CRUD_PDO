<?php

include("PDO.php");

$error = "";

if (isset($_POST['submit'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);

    // Check duplicate email
    $check = "SELECT id FROM teachers WHERE email = ?";

    $stmt = $conn->prepare($check);
    $stmt->execute([$email]);

    if ($stmt->fetch()) {

        $error = "This email already exists!";

    } else {

        $sql = "INSERT INTO teachers (name, email, subject)
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            $name,
            $email,
            $subject
        ]);

        header("Location: getTeacher.php");
        exit();

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Teacher</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f4f7fb;
        }

        .header {
            background: #1e293b;
            color: white;
            padding: 20px 40px;
        }

        .container {
            width: 500px;
            max-width: 90%;
            margin: 50px auto;
        }

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 25px;
            color: #1e293b;
        }

        label {
            font-weight: bold;
            color: #475569;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 7px;
            margin-bottom: 18px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
        }

        .error {
            background: #fee2e2;
            color: #dc2626;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

    <div class="header">

        <h2>StudentHub</h2>

    </div>


    <div class="container">

        <div class="form-box">

            <h2>
                Add New Teacher
            </h2>


            <?php if ($error != ""): ?>

                <div class="error">

                    <?= htmlspecialchars($error) ?>

                </div>

            <?php endif; ?>


            <form method="POST">

                <label>
                    Name
                </label>

                <input
                    type="text"
                    name="name"
                    placeholder="Enter teacher name"
                    required>


                <label>
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter email"
                    required>


                <label>
                    Subject
                </label>

                <input
                    type="text"
                    name="subject"
                    placeholder="Enter subject"
                    required>


                <button
                    type="submit"
                    name="submit">

                    Create 

                </button>

            </form>


            <a
                href="getTeacher.php"
                class="back">

                ← Back to Teacher List

            </a>

        </div>

    </div>

</body>

</html>