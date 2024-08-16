<?php
include "connection.php";

if (isset($_POST['submit'])) {
  $category_title = $_POST['Book_Id'];

  // Select data from database
  $select_query = "SELECT * FROM `categories` WHERE category_title='$category_title'";
  $result_select = mysqli_query($conn, $select_query);
  $number = mysqli_num_rows($result_select);
  if ($number > 0) {
    echo "<script>alert('This category is present inside the database')</script>";
  } else {
    $insert_query = "INSERT INTO `categories` (category_title) VALUES ('$category_title')";
    $result = mysqli_query($conn, $insert_query);
    if ($result) {
      echo "<script>alert('Category has been inserted successfully')</script>";
    }
  }
  header("location:catagory.php"); // Redirect after updating
      exit;
}

$query = "SELECT * FROM `categories`";
$result1 = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <style>
    /* Style for the remove button */
    .remove-button {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      text-align: center;
      text-decoration: none;
      color: #fff;
      background-color: #dc3545; /* Red color for remove button */
      border: none;
      border-radius: 5px;
      margin: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .remove-button {
      background-color: #dc3545; /* Darker shade on hover */
    }
    .remove-button:hover {
      background-color: #013E35; /* Darker shade on hover */
    }
    .btn-edit {
      background-color: #28a745; /* Green color for edit button */
    }

    .my-form button {
  width: 100px;
  height: 35px;
  padding: 5px 5px;
  background-color: #01A58D;
  color: white;
  border: none;
  border-radius: 15px;
  cursor: pointer;
}

.my-form button:hover {
  background-color: #005246;
}
  </style>
</head>
<body>
  <div class="sidebar">
    <header>Admin Panel</header>
    <ul>
      <li><a href="managebook.php">Manage Books</a></li>
      <li><a href="catagory.php">Manage Category</a></li>
      <li><a href="requestedbook.php">Requested Books</a></li>
      <li><a href="issuedbook.php">Issued Books</a></li>
      <li><a href="returnedbook.php">Returned Books</a></li>
      
    </ul>
  </div>

  <div class="form-container">
    <br>
    <h2>Add Category</h2>
    <br><br>
    <form class="my-form" action="" method="post" onsubmit='return confirmRequest()'>
      <input type="text" name="Book_Id" placeholder="Category" required>
      <br>
      <button type="submit" name="submit">Add</button>
    </form>

    <script>
          function confirmRequest() {
            return confirm('Are you sure you want to Add this category?');
           }
     </script>
   
  </div>
  <br><br><br>

  <div class="form-container1">
    <h2>Remove Category</h2>
    <br><br>
  </div>

  <table class="my-table">
    <thead>
      <tr>
        <th>Category Id</th>
        <th>Category</th>
        <th>Edit/Remove</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row = mysqli_fetch_assoc($result1)) {
        echo "<tr>
                <td>{$row['category_id']}</td>
                <td>{$row['category_title']}</td>
                <td> 
                <a class='btn btn-edit' href='editcategory.php?id={$row['category_id']}'>Edit</a>        
                <a class='btn btn-remove' href='deletecategory.php?id={$row['category_id']}' onclick='return confirm(\"Are you sure you want to remove this category?\")'>Remove</a>
              </tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>
