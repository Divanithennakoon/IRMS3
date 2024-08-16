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

    $FNo = trim(filter_input(INPUT_POST, "fileNo"));
    $FName = trim(filter_input(INPUT_POST, "fileName"));
    $Minit = trim(filter_input(INPUT_POST, "minit"));
    $Year = trim(filter_input(INPUT_POST, "year"));
    $Cupboard = trim(filter_input(INPUT_POST, "cupboardno"));
    $Rack = trim(filter_input(INPUT_POST, "rackno"));
    $Docket = trim(filter_input(INPUT_POST, "docketno"));

    // Start transaction for ensuring the completeness of activity  
    mysqli_begin_transaction($conn);

    // Check if the docket already exists   
    $sql = "SELECT Cupboard_No, Rack_No FROM docket WHERE Docket_No = $Docket";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($Cupboard != $row["Cupboard_No"] || $Rack != $row["Rack_No"]) {
            $error_message = "Error: The attempt to add the file has failed. Cupboard number or Rack No is mismatch with Docket number.";
            echo "<script>
                    alert('$error_message');
                    window.location.href='index-main.html';
                  </script>";
            mysqli_close($conn);
            exit();
        }
    } else {
        $sql2 = "INSERT INTO docket (Docket_No, Cupboard_No, Rack_No, Status) VALUES ($Docket, $Cupboard, $Rack, 1)";
        mysqli_query($conn, $sql2);     
    }

    $sql1 = "INSERT INTO file (File_Id, File_Name, No_Of_MinitSheets, Year, Cupboard_No, Rack_No, Docket_No) VALUES ('$FNo', '$FName', $Minit, $Year, $Cupboard, $Rack, $Docket)";

 if (mysqli_query($conn, $sql1)) {
        mysqli_commit($conn);
        mysqli_close($conn);
        $success_message = "The file has been added successfully!";
        echo "<script>
                alert('$success_message');
                window.location.href='index-main.html';
              </script>";
        exit();
    } else {
        $error_message = "Error: " . $sql1 . "<br>" . mysqli_error($conn);
        echo "<script>
                alert('$error_message');
                window.location.href='add_file.html';
              </script>";
        mysqli_commit($conn);
        mysqli_close($conn);
    }

    mysqli_query($conn, "UNLOCK TABLES");
}
?>