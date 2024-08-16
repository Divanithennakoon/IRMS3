<?php
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
$DocketNo = filter_input(INPUT_POST, "docket");
    
$sql_delete = "DELETE FROM docket WHERE Docket_No = '$DocketNo'";
    
// Execute DELETE query
if (mysqli_query($conn, $sql_delete)){
    echo "Record deleted successfully. ";
   
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>
