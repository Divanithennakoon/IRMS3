<?php
include "connection.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Check if the category is assigned to any books
    $check_sql = "SELECT COUNT(*) as count FROM book WHERE Category = $id";
    $check_result = $conn->query($check_sql);
    $row = $check_result->fetch_assoc();

    if ($row["count"] > 0) {
        echo "<script>alert('There are books assigned to this category. Cannot delete!'); window.location.href = 'catagory.php';</script>";
    } else {
        $sql = "DELETE FROM `categories` WHERE category_id= $id";
        $conn->query($sql);
        header("location: catagory.php");
        exit;
    }
}
?>
