<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nic'])) {
    // Redirect to login page if not logged in
    header("Location: login_process.php");
    exit();
}

// Include database connection
include "connection.php";

// Handle request book functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $bookId = mysqli_real_escape_string($conn, $_POST['book_id']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $bookName = mysqli_real_escape_string($conn, $_POST['book_name']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    //$username = $_SESSION['username'];
    $nic = $_SESSION['nic'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Insert request into database
    $insert_query = "INSERT INTO request_book (nic, Book_Id, ISBN, Book_Name, Author, Year, Category) 
                     VALUES ('$nic', '$bookId', '$isbn', '$bookName', '$author', '$year', '$category')";
    $result = mysqli_query($conn, $insert_query);
    
    
}header("location: userhome.php");
exit;

// Close database connection
mysqli_close($conn);
?>
