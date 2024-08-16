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
$Docket = filter_input(INPUT_POST, "docket");
$Capacity = filter_input(INPUT_POST, "capacity");
$Cupboard = filter_input(INPUT_POST, "cupboardno");
$Rack = filter_input(INPUT_POST, "rackno");

// Check if the docket already exists
$sql_check_docket = "SELECT Docket_No FROM docket WHERE Docket_No = $Docket";
$result_check_docket = mysqli_query($conn, $sql_check_docket);

if (mysqli_num_rows($result_check_docket) == 1) {
    // Store error message in localStorage
    echo "<script>";
    echo "localStorage.setItem('messageType', 'error');";
    echo "localStorage.setItem('messageContent', 'Error: The attempt to add the New Docket has failed. Entered Docket number already exists.');";
    echo "window.location.href = 'index-AddDocket.html';";
    echo "</script>";
} else {
    // Insert new docket if it doesn't exist
    $sql_insert_docket = "INSERT INTO docket (Docket_No, Size, Cupboard_No, Rack_No, Status) VALUES ($Docket, $Capacity, $Cupboard, $Rack, 1)";
    if (mysqli_query($conn, $sql_insert_docket)) {
        mysqli_close($conn);
        // Store success message in localStorage
        echo "<script>";
        echo "localStorage.setItem('messageType', 'success');";
        echo "localStorage.setItem('messageContent', 'The New Docket has been successfully added.');";
        echo "window.location.href = 'index-AddDocket.html';";
        echo "</script>";
    } else {
        mysqli_close($conn);
        // Store error message in localStorage if insertion fails
        echo "<script>";
        echo "localStorage.setItem('messageType', 'error');";
        echo "localStorage.setItem('messageContent', 'Error: Failed to add the New Docket. Please try again.');";
        echo "window.location.href = 'index-AddDocket.html';";
        echo "</script>";
    }
}
?>
