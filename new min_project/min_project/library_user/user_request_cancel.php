<?php
include "connection.php";

if(isset($_GET["id"])){
    $id = $_GET["id"];

    
    $sql_delete = "DELETE  FROM `request_book` WHERE Book_Id= $id";
    $conn->query($sql_delete);
}
header("location: userhome.php");
exit;

?>$sql_move_to_pending = "INSERT INTO pending SELECT * FROM neworder WHERE irm = $irm";