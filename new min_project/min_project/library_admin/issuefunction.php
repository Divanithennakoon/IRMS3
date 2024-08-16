<?php
include "connection.php";

if(isset($_GET["id"])){
    $id = $_GET["id"];

    $sql= "INSERT INTO  `issue_book`(nic,Book_Id,ISBN,Book_Name,Author,Year,Category,username) SELECT * FROM request_book WHERE Book_Id= $id";
    $sql_delete = "DELETE  FROM `request_book` WHERE Book_Id= $id";
    $conn->query($sql);
    $conn->query($sql_delete);
}
header("location: requestedbook.php");
exit;

?>$sql_move_to_pending = "INSERT INTO pending SELECT * FROM neworder WHERE irm = $irm";