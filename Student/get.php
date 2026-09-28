<?php

include ("PDO.php");

$sql = "SELECT * FROM students";

$stmt = $conn->prepare($sql);
$stmt->execute();

$student = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="en">

<head>

```
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Management</title>

<style>

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    body {
        background: #f2f4f7;
        min-height: 100vh;
        padding: 50px 20px;
    }

    .container {
        max-width: 1000px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    h2 {
        color: #333;
    }

    .create-btn {
        background: #007bff;
        color: white;
        text-decoration: none;
        padding: 11px 18px;
        border-radius: 7px;
        font-weight: bold;
    }

    .create-btn:hover {
        background: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #007bff;
        color: white;
    }

    th,
    td {
        padding: 14px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        text-transform: uppercase;
        font-size: 14px;
    }

    tbody tr:hover {
        background: #f5f8ff;
    }

    .edit {
        background: #28a745;
        color: white;
        text-decoration: none;
        padding: 7px 12px;
        border-radius: 5px;
        margin-right: 5px;
    }

    .edit:hover {
        background: #1e7e34;
    }

    .delete {
        background: #dc3545;
        color: white;
        text-decoration: none;
        padding: 7px 12px;
        border-radius: 5px;
    }

    .delete:hover {
        background: #b02a37;
    }

    .empty {
        text-align: center;
        padding: 25px;
        color: #777;
    }

    @media (max-width: 700px) {

        .container {
            padding: 20px;
            overflow-x: auto;
        }

        table {
            min-width: 650px;
        }

    }

</style>
```

</head>

<body>

<div class="container">

```
<div class="header">

    <h2>Student Management</h2>

    <a href="create.php" class="create-btn">
        + Create Student
    </a>

</div>

<table>

    <thead>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Action</th>
        </tr>

    </thead>

    <tbody>

    <?php if (count($student) > 0): ?>

        <?php foreach ($student as $stu): ?>

            <tr>

                <td>
                    <?= htmlspecialchars($stu['id']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($stu['name']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($stu['email']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($stu['age']) ?>
                </td>

                <td>

                    <a
                        href="edit.php?id=<?= $stu['id'] ?>"
                        class="edit">
                        Edit
                    </a>

                    <a
                        href="delete.php?id=<?= $stu['id'] ?>"
                        class="delete"
                        onclick="return confirm('Are you sure you want to delete this student?');">
                        Delete
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    <?php else: ?>

        <tr>
            <td colspan="5" class="empty">
                No students found.
            </td>
        </tr>

    <?php endif; ?>

    </tbody>

</table>
```

</div>

</body>

</html>
