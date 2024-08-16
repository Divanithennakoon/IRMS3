<?php
session_start();
if (!isset($_SESSION['nic'])) {
    header("Location: login.html");
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "min_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the NIC is set in the session
if (isset($_SESSION['nic'])) {
    $nic = $_SESSION['nic'];

    // Query to get the username
    $sql = "SELECT username FROM user WHERE nic = '$nic'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result === false) {
        die("Error in query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
    } else {
        echo "User not found!";
    }

    // Query to count the total files
    $fileCountSql = "SELECT COUNT(*) as total_files FROM file";
    $fileCountResult = $conn->query($fileCountSql);
    $fileCount = $fileCountResult->fetch_assoc()['total_files'];

    // Query to count the total dockets
    $docketCountSql = "SELECT COUNT(*) as total_dockets FROM docket";
    $docketCountResult = $conn->query($docketCountSql);
    $docketCount = $docketCountResult->fetch_assoc()['total_dockets'];
} else {
    header("Location: login.php"); // Redirect to the login page if NIC is not set
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="Style_FileTracking.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <style>
    body {
        font-family: 'poppins', sans-serif;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
    }

    .welcome-message {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    .stats-container {
        display: flex;
        justify-content: center;
    }

    .stats-box {
        background-color: #e0e0e0;
        border: 2px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        margin: 10px;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        color: #333;
        width: 300px;
    }
  </style> 
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <header>Admin Panel</header>
    <ul>
      <li><a href="admin.php">Admin</a></li>
      <li><a href="index-main.html">Add File</a></li>
      <li><a href="index-AddDocket.html">Add New Docket</a></li>
      <li><a href="Search.html">Search File</a></li>
      <li><a href="UpdateD.php">Update Docket</a></li>
       <li><a href="UpdateF.php">Update File</a></li>
    </ul>
  </div>

  <div class="welcome-message">
    <h2>FILE TRACKINH SYSTEM</h2> <br><br>
    <h2>Welcome Admin <?php echo $username; ?></h2>
  </div>

  <br><br><br><br>

  <div class="stats-container">
    <div class="stats-box">
      Our Total Files Count is <?php echo $fileCount; ?>
    </div>
    <div class="stats-box">
     Our Total Dockets Count is <?php echo $docketCount; ?>
    </div>
  </div>

</body>
</html>
