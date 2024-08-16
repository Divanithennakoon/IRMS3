<?php
if (isset($_GET['data'])) {
    $data = $_GET['data'];
    
    // Connect to the database
    $conn = new mysqli("hostname", "username", "password", "database");
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Query the database using the data from the QR code
    $sql = "SELECT * FROM books WHERE qr_code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $data);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Display the results
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "Book Name: " . $row["Book_Name"] . "<br>";
            echo "Author: " . $row["Author"] . "<br>";
            // Display other relevant information
        }
    } else {
        echo "No results found.";
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "No data received.";
}
?>
