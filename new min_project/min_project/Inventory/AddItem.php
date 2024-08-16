<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";  
    $password = "";  
    $database = "min_project";

    $conn = mysqli_connect($servername, $username, $password, $database);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $ItemNo = trim(filter_input(INPUT_POST, "ItemNo"));
    $ItemName = trim(filter_input(INPUT_POST, "ItemName"));
    $Reorder = trim(filter_input(INPUT_POST, "reorder"));

    $sql = "INSERT INTO item (Item_Id, Item_name, Replishment) VALUES ('$ItemNo', '$ItemName', '$Reorder')";

    if (mysqli_query($conn, $sql)) {
        // Set success message in session storage
        session_start();
        $_SESSION['notification'] = 'Item added successfully!';
        $_SESSION['notification_type'] = 'success';
        mysqli_close($conn);
        header("Location: AddNewItem.html");
        exit();
    } else {
        // Set error message in session storage
        session_start();
        $_SESSION['notification'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
        $_SESSION['notification_type'] = 'error';
        mysqli_close($conn);
        header("Location: AddNewItem.html");
        exit();
    }
}
?>
