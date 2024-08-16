<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="Style_FileTracking.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
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

  <!-- Search bar -->
  <div class="search-bar">
    <header>Update Docket Details</header>
  </div>

  <!-- Profile -->
  <div class="profile">
    <div class="dropdown">
      <header class="dropbtn">My Profile</header>
      <div class="dropdown-content">
        <a href="#">Settings</a>
        <a href="#">Logout</a>
        <a href="#">Profile</a>
      </div>
    </div>
  </div>

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
            echo "<option value=''>Select the Docket Number for Dispose</option>";
            
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
          
          <button  type="submit">Search</button>  
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
      <div class="form-container">
        <form class="my-form" action="Deleteprocess.php" method="post">
            
          <div class="form-group">
            <label for="docket">Docket NO</label>
            <input type="number" id="docket" name="docket" value="<?php echo $row1['Docket_No']; ?>" disabled>
          </div>
          <br>
          <div class="form-group">
            <label for="capacity">Capacity</label>
            <input type="number" id="capacity" name="capacity" value="<?php echo $row1['Size']; ?>" disabled>
          </div>
          <br>
          <div class="form-group">
            <label for="cupboardno">Cupboard NO</label>
            <input type="number" id="cupboardno" name="cupboardno" value="<?php echo $row1['Cupboard_No']; ?>" disabled>
          </div>
          <br />
          <div class="form-group">
            <label for="rackno">Rack NO</label>
            <input type="number" id="rackno" name="rackno" value="<?php echo $row1['Rack_No']; ?>" disabled>
          </div>
          <br />
          <br>
          <div class="button-group">
            <button type="submit">Delete</button>
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

</body>
</html>
