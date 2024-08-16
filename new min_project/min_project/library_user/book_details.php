<?php
    include "connection.php";
    include "commen_function.php";

   

    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<nav class="navbar">
    <div class="left">
    <a href="userhome.php" class="navbar-link">Home </a>
        <a href="userequest.php" class="navbar-link">Requested Books</a>
        <a href="userborrow.php" class="navbar-link">Borrowed Books</a>
        <a href="userreturn.php" class="navbar-link">Returned Books</a>
    </div>
    
    
</nav>

<div class="content">
    <div class="left-content">
        <p class="greeting">WHENEVER YOU'RE READY</p>
        <p class="description">Discover your favorite books.</p>
    </div>


          
      	
    
  </div>
    <div class="container bg-light" style="margin-top: 20px; border-radius: 10px;">
        <div class="row">
            
        <?php 
        //calling function
        view_details();
            

        
        ?>


        </div>
    </div>
</body>
</html>
