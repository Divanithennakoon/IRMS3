<?php
    include "connection.php";

    if($_SERVER["REQUEST_METHOD"]=='GET'){
        if(!isset($_GET['id'])){
            header("location:managebook.php");
            exit;
        }
        $id = $_GET['id'];
        $sql = "SELECT category_id,category_title FROM `categories` WHERE category_id=$id";
        $result = $conn->query($sql);
        $row =$result->fetch_assoc();

        $category_id=$row['category_id'];
        $category_title=$row['category_title'];
    }

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {

      if (isset($_GET['id'])) 
        $id = $_GET['id'];
      
      $newCategory = $_POST['Category'];
     
  
      $update_sql = "UPDATE `categories` SET Category_title='$newCategory' WHERE category_id=$id";
      $conn->query($update_sql);
  
      header("location:catagory.php"); // Redirect after updating
      exit;
  }
    
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>INS DASHBOARD</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  
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
    <form class="my-form" action="editcategory.php?id=<?php echo $id; ?>" method="post">
      <input type="text" name="Category" value="<?php echo $category_title; ?>"  >
      <br>
      <button type="submit" name="submit" onclick="return confirmUpdate()">Update</button>

      <script>
    function confirmUpdate() {
        return confirm("Are you sure you want to update this Category?");
    }
    </script>
    </form>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
  </div>
  <br><br><br>
