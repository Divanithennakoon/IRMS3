<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="Style_FileTracking.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <style>
    .form-container1 {
      border: 2px solid #ccc;
      padding: 30px;
      border-radius: 8px;
      max-width: 600px;
      margin: 20px auto;
      background-color: #f9f9f9;
    }
    .notification {
      position: fixed;
      top: 10px;
      right: 10px;
      padding: 10px;
      border-radius: 5px;
      font-weight: bold;
      display: none;
    }
    .success {
      background-color: #4CAF50;
      color: white;
    }
    .error {
      background-color: #f44336;
      color: white;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <header>Admin Panel</header>
    <ul>
      <li><a href="admin.php">Admin </a></li>
      <li><a href="index-main.html">Add File</a></li>
      <li><a href="index-AddDocket.html">Add New Docket</a></li>
      <li><a href="Search.html">Search File</a></li>
      <li><a href="UpdateD.php">Update Docket</a></li>
       <li><a href="UpdateF.php">Update File</a></li>
       <!-- <li><a href="DeleteDocket.php">Dispose Docket</a></li> -->
    </ul>
  </div>
<br><br><br>
  <!-- Search bar -->
  <div class="search-bar">
    <header>Update Docket Details</header>
  </div>
<br>
  <!-- Profile -->
  

  <!-- Form -->
  <div class="form-container" id="doc">
    <form class="my-form" action="#" method="post" id="form-center">
      <div class="form-group2">
        <?php
            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "min_project";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // SQL query to retrieve docket numbers
            $sql = "SELECT Docket_No FROM docket";
            $result = mysqli_query($conn,$sql);

            // Output the select element with options
            echo "<select name='docket' id='docket' >";
            echo "<option value=''>Select a Docket Number</option>";
            
            // Check if there are results
            if ($result->num_rows > 0) {
                // Loop through each row in the result set
                while ($row = $result->fetch_assoc()) {
                    // Output an option element for each docket number
                    echo "<option value='" . $row['Docket_No'] . "'>" . $row['Docket_No'] . "</option>";
                }
            } else {
                // Output a message if there are no results
                echo "<option value=''>No docket numbers found</option>";
            }
            
            echo "</select>";

        ?>
        <button type="submit">Search</button>  
      </div>
    </form>
  </div>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Database connection parameters
      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "min_project";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $database);

      // Check connection
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      $DNo = filter_input(INPUT_POST, "docket");

      $sql1 = "SELECT * FROM docket WHERE Docket_No = '$DNo'";

      $result1 = mysqli_query($conn, $sql1);

      if ($result1->num_rows > 0) {
          $row1 = $result1->fetch_assoc();
  ?>
      <div class="form-container1">
        <form class="my-form" action="UpdateDocket.php" method="post">            
            <input type="hidden" name="DNo" value="<?php echo $DNo; ?>">
            
          <div class="form-group">
            <label for="docket">Docket NO</label>
            <input type="number" id="docket" name="docket" value="<?php echo $row1['Docket_No']; ?>" disabled>
          </div>
          <br>
          <div class="form-group">
            <label for="capacity">Capacity</label>
            <input type="number" id="capacity" name="capacity" value="<?php echo $row1['Size']; ?>">
          </div>
          <br>
          <div class="form-group">
            <label for="cupboardno">Cupboard NO</label>
            <input type="number" id="cupboardno" name="cupboardno" value="<?php echo $row1['Cupboard_No']; ?>">
          </div>
          <br />
          <div class="form-group">
            <label for="rackno">Rack NO</label>
            <input type="number" id="rackno" name="rackno" value="<?php echo $row1['Rack_No']; ?>">
          </div>
          <br />
          <br>
          <div class="button-group">
            <button type="submit">Update</button>
          </div>
        </form>
      </div>
  <?php
      } else {
          echo "<div class='form-container'>No data found for the selected docket number.</div>";
      }

      // Close the database connection
      $conn->close();
  }
  ?>

  <!-- Notification Element -->
  <div id="notification" class="notification"></div>

  <!-- JavaScript for Notification -->
  <script>
    // Function to display notification
    function showNotification(message, type) {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.className = 'notification ' + type; // Add class for styling (e.g., success or error)
      notification.style.display = 'block';

      // Hide notification after 3 seconds
      setTimeout(function() {
        notification.style.display = 'none';
      }, 3000); // 3000 milliseconds = 3 seconds
    }

    // Check for URL parameters to show notification
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const message = urlParams.get('message');

    if (status && message) {
      showNotification(message, status);
    }
  </script>
</body>
</html>
