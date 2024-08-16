<?php
include "connection.php";

if(isset($_GET["id"])){
    $id = $_GET["id"];

    $sql= "DELETE FROM `book` WHERE Book_Id= $id";
    $conn->query($sql);
}
header("location: managebook.php");
exit;

?>