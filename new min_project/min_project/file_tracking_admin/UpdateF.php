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
      padding: 15px;
      background-color: #4CAF50;
      color: white;
      z-index: 9999;
      display: none; /* Initially hidden */
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
    <header>Update File Details</header>
  </div>
<br>
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

          // SQL query to retrieve file IDs
          $sql = "SELECT File_Id FROM file";
          $result = mysqli_query($conn, $sql);

          // Output the select element with options
          echo "<select name='FileId' id='FileId' >";
          echo "<option value=''>Select a File Id</option>";

          // Check if there are results
          if ($result->num_rows > 0) {
              // Loop through each row in the result set
              while ($row = $result->fetch_assoc()) {
                  // Output an option element for each file ID
                  echo "<option value='" . $row['File_Id'] . "'>" . $row['File_Id'] . "</option>";
              }
          } else {
              // Output a message if there are no results
              echo "<option value=''>No file IDs found</option>";
          }

          echo "</select>";

          // Close the database connection
          $conn->close();
        ?>

        <button type="submit">Search</button>  
      </div>
    </form>
  </div>

  <!-- Notification div -->
  <div id="notification" class="notification"></div>

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

      $FID = filter_input(INPUT_POST, "FileId");

      $sql1 = "SELECT * FROM file WHERE File_Id = '$FID'";

      $result1 = mysqli_query($conn, $sql1);

      if ($result1->num_rows > 0) {
          $row1 = $result1->fetch_assoc();
  ?>
      <div class="form-container1">
        <form class="my-form" action="UpdateFile.php" method="post" id="updateForm">
          <div class="form-group">
            <input type="hidden" name="FID" value="<?php echo $FID; ?>"> 
            <label for="fileNo">File NO</label>
            <input type="text" id="fileNo" name="fileNo" value="<?php echo $row1['File_Id']?>";>
          </div>
          <br />
          <div class="form-group">
            <label for="fileName">File Name</label>
            <input type="text" id="fileName" name="fileName" value="<?php echo $row1['File_Name']?>";>
          </div>
          <br />
          <div class="form-group">
            <label for="minit">Number Of Minit Sheets</label>
            <input type="number" id="minit" name="minit" value="<?php echo $row1['No_Of_MinitSheets']?>"; min="0" required >
          </div>
          <br />
          <div class="form-group">
            <label for="year">File Opened Year</label>
            <input type="number" id="year" name="year" value="<?php echo $row1['Year']?>"; max="2155" required>
          </div>
          <br />
          <div class="form-group">
            <label for="cupboardno">Cupboard NO</label>
            <input type="number" id="cupboardno" name="cupboardno" value="<?php echo $row1['Cupboard_No']?>";>
          </div>
          <br />
          <div class="form-group">
            <label for="rackno">Rack NO</label>
            <input type="number" id="rackno" name="rackno" value="<?php echo $row1['Rack_No']?>";>
          </div>
          <br />
          <div class="form-group">
            <label for="docketno">Docket NO</label>
            <input type="number" id="docketno" name="docketno" value="<?php echo $row1['Docket_No']?>";>
          </div>    
          <br />
          <div class="button-group">
            <button type="submit" id="btn-add">Update</button>
          </div>
        </form>
      </div>
  <?php
      } else {
          echo "<div class='form-container'>No data found for the selected file number.</div>";
      }

      // Close the database connection
      $conn->close();
  }
  ?>

  <!-- JavaScript for handling form submission and JSON response -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Submit form using AJAX
      document.getElementById('updateForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent normal form submission
        var form = this;
        var formData = new FormData(form);

        // Send AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'UpdateFile.php', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); // Let server know this is an AJAX request

        xhr.onload = function() {
          if (xhr.status === 200) {
            try {
              var response = JSON.parse(xhr.responseText);
              if (response.success) {
                // Show notification
                var notification = document.getElementById('notification');
                notification.innerHTML = response.message;
                notification.style.display = 'block';
              } else {
                alert(response.message); // Show error message if update failed
              }
            } catch (e) {
              alert('Error parsing JSON response'); // Show error if JSON parsing fails
            }
          } else {
            alert('Request failed. Status: ' + xhr.status); // Show error if request fails
          }
        };

        xhr.onerror = function() {
          alert('Request failed. Check your internet connection.'); // Show error if request fails
        };

        xhr.send(formData); // Send form data
      });
    });
  </script>

</body>
</html>
