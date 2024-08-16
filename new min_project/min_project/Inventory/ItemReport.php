<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="StyleSheet.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <header>Admin Panel</header>
    <ul>
      <li><a href="admin_I.php">Admin</a></li>
      <li><a href="AddNewItem.html">Add New Item</a></li>
      <li><a href="AddNewSection.php">Add New Section</a></li>
      <li><a href="Purchase.php">Purchased Item</a></li>
      <li><a href="Issue.php">Issue Item</a></li>
      <li><a href="ItemReport.php">Stock Balance</a></li>
    </ul>
  </div>

  <!-- Search bar --><br><br><br>
  <div class="search-bar">
    <header>Item Balance Report</header>
  </div>

  
<br><br>
  <!-- Form -->
  <div class="form-container">
    <form class="search-form" method="post" action="ReportProcess.php">
      <div class="form-group2">
        <select id="ItemName" name="ItemName" style="width: 300px;">
          <option value="Item Name"> Select </option>
          <option value="All"> All </option>
          <option value="ReorderNeeded"> Reorder Needed </option>
          <?php
            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "min_project";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }
            
            // SQL query to fetch item names from database
            $sql = "SELECT Item_Name FROM item";
            $result = mysqli_query($conn, $sql);

            // Generate options based on database query results
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["Item_Name"] . '">' . $row["Item_Name"] . '</option>';
              }
            } else {
              echo '<option value="">No items found</option>';
            }
            
            // Close database connection
            $conn->close();
          ?>
        </select>
        <input type="submit" id="btnsearch" name="btnsearch" value="Search">   
      </div>
    </form>
  </div>

  <section></section>
</body>
</html>
