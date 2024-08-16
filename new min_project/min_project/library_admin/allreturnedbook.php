<?php
    include "connection.php";

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
   <div class="search-bar">
   <form action="search_return.php" method="get">
        <input type="text" placeholder="  Quick Search ... NIC" name="search">
        <button type="submit" name="search_book"><i class="fas fa-search"></i></button>
        <!--<input type="submit" value="Search" name="search_book">-->
        </from>
    </div>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>

	<div class="profile">
		<div class="dropdown">
			<!--<header class="dropbtn"=>My Profile</header>-->
			<div class="dropdown-content">
	      		<a href="#">Notifications</a>
	      		<a href="#">Settings</a>
	      		<a href="#">Logout</a>
	    	</div>
		</div>
	</div>

    <div class="form-container">
  <form class="my-form">
    <h2>All Returned Books</h2>
    <br>
    <br>
    <br>
  </form>
  
</div>

<table class="my-table">
  <thead>
    <tr>
    <!--<th>User Name</th>-->
      <th>User id</th>
      <th>Book Name</th>
      <th>Book Id</th>
      <th>Author</th>
      <th>Category</th>
      <th>Year</th>
      <th>Issued Date</th>
      <th>Returned Date</th>
      
      
    </tr>
  </thead>
  <tbody>
  <?php
      $sql = "SELECT nic,username,Book_Name,Book_Id,Author,ISBN,Category,Year,issue_date,return_date  FROM `return_book`";
      $result=$conn->query($sql);

      while($row=$result->fetch_assoc()){
        echo"<tr>
        <td>$row[nic]</td>
        <td>$row[Book_Name]</td>
        <td>$row[Book_Id]</td>
        <td>$row[Author]</td>
        <td>$row[Category]</td>
        <td>$row[Year]</td>
        <td>$row[issue_date]</td>
        <td>$row[return_date]</td>
        
    
    </tr>";

      }
    ?>

    
  </tbody>
</table>





   <section></section>
  </body>
</html>
