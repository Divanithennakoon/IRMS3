<?php
include "connection.php";

// Get data from the form submission
$nic = $_POST['nic'];
$Book_Id = $_POST['Book_Id'];
$ISBN = $_POST['ISBN'];
$Book_Name = $_POST['Book_Name'];
$Author = $_POST['Author'];
$Year = $_POST['Year'];
$Category = $_POST['Category'];
$username = $_POST['username'];
$issue_date = $_POST['issue_date'];

// Start transaction
$conn->begin_transaction();

try {
    
    // Insert the record into the return_book table
    $stmt = $conn->prepare("INSERT INTO return_book (nic, Book_Id, ISBN, Book_Name, Author, Year, Category, username, issue_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", $nic, $Book_Id, $ISBN, $Book_Name, $Author, $Year, $Category, $username, $issue_date);
    $stmt->execute();
    $stmt->close();

    // Delete the record from the issue_book table
    $stmt = $conn->prepare("DELETE FROM issue_book WHERE Book_Id = ?");
    $stmt->bind_param("i", $Book_Id);
    $stmt->execute();
    $stmt->close();

    
} 
header("location: ");
exit;

// Close the database connection
$conn->close();
?>
