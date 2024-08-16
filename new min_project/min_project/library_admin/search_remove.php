<?php
    include "connection.php";

    if(isset($_POST['submit'])){

      $Book_Name=$_POST['Book_Name'];
      $Book_Id=$_POST['Book_Id'];
      $Category=$_POST['Category'];
      $Year=$_POST['Year'];
      $Author=$_POST['Author'];
      $ISBN=$_POST['ISBN'];
      $Publication=$_POST['Publication'];
      $No_Of_Copies=$_POST['No_Of_Copies'];
      
      //accessing image
      $Book_Image=$_FILES['Book_Image']['name'];

      //accessing image tmp name
      $Temp_Image=$_FILES['Book_Image']['tmp_name'];

      //cheking empty conditon
      if($Book_Name=='' or $Book_Id=='' or $Category=='' or $Year=='' or 
      $Author=='' or $ISBN=='' or $Publication=='' or  $No_Of_Copies='' or
      $Book_Image=='' ){
        echo "<script>alert('Please fill the all the available fields')</script>";
        exit();
      }else{
        move_uploaded_file($Temp_Image,"./bookimage/$Book_Image");

      // insert books
         // $insert_books="insert into `book` (Book_Id,ISBN,Book_Name,Author,Publication,Year,Category,No_Of_Copies,Book_Image) 
          //values('$Book_Id','$Book_Name', '$Author', '$Publication', $Year, '$Category', $No_Of_Copies, '$Book_Image')";
         //$result_query=mysqli_query($conn,$insert_books);
         // if($result_query){
         //   echo "<script>alert('Successfully inserted the book')</script>";
         // }

      
     $insert_books = "INSERT INTO `book` (Book_Id, ISBN, Book_Name, Author, Publication, Year, Category, No_Of_Copies, Book_Image) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_books);
        $stmt->bind_param("isssssiss", $Book_Id, $ISBN, $Book_Name, $Author, $Publication, $Year, $Category, $No_Of_Copies, $Book_Image);
        $stmt->execute();
      }


    }

    


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>INS DASHBOARD</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
    .btn {
      display: inline-block;
      padding: 10px 20px;
      font-size: 16px;
      text-align: center;
      text-decoration: none;
      color: #fff;
      background-color: #007bff; /* Default button color */
      border-radius: 5px;
      margin: 5px;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #013E35; /* Darker shade on hover */
    }

    .btn-edit {
      background-color: #28a745; /* Green color for edit button */
    }

    .btn-remove {
      background-color: #dc3545; /* Red color for remove button */
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
    <h2>Add Books</h2>
    <br><br>
  <form class="my-form" action="" method="post" enctype ="multipart/form-data">
    <input type="text" name="Book_Name" placeholder="Book Name" required="required">
    <br>
    <input type="text" name="Book_Id" placeholder="Book ID" required="required">
    <br>
    <select  name="Category" placeholder="Category" required="required">
        <option value="">Category</option>
        <?php 
              $selecet_query="Select * from `categories`";
              $result_query=mysqli_query($conn,$selecet_query);
              while($row=mysqli_fetch_assoc($result_query)){
                $category_title=$row['category_title'];
                $category_id=$row['category_id'];
                echo "<option value='$category_id'>$category_title</option>";
              }
        
        
        ?>
          
      	
    </select>
    <br>
      <input type="text" name="Year" placeholder="Year">
      <br>
      <input type="text" name="Author" placeholder="Author" required="required">
      <br>
      <input type="text" name="ISBN" placeholder="ISBN">
      <br>
      <input type="text" name="Publication" placeholder="Publication">
      <br>
      <select name="Status" placeholder="Status" required="required">
        <option value="">Status</option>
        <option value="Library Use Only">Library Use Only</option>
        <option value="Borrow">Borrow</option>
      </select>
      <br>
      <input type="file" name="Book_Image" placeholder="image">
      <button type="submit" name="submit">Add</button>
  </form>
  
</div>
<br><br><br>



<div class="form-container">
    <h2>Recently Added</h2>
    <br><br>
</div>
<div class="search-bar">
    <form action="search_remove.php" method="get">
        <input type="text" placeholder="  Quick Search .. Book Name" name="search">
        <button type="submit" name="search_book"><i class="fas fa-search"></i></button>
        <!--<input type="submit" value="Search" name="search_book">-->
        </from>
    </div>
            



<table class="my-table">
    
  <thead>
    Recently Added
    <tr>
      <th>Book Name</th>
      <th>Book Id</th>
      <th>Author</th>
      <th>ISBN</th>
      <th>Category</th>
      <th>Year</th>
      <th>Remove</th>
    </tr>
  </thead>
  <tbody>
  <tr>
  <?php
  if (isset($_GET['search_book'])) {
    $search_book_name = $_GET['search'];
    
    // Perform a SQL JOIN to get category titles
    $search_query = "SELECT b.Book_Name, b.Book_Id, b.Author, b.ISBN, c.category_title, b.Year
                     FROM `book` b
                     JOIN `categories` c ON b.Category = c.category_id
                     WHERE b.Book_Name LIKE '%$search_book_name%'";
    
    $result_query = mysqli_query($conn, $search_query);
    $num_of_rows = mysqli_num_rows($result_query);
    if ($num_of_rows == 0) {
        echo "<h2 class='text-center text-danger'>No result match.</h2>";
    }

    while ($row = mysqli_fetch_assoc($result_query)) {
        echo "<tr>
              <td>{$row['Book_Name']}</td>
              <td>{$row['Book_Id']}</td>
              <td>{$row['Author']}</td>
              <td>{$row['ISBN']}</td>
              <td>{$row['category_title']}</td>
              <td>{$row['Year']}</td>
              <td>
                  <a class='btn btn-edit' href='editbook.php?id={$row['Book_Id']}'>Edit</a>
                  <a class='btn btn-remove' href='deletebook.php?id={$row['Book_Id']}'onclick='return confirm(\"Are you sure you want to remove this book?\")'>Remove</a>
              </td>
          </tr>";
    }
  }
?>

   
  </tbody>
</table>



   <section></section>
  </body>
</html>
