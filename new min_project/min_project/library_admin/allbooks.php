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
   <div class="search-bar">
   <form action="search_remove.php" method="get">
      <input type="text" placeholder="Quick Search .. Book Name" name="search">
      <button type="submit" name="search_book"><i class="fas fa-search"></i></button>
      <!--<input type="submit" value="Search" name="search_book">-->
    </form>
    </div>
    

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
   <h2> All Books</h2>
    <br>
    <br>
    <br>
  </form>
  
</div>

<table class="my-table">
  <thead>
  <tr>
        <th>Book Name</th>
        <th>Book Id</th>
        <th>Author</th>
        <th>ISBN</th>
        <th>Category</th>
        <th>Year</th>
        <th>Edit/Remove</th>
      </tr>
  </thead>
  <tbody>
  <?php
      $sql = "SELECT b.Book_Name, b.Book_Id, b.Author, b.ISBN, c.category_title, b.Year 
      FROM `book` b 
      JOIN `categories` c ON b.Category = c.category_id ";

      $result = $conn->query($sql);
      while($row = $result->fetch_assoc()){
        echo "<tr>
          <td>{$row['Book_Name']}</td>
          <td>{$row['Book_Id']}</td>
          <td>{$row['Author']}</td>
          <td>{$row['ISBN']}</td>
          <td>{$row['category_title']}</td>
          <td>{$row['Year']}</td>
          <td>
            <a class='btn btn-edit' href='editbook.php?id={$row['Book_Id']}'>Edit</a>
            <a class='btn btn-remove' href='deletebook.php?id={$row['Book_Id']}' onclick='return confirm(\"Are you sure you want to remove this book?\")'>Remove</a>
          </td>
        </tr>";
      }
    ?>
    
  </tbody>
</table>





   <section></section>
  </body>
</html>
