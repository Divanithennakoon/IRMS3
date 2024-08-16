<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="StyleSheet.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

  <style>
    .form-container {
      border: 2px solid #ccc;
      padding: 30px;
      border-radius: 8px;
      max-width: 600px;
      margin: 20px auto;
      background-color: #f9f9f9;
    }

    .report-container {
      border: 2px solid #ccc;
      padding: 20px;
      border-radius: 8px;
      max-width: 80%;
      margin: 20px auto;
      background-color: #f1f1f1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 15px;
      text-align: center;
    }

    th {
      background-color: #005246;
      color: white;
    }

  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <header>Admin Panel</header>
    <ul>
      <li><a href="AddNewItem.html">Add New Item</a></li>
      <li><a href="AddNewSection.php">Add New Section</a></li>
      <li><a href="Purchase.php">Purchased Item</a></li>
      <li><a href="Issue.php">Issue Item</a></li>
      <li><a href="ItemReport.php">Stock Balance</a></li>
    </ul>
  </div>
  <br>

  <!-- Report Body -->
  <div class="reportBody">
    <div class="search-bar">
      <header>Item Report</header>
    </div>

    <br>

    <div class="report-container">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
      $SelectedItem = trim(filter_input(INPUT_POST, "ItemName"));

      // Display search results header
      echo "<p style='font-size: 30px; text-align: center; margin: 0;'>Item Balance Report Of <i style='font-weight:bold;'>$SelectedItem</i> </p><br /><br />";

      // Display table header
      echo "<table> 
            <tr>
              <th>Item Id</th>
              <th>Item Name</th>
              <th>Current Balance</th>
              <th>Replishment</th>
              <th>Reorder Needed</th>
              <th>Open Balance</th>
            </tr>";

      // SQL query based on user selection
      if ($SelectedItem == "All") {
        $sql = "SELECT * FROM item";
      } elseif ($SelectedItem == "ReorderNeeded") {
        $sql = "SELECT * FROM item WHERE ReorderNeeded = 1";
      } else {
        $sql = "SELECT * FROM item WHERE Item_name='$SelectedItem'";
      }

      // Execute query
      $result = mysqli_query($conn, $sql);

      // Display results
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $reorder = $row["ReorderNeeded"] == 0 ? "No" : "Yes";
          echo "<tr>
                  <td>" . $row["Item_Id"] . "</td>
                  <td>" . $row["Item_name"] . "</td>
                  <td>" . $row["CurrentBalance"] . "</td>
                  <td>" . $row["Replishment"] . "</td>
                  <td>" . $reorder . "</td>
                  <td>" . $row["Open_Balance"] . "</td>
                </tr>";
        }
      } else {
        echo "<tr><td colspan='6' style='text-align: center;'>No items found</td></tr>";
      }

      echo "</table>";

      // Close connection
      mysqli_close($conn);
    }
    ?>
    </div>

  </div>

</body>
</html>
