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
  !-- Search bar -->
  <div class="search-bar">
    <header>Add New Section</header>
  </div>

  
<br><br>
  <!-- Form -->
  <div class="form-container">
    <form class="my-form" action="" method="post">
      <div class="form-group">
        <label for="SectionNo">Section No</label>
        <input type="text" id="SectionNo" name="SectionNo" placeholder=" " required>
      </div>
      <br />
      <div class="form-group">
        <label for="SectionName">Section Name</label>
        <input type="text" id="SectionName" name="SectionName" placeholder=" " required>
      </div>
      <br />
      <div class="button-group">
        <button type="submit" id="btn-add">Add</button>
        <button type="reset" id="btn-clear">Clear</button>
      </div>
    </form>
  </div>

  <section></section>
  
  <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
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
        
        // Sanitize inputs
        $SectionId = trim(filter_input(INPUT_POST, "SectionNo", FILTER_SANITIZE_STRING));
        $sectionName = trim(filter_input(INPUT_POST, "SectionName", FILTER_SANITIZE_STRING));
        
        // Prepare SQL query
        $sql = "INSERT INTO section (Section_Id, section_Name) VALUES ('$SectionId', '$sectionName')";
        
        // Execute query
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location: AddNewSection.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            mysqli_close($conn);
        }         
    }
  ?>
  
</body>
</html>
