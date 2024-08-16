<?php
// Database connection details
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "min_project";

// Create connection
$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $nic = $_POST['nic'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $fileTrackingSystem = $_POST['file_tracking_system'];
    $libraryManagementSystem = $_POST['library_management_system'];
    $inventorySystem = $_POST['inventory_system'];

    // Insert data into user table
    $sql_insert_user = "INSERT INTO user (first_name, last_name, nic, password, username) VALUES ('$firstName', '$lastName', '$nic', '$password', '$username')";

    if (mysqli_query($conn, $sql_insert_user)) {
        // Insert data into permission table
        $sql_insert_permission = "INSERT INTO permission (nic, file_tracking, library_management, inventory) VALUES ('$nic', '$fileTrackingSystem', '$libraryManagementSystem', '$inventorySystem')";

        if (mysqli_query($conn, $sql_insert_permission)) {
            // Data inserted successfully, now delete from user_temp
            $sql_delete = "DELETE FROM user_temp WHERE nic='$nic'";
            if (mysqli_query($conn, $sql_delete)) {
                // Redirect back to dashboard after successful insertion and deletion
                header("Location: super_admin_dashboard2.php");
                exit();
            } else {
                echo "Error deleting temporary user data: " . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $sql_insert_permission . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $sql_insert_user . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
