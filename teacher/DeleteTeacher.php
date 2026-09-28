<?php

include("PDO.php");

if (!isset($_GET['id'])) {

    header("Location: getTeacher.php");
    exit();

}

$id = $_GET['id'];

$sql = "DELETE FROM teachers WHERE id = ?";

$stmt = $conn->prepare($sql);

$stmt->execute([$id]);

header("Location: getTeacher.php");

exit();

?>