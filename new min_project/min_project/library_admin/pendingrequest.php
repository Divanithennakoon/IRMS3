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
         <li><a href="pendingrequest.php">Pending Request</a></li>
         <li><a href="requestedbook.php">Requested Books</a></li>
	     <li><a href="issuedbook.php">Issued Books</a></li>
	     <li><a href="returnedbook.php">Returned Books</a></li>
	     <li><a href="addfine.html">Add Fine</a></li>
	     <!--<li><a href="notification.html">Notification</a></li>-->
	    </ul>
   </div>
   
   <div class="form-container">
  <form class="my-form">
    Pending Request
    <br>
    <br>
    <br>
  </form>
  
</div>


<table class="my-table">
  <thead>
    <tr>
      <th>User Name</th>
      <th>User id</th>
      <th>Book Name</th>
      <th>Book Id</th>
      <th>Author</th>
      <th>Category</th>
      <th>Returned</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Data 1</td>
      <td>Data 2</td>
      <td>Data 3</td>
      <td>Data 4</td>
      <td>Data 5</td>
      <td>Data 6</td>
      <td><button class="request-button">Accept</button>       <button class="request-button">Cancel</button></td>
    </tr>
    <tr>
      <td>Data 1</td>
      <td>Data 2</td>
      <td>Data 3</td>
      <td>Data 4</td>
      <td>Data 5</td>
      <td>Data 6</td>
      <td><button class="request-button">Accept</button>       <button class="request-button">Cancel</button></td>
    </tr>
    <tr>
        <td>Data 1</td>
        <td>Data 2</td>
        <td>Data 3</td>
        <td>Data 4</td>
        <td>Data 5</td>
        <td>Data 6</td>
        <td><button class="request-button">Accept</button>       <button class="request-button">Cancel</button></td>
      </tr>
    <!-- Add more rows as needed -->
  </tbody>
</table>
	






    



   <section></section>
  </body>
</html>
