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
$SectionName = trim(filter_input(INPUT_POST, "SectionName", FILTER_SANITIZE_STRING));
$Qty = trim(filter_input(INPUT_POST, "Quantity", FILTER_SANITIZE_NUMBER_INT));
$Date = trim(filter_input(INPUT_POST, "date"));

// Fetch item_id based on item_name
$sql = "SELECT item_Id, CurrentBalance, Replishment FROM item WHERE item_name = '$ItemName'";
$result = mysqli_query($conn, $sql);

// Fetch section_id based on section_name
$sql2 = "SELECT Section_Id FROM section WHERE Section_Name = '$SectionName'";
$result2 = mysqli_query($conn, $sql2);

if ($result && $result2) {
    if (mysqli_num_rows($result) == 1 && mysqli_num_rows($result2) == 1) {
        // Retrieve item_id and section_id
        $row = mysqli_fetch_assoc($result);
        $ItemNo = $row['item_Id'];
        $CurrentBalance = $row['CurrentBalance'];
        $Replishment = $row['Replishment'];

        $row2 = mysqli_fetch_assoc($result2);
        $SectionId = $row2['Section_Id'];

        if ($CurrentBalance < $Qty) {
            echo "Required quantity is more than current stock";
            die("Query failed: Insufficient stock");
        } else {
            // Insert into issued_item table
            $sql3 = "INSERT INTO issued_item (Section_Id, Item_Id, Quantity, Date) VALUES ('$SectionId', '$ItemNo', $Qty, '$Date')";
            if (mysqli_query($conn, $sql3)) {

                // Update current balance in item table
                $newCurrentBalance = $CurrentBalance - $Qty;
                $sql4 = "UPDATE item SET CurrentBalance = $newCurrentBalance WHERE item_Id = '$ItemNo'";
                if (mysqli_query($conn, $sql4)) {

                    // Check and update reorder level if necessary
                    if ($newCurrentBalance < $Replishment) {
                        $sql5 = "UPDATE item SET ReorderNeeded = 1 WHERE item_Id = '$ItemNo'";
                        mysqli_query($conn, $sql5);
                    }

                    // Redirect to success page after successful issue
                    header("Location: Issue.php");
                    exit;
                } else {
                    // Handle update query error
                    die("Error updating current balance: " . mysqli_error($conn));
                }
            } else {
                // Handle insert query error
                die("Error issuing item: " . mysqli_error($conn));
            }
        }
    } else {
        // Handle no or multiple rows found for item or section
        die("Item or Section not found or ambiguous result.");
    }
} else {
    // Handle query execution error
    die("Query execution error: " . mysqli_error($conn));
}

// Close connection
mysqli_close($conn);
?>
