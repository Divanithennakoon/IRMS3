<?php
    // Database configuration
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

    // Trim whitespace from the search keyword
    $keyword = trim(filter_input(INPUT_POST, "search"));

    // SQL query to fetch data
    $sql = "SELECT Record_Room_No, File_Name, File_Id, Cupboard_No, Rack_No, Docket_No, Position_at_Docket 
            FROM file 
            WHERE Record_Room_No LIKE '%$keyword%' 
               OR File_Name LIKE '%$keyword%' 
               OR Cupboard_No LIKE '%$keyword%' 
               OR File_Id LIKE '%$keyword%' 
               OR Rack_No LIKE '%$keyword%' 
               OR Docket_No LIKE '%$keyword%' 
               OR Year LIKE '%$keyword%'";

    // Execute query
    $result = mysqli_query($conn, $sql);

    // Prepare results in an array
    $rows = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    // Close connection
    mysqli_close($conn);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($rows);
?>
