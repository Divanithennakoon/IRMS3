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
$Docket = filter_input(INPUT_POST, "DNo");
$Capacity = filter_input(INPUT_POST, "capacity");
$Cupboard = filter_input(INPUT_POST, "cupboardno");
$Rack = filter_input(INPUT_POST, "rackno");

// Prepare SQL statement
$sql = "UPDATE docket 
        SET Size = ?, Cupboard_No = ?, Rack_No = ? 
        WHERE Docket_No = ?";

// Prepare and bind parameters
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiii", $Capacity, $Cupboard, $Rack, $Docket);

// Execute SQL query
if (mysqli_stmt_execute($stmt)) {
    $status = 'success';
    $message = 'Record updated successfully';
} else {
    $status = 'error';
    $message = 'Error updating record: ' . mysqli_error($conn);
}

// Close statement
mysqli_stmt_close($stmt);

// Close database connection
mysqli_close($conn);

// Redirect back to the form with status and message
header("Location: UpdateD.php?status=$status&message=" . urlencode($message));
exit();
?>
