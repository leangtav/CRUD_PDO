<?php

include ("PDO.php");

if(isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM students WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

}

header("Location:get.php");
exit();

?>
