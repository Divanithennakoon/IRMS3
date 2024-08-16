<?php
    include "connection.php";
    include "commen_function.php";

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home Page</title>
    <link rel="stylesheet" href="styles.css">
    <!--<script src="user.js" defer></script>-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<nav class="navbar">
    <div class="left">
        <a href="all_books.php" class="navbar-link">All Books</a>
        <a href="userequest.php" class="navbar-link">Requested Books</a>
        <a href="userborrow.php" class="navbar-link">Borrowed Books</a>
        <a href="userreturn.php" class="navbar-link">Returned Books</a>
    </div>
    <div class="middle">
        <form action="search_books.php" method="get">
            <input type="search" placeholder="Search Books..." aria-label="Search" class="search-bar" name="search_books">
            <input type="submit" value="Search" name="search_book_data">
        </form>
    </div>
    
</nav>

<div class="content">
    <div class="left-content">
        <p class="greeting">WHENEVER YOU'RE READY</p>
        <p class="description">Discover your favorite books.</p>
    </div>

    <div class="right-content" >
    <select  name="Category" placeholder="Category" >
        <option value="">Category</option>
        <?php 
              $selecet_query="Select * from `categories`";
              $result_query=mysqli_query($conn,$selecet_query);
              while($row=mysqli_fetch_assoc($result_query)){
                $category_title=$row['category_title'];
                //$category_id=$row['category_id'];
                echo "<option value=''>$category_title</option>";
              }
        
        
        ?>
          
      	
    </select>
    
    <button type="submit" name="catsearch">Search </button>
    </div>
  </div>

<div class="container">
    
        <?php 
        //calling function
            search_books();
            get_unique_categories();
        
        ?>
           <!-- <div class="product" data-name="p-1">
                <img src="img/Dune1.png" alt="">
                <h3>Dune 1</h3>
            
            </div>

            <div class="product" data-name="p-2">
                <img src="img/dune2.png" alt="">
                <h3>Dune 2</h3>
            </div>

            <div class="product" data-name="p-3">
                <img src="img/binarydust.png" alt="">
                <h3>Binary Dust</h3>
            </div> -->

           
    

</div>


<div class="products-preview">

<?php 
        $select_query="Select * from `book`";
        $result_query=mysqli_query($conn,$select_query);


        while($row=mysqli_fetch_assoc($result_query)){
            $Book_Id=$row['Book_Id'];
            $Book_Name=$row['Book_Name'];
            $Author=$row['Author'];
            $ISBN=$row['ISBN'];
            $Category=$row['Category'];

            echo"<div class='preview' data-target='p-1'>
            <i class='fas fa-times'></i>
           
            <h3>Request Book Details</h3>
            <div class='container1'>
                 <form>
                     
                     <label>Book Name - $Book_Name</label>
                     <br>
                     <label>Book ID - $Book_Id</label>
                     <br>
                     <label>Author - $Author </label>
                     <br>
                     <label>ISBN -  $ISBN</label>
                     <br>
                     <label>Category - $Category</label>
                     <br>
                 </form>
             <div class='buttons'>
                 <a href='user.html' class='cansal'>Cansel</a>
                 <a href='notification.html' class='request'>Request</a>
             </div>
             </div>
         </div>";

        }
        
        
        ?>

    <!--<div class="preview" data-target="p-1">
       <i class="fas fa-times"></i>
      !--<img src="img/Dune1.png alt="Dune 2">--
       <h3>Request Book Details</h3>
       <div class="container1">
            <form>
                
                <label>Book Name - DUNE 1</label>
                <br>
                <label>Book ID - 001</label>
                <br>
                <label>Author - Jedu Dies </label>
                <br>
                <label>ISBN - 5768</label>
                <br>
                <label>Category - Novel</label>
                <br>
            </form>
        <div class="buttons">
            <a href="user.html" class="cansal">Cansal</a>
            <a href="notification.html" class="request">Request</a>
        </div>
        </div>
    </div>

    <div class="preview" data-target="p-2">
        <i class="fas fa-times"></i>
        !--<img src="img/dune2.png"  alt="Dune 2">--
        <h3>Request Book Details</h3>
        <div class="container1">
             <form>
                 
                 <label>Book Name - DUNE 2</label>
                 <br>
                 <label>Book ID - 002</label>
                 <br>
                 <label>Author - Jedu Dies </label>
                 <br>
                 <label>ISBN - 5574</label>
                 <br>
                 <label>Category - Novel</label>
                 <br>
             </form>
         <div class="buttons">
             <a href="user.html" class="cansal">Cansal</a>
             <a href="notification.html" class="request">Request</a>
         </div>
         </div>
     </div>

     <div class="preview" data-target="p-3">
        <i class="fas fa-times"></i>
        !--<img src="img/dune2.png"  alt="Dune 2">--
        <h3>Request Book Details</h3>
        <div class="container1">
             <form>
                 
                 <label>Book Name - Binary Dust</label>
                 <br>
                 <label>Book ID - 003</label>
                 <br>
                 <label>Author - Jedu Dies </label>
                 <br>
                 <label>ISBN - 7823</label>
                 <br>
                 <label>Category - Novel</label>
                 <br>
             </form>
         <div class="buttons">
             <a href="user.html" class="cansal">Cansal</a>
             <a href="notification.html" class="request">Request</a>
         </div>
         </div>
     </div> -->

</div>
</body>
</html>


