<?php

include("PDO.php");

$sql = "SELECT * FROM teachers ORDER BY id ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();

$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Teacher Management</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f7fb;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */

        .sidebar {
            width: 230px;
            background: #1e293b;
            color: white;
            padding: 25px 15px;
        }

        .logo {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 14px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
        }

        .menu a:hover {
            background: #334155;
        }

        .menu .active {
            background: #2563eb;
        }

        /* Main */

        .main {
            flex: 1;
        }

        .header {
            background: white;
            padding: 20px 30px;
            border-bottom: 1px solid #ddd;
        }

        .header h1 {
            font-size: 25px;
            color: #1e293b;
        }

        .content {
            padding: 30px;
        }

        /* Cards */

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            flex: 1;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .card h3 {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
        }

        /* Table */

        .table-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-header h2 {
            color: #1e293b;
        }

        .add-btn {
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 7px;
        }

        .add-btn:hover {
            background: #1d4ed8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f1f5f9;
            color: #475569;
            padding: 14px;
            text-align: left;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
        }

        tr:hover {
            background: #f8fafc;
        }

        .edit {
            color: #2563eb;
            text-decoration: none;
            margin-right: 10px;
        }

        .delete {
            color: #dc2626;
            text-decoration: none;
        }

        .edit:hover,
        .delete:hover {
            text-decoration: underline;
        }

        /* Mobile */

        @media (max-width: 768px) {

            .sidebar {
                width: 180px;
            }

            .cards {
                flex-direction: column;
            }

            .content {
                padding: 15px;
            }

            .table-box {
                overflow-x: auto;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <!-- Sidebar -->

    <div class="sidebar">

        <div class="logo">
            StudentHub
        </div>

        <div class="menu">

            <a href="#">
                Dashboard
            </a>

            <a href="#">
                Students
            </a>

            <a href="getTeacher.php" class="active">
                Teachers
            </a>

        </div>

    </div>


    <!-- Main -->

    <div class="main">

        <div class="header">

            <h1>
                Teacher Management
            </h1>

        </div>


        <div class="content">

            <!-- Cards -->

            <div class="cards">

                <div class="card">

                    <h3>
                        Total Teachers
                    </h3>

                    <p>
                        <?= count($teachers) ?>
                    </p>

                </div>

                <div class="card">

                    <h3>
                        Subjects
                    </h3>

                    <p>
                        <?= count(array_unique(array_column($teachers, 'subject'))) ?>
                    </p>

                </div>

            </div>


            <!-- Table -->

            <div class="table-box">

                <div class="table-header">

                    <h2>
                        Teacher List
                    </h2>

                    <a
                        href="CreateTeacher.php"
                        class="add-btn">

                        + Add Teacher

                    </a>

                </div>


                <table>

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Name</th>

                            <th>Email</th>

                            <th>Subject</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php if (count($teachers) > 0): ?>

                            <?php foreach ($teachers as $tea): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($tea['id']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($tea['name']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($tea['email']) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($tea['subject']) ?>
                                    </td>

                                    <td>

                                        <a
                                            class="edit"
                                            href="UpdateTeacher.php?id=<?= $tea['id'] ?>">

                                            Edit

                                        </a>


                                        <a
                                            class="delete"
                                            href="DeleteTeacher.php?id=<?= $tea['id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this teacher?');">

                                            Delete

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="5" style="text-align:center;">

                                    No teachers found.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>