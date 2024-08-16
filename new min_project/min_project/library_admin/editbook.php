<?php
    include "connection.php";

    if($_SERVER["REQUEST_METHOD"]=='GET'){
        if(!isset($_GET['id'])){
            header("location:managebook.php");
            exit;
        }
        $id = $_GET['id'];
        $sql = "SELECT * FROM `book` WHERE Book_ID=$id";
        $result = $conn->query($sql);
        $row =$result->fetch_assoc();

      $Book_Name=$row['Book_Name'];
      $Book_Id=$row['Book_Id'];
      $Category=$row['Category'];
      $Year=$row['Year'];
      $Author=$row['Author'];
      $ISBN=$row['ISBN'];
      $Publication=$row['Publication'];
      $Status=$row['Status'];
    }

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {

      if (isset($_GET['id'])) 
        $id = $_GET['id'];
      
      $newCategory = $_POST['Category'];
      $newStatus = $_POST['Status'];
  
      $update_sql = "UPDATE `book` SET Category='$newCategory', Status='$newStatus' WHERE Book_ID=$id";
      $conn->query($update_sql);
  
      header("location:managebook.php"); // Redirect after updating
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
    <h2>Edit Books</h2>
    <br><br>
  <form class="my-form" action="" method="post" enctype ="multipart/form-data">

    
   
    <input type="text" name="Book_Name" value="<?php echo $Book_Name; ?>" readonly>
    <label>:Book Name </label>
    <br>
    
    <input type="text" name="Book_Id" value="<?php echo $Book_Id; ?>" readonly>
    <label>:Book ID </label>
    <br>
    
    <select  name="Category"  >
        <option value=""><?php 
            $selecet_query = "SELECT * FROM `categories`";
            $result_query = mysqli_query($conn, $selecet_query);
            while ($row = mysqli_fetch_assoc($result_query)) {
                $category_title = $row['category_title'];
                $category_id = $row['category_id'];
                $selected = ($category_id == $Category) ? 'selected' : '';
                echo "<option value='$category_id' $selected>$category_title</option>";
            }
            ?></option>
        <?php 
              $selecet_query="SELECT * from `categories`";
              $result_query=mysqli_query($conn,$selecet_query);
              while($row=mysqli_fetch_assoc($result_query)){
                $category_title=$row['category_title'];
                $category_id=$row['category_id'];
                echo "<option value='$category_id'>$category_title</option>";
              }
        
        
        ?>
          
      	
    </select>
    <label>:Category </label>
    <br>
   
    <input type="text"  name="Year" value="<?php echo $Year; ?>"readonly>
    <label>:Year </label>
    
    <br>
    
    <input type="text"  name="Author" value="<?php echo $Author; ?>" readonly>
    <label>:Author </label>
    <br>
    
    <input type="text"  name="ISBN" value="<?php echo $ISBN; ?>"readonly>
    <label>:ISBN </label>
    <br>
    
    <input type="text"  name="Publication" value="<?php echo $Publication; ?>"readonly>
    <label>:Publication </label>
    <br>
    
    <select  name="Status"  >
    <option value="<?php echo $Status; ?>"><?php echo $Status; ?></option>  
    <option value="Library Use Only">Library Use Only</option>
    <option value="Borrow">Borrow</option>
    </select>
        
    <label>:Status </label>
    <br>
    <!--<label>Book Image: </label>
    <input type="file" name="Book_Image" value="<?php echo $Book_Image; ?>">-->
    <br>
    <div>
    <button type="submit" name="submit" onclick="return confirmUpdate()">Update</button>
    </div>

    <script>
    function confirmUpdate() {
        return confirm("Are you sure you want to update this information?");
    }
    </script>

    
  </form>
  
  
</div>


  </body>
</html>