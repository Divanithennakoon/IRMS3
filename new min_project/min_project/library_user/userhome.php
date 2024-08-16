<?php
// Include database connection
include "connection.php";
// Include common functions
include "commen_function.php";

session_start();

// Check if the user is logged in
if (!isset($_SESSION['nic'])) {
    // Redirect to login page if not logged in
    header("Location: login_process.php");
    exit();
}

// Get the logged-in user's NIC
$loggedInNic = $_SESSION['nic'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home Page</title>
    <link rel="stylesheet" href="styles.css">
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
    <div class="right-content">
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
    // Display books
    getbooks();
    ?>
</div>

<div class="products-preview">
    <div class="preview" data-target="p-1">
        <h3>Request Book Details</h3>
        <div class="container1">
            <?php
            // Display book details
            view_details();
            ?>
            <!--<div class="buttons">
                <a href="book_view.php" class="view">View</a>
                <a href="request_book.php" class="request">Request</a>
            </div>-->
        </div>
    </div>
</div>

</body>
</html>
