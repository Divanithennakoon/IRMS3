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

        .btn-return {
            background-color: #28a745; /* Green color for edit button */
        }
        .btn-see-all {
      background-color: #28a745; /* Teal color for See All button */
    }
     /* Style for the button container */
     .button-container {
      margin-top: 20px;
      text-align: right; /* Adjust this to position the button */
      padding-right: 20px;
    }

    /* Add responsive styles */
    @media (max-width: 768px) {
      .sidebar, .main-content {
        flex: 1 1 100%;
      }

      form input, form select, form button {
        flex: 1 1 100%;
      }
      
      .button-container {
        text-align: center;
        padding-right: 0;
      }
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
   <div class="search-bar">
   <form action="search_issue.php" method="get">
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
   <h2> Issued Books</h2>
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
      <th>Return</th>
    </tr>
  </thead>
  <tbody>
  <?php
      $sql = "SELECT nic,username,Book_Name,Book_Id,Author,ISBN,Category,Year,issued_date  FROM `issue_book` order by rand() limit 0,12";
      $result=$conn->query($sql);

      while($row=$result->fetch_assoc()){
        echo"<tr>
        <td>$row[nic]</td>
        <td>$row[Book_Name]</td>
        <td>$row[Book_Id]</td>
        <td>$row[Author]</td>
        <td>$row[Category]</td>
        <td>$row[Year]</td>
        <td>$row[issued_date]</td>
        <td>
            <a class='btn btn-return' href='returnfunction.php?id={$row['Book_Id']}' onclick='return confirm(\"Are you sure you want to return this book?\")'>Return</a>
        </td>

    
    </tr>";

      }
    ?>
    
  </tbody>
</table>


<div class="button-container">
    <a class="btn btn-see-all" href="allissuedbooks.php">See All</a>
  </div>


   <section></section>
  </body>
</html>
