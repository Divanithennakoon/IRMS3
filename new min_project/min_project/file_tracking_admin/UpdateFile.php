<?php
session_start(); // Start session

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "min_project";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form input
$SearchedFileNo = filter_input(INPUT_POST, "FID");
$FNo = filter_input(INPUT_POST, "fileNo");
$FName = filter_input(INPUT_POST, "fileName");
$Minit = filter_input(INPUT_POST, "minit");
$Year = filter_input(INPUT_POST, "year");
$Cupboard = filter_input(INPUT_POST, "cupboardno");
$Rack = filter_input(INPUT_POST, "rackno");
$Docket = filter_input(INPUT_POST, "docketno");

// Confirm that the File no is not changed
if ($SearchedFileNo != $FNo) {
    die("Connection Failed. You have tried to change the File No");
}

// SQL query
$sql = "UPDATE file 
        SET File_Id = '$FNo', File_Name = '$FName', No_Of_MinitSheets = '$Minit', Year = '$Year', Cupboard_No = '$Cupboard', Rack_No = '$Rack', Docket_No = '$Docket' 
        WHERE File_Id = '$SearchedFileNo'";

// Execute SQL query
if (mysqli_query($conn, $sql)) {
    // Set session variable for success message
    $_SESSION['update_success'] = true;
    // Prepare response
    $response = array(
        'success' => true,
        'message' => 'Record updated successfully'
    );
    echo json_encode($response);
} else {
    // Prepare response
    $response = array(
        'success' => false,
        'message' => 'Error updating record: ' . mysqli_error($conn)
    );
    echo json_encode($response);
}

// Close database connection
mysqli_close($conn);
?>
