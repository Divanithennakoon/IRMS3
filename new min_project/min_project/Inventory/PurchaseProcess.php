<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "min_project";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize input data
$ItemName = trim(filter_input(INPUT_POST, "ItemName", FILTER_SANITIZE_STRING));
$Qty = trim(filter_input(INPUT_POST, "Quantity", FILTER_SANITIZE_NUMBER_INT));
$Date = trim(filter_input(INPUT_POST, "date"));

// Fetch item_id and current balance based on item_name
$sql = "SELECT item_Id, CurrentBalance, Replishment FROM item WHERE item_name = '$ItemName'";
$result = mysqli_query($conn, $sql);

if ($result) {
    if (mysqli_num_rows($result) == 1) {
        // Retrieve item_id and current balance
        $row = mysqli_fetch_assoc($result);
        $ItemNo = $row['item_Id'];
        $CurrentBalance = $row['CurrentBalance'];
        $Replishment = $row['Replishment'];

        // Insert into purchased_item table
        $sql2 = "INSERT INTO purchased_item (item_Id, Quantity, Date) VALUES ('$ItemNo', $Qty, '$Date')";
        if (mysqli_query($conn, $sql2)) {
            
            // Update current balance
            $newQty = $CurrentBalance + $Qty;
            $sql3 = "UPDATE item SET CurrentBalance = $newQty WHERE item_Id = '$ItemNo'";
            if (mysqli_query($conn, $sql3)) {
                
                // Check and update ReorderNeeded status
                if ($newQty > $Replishment) {
                    $sql4 = "UPDATE item SET ReorderNeeded = 0 WHERE item_Id = '$ItemNo'";
                    mysqli_query($conn, $sql4);
                }
                
                // Redirect to success page
                header("Location: Purchase.php");
                exit;
            } else {
                // Handle update error
                die("Error updating current balance: " . mysqli_error($conn));
            }
        } else {
            // Handle insert error
            die("Error inserting purchased item: " . mysqli_error($conn));
        }
    } else {
        // Handle no or multiple rows found
        die("Item not found or ambiguous result.");
    }
} else {
    // Handle query error
    die("Query failed: " . mysqli_error($conn));
}

// Close connection
mysqli_close($conn);
?>
