<?php
include "connection.php";

if(isset($_GET["id"])){
    $id = $_GET["id"];

    $sql= "INSERT INTO  `return_book`(nic,Book_Id,ISBN,Book_Name,Author,Year,Category,username,issue_date) SELECT * FROM issue_book WHERE Book_Id= $id";
    $sql_delete = "DELETE  FROM `issue_book` WHERE Book_Id= $id";
    $conn->query($sql);
    $conn->query($sql_delete);
}
header("location: issuedbook.php");
exit;

?>$sql_move_to_pending = "INSERT INTO pending SELECT * FROM neworder WHERE irm = $irm";