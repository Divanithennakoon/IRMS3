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
    <link rel="stylesheet" href="styles.css?v=1.0">

    <!--script src="user.js" defer></script>-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<nav class="navbar">
    <div class="left">
        <a href="userhome.php" class="navbar-link">Home </a>
        <a href="userequest.php" class="navbar-link">Requested Books</a>
        <a href="userborrow.php" class="navbar-link">Borrowed Books</a>
        <a href="userreturn.php" class="navbar-link">Retuned Books</a>
        
       
    </div>
    <div class="middle" >
    <form  action="search_books.php" method="get">
        <input type="search" placeholder="Search Books..." arial-label="Search"class="search-bar" name="search_books">
        <input type="submit" value="Search" name="search_book_data">
    </form>
    </div>
    
</nav>
        

<div class="content" method="get">
    <div class="left-content">
      <p class="greeting">WHENEVER YOU'RE READY</p>
      <p class="description">Discover your favorite books.</p>
    </div>

    <div class="right-content" >
    <form action="search_category.php" method="get">
            <select name="Category" placeholder="Category">
                <option value="">Category</option>
                <?php 
                $select_query = "SELECT * FROM `categories`";
                $result_query = mysqli_query($conn, $select_query);
                while ($row = mysqli_fetch_assoc($result_query)) {
                    $category_title = $row['category_title'];
                    echo "<option value='$category_title'>$category_title</option>";
                }
                ?>
            </select>
            <input type="submit" value="Search" name="search_category">
        </form>
    </div>
  </div>

<div class="container">
    
        <?php 
        //calling function
        //view_details();
            get_all_books();
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

    <div class="preview" data-target="p-1">
       <i class="fas fa-times"></i>
      
       <h3>Request Book Details</h3>
       <div class="container1">

       <?php 
        //calling function
        view_details();
            

        
        ?>
        <div class="buttons">
            <a href="book_view.php" class="view">View</a>
            <a href="#" class="request">Request</a>
        </div>
            
        </div>

       <!-- <div class="preview" data-target="p-1">
       <i class="fas fa-times"></i>
      
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
        
        </div> -->
    
</div>


</body>
</html>