<?php
include ("PDO.php");

$id = $_GET['id'];

$sql = "SELECT * FROM students WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

$student = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['edit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    $sql2 = "UPDATE students SET name=?, email=?, age=? WHERE id=?";
    $stmt1 = $conn->prepare($sql2);

    $stmt1->execute([
        $name,
        $email,
        $age,
        $id
    ]);

    header("Location:get.php");
    exit();
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>

```
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
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        width: 400px;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #333;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        margin-bottom: 7px;
        color: #555;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 7px;
        font-size: 15px;
    }

    input:focus {
        outline: none;
        border-color: #28a745;
    }

    button {
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 7px;
        background: #28a745;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background: #1e7e34;
    }

    .back {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #007bff;
        text-decoration: none;
    }
</style>
```

</head>

<body>

<div class="container">

```
<h2>Edit Student</h2>

<form method="POST">

    <div class="form-group">
        <label>Name</label>
        <input
            type="text"
            name="name"
            value="<?php echo htmlspecialchars($student['name']); ?>"
            required
        >
    </div>

    <div class="form-group">
        <label>Age</label>
        <input
            type="number"
            name="age"
            value="<?php echo htmlspecialchars($student['age']); ?>"
            required
        >
    </div>

    <div class="form-group">
        <label>Email</label>
        <input
            type="email"
            name="email"
            value="<?php echo htmlspecialchars($student['email']); ?>"
            required
        >
    </div>

    <button type="submit" name="edit">
        Update Student
    </button>

</form>

<a class="back" href="get.php">← Back to Students</a>

</div>

</body>
</html>
