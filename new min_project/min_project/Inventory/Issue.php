<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="StyleSheet.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <style >
    .form-container {
      border: 2px solid #ccc;
      padding: 30px;
      border-radius: 8px;
      max-width: 600px;
      margin: 20px auto;
      background-color: #f9f9f9;
    }
  </style>

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
<br><br><br>
  <!-- Search bar -->
  <div class="search-bar">
    <header>Issue Items</header>
  </div>

  <br><br>
  <!-- Form -->
  <div class="form-container">
    <form class="my-form" action="IssueProcess.php" method="post">
      <div class="form-group">
        <label for="ItemName">Item Name</label>
        <select id="ItemName" name="ItemName" required>
          <option value=""> Select </option>
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
            $result = $conn->query($sql);

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
      </div>
      <br />

      <div class="form-group">
        <label for="SectionName">Section</label>
        <select id="SectionName" name="SectionName" required>
          <option value=""> Select </option>
          <?php
            // Re-establishing database connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to fetch section names from database
            $sql = "SELECT Section_Name FROM section";
            $result = $conn->query($sql);

            // Generate options based on database query results
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["Section_Name"] . '">' . $row["Section_Name"] . '</option>';
              }
            } else {
              echo '<option value="">No sections found</option>';
            }

            // Close database connection
            $conn->close();
          ?>
        </select>
      </div>
      <br />

      <div class="form-group">
        <label for="Quantity">Quantity</label>
        <input type="number" id="Quantity" name="Quantity" placeholder=" " min="0" required>
      </div>
      <br />

      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" placeholder=" " required>
      </div>
      <br />

      <div class="button-group">
        <button type="submit" id="btn-add">Issue</button>
        <button type="reset" id="btn-clear">Clear</button>
      </div>
    </form>
  </div>

  <section></section>
</body>
</html>
