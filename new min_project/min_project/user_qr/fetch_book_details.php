<?php
include "connection.php";

// Get the JSON data from the AJAX request
$input = json_decode(file_get_contents("php://input"), true);
$Book_Id = $input['Book_Id'];

// Prepare and execute the SQL query to fetch book details
$stmt = $conn->prepare("SELECT nic, Book_Name,ISBN, Book_Id, Author, Category,username, Year, issued_date FROM issue_book WHERE Book_Id = ?");
$stmt->bind_param("i", $Book_Id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the book was found and return the data as JSON
if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();
    echo json_encode($book);
} else {
    echo json_encode(['error' => 'No book found']);
}

$stmt->close();
$conn->close();
?>
