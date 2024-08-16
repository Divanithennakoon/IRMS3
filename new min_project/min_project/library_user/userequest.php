<?php
  session_start();
    include "connection.php";
    include "commen_function.php";

    // Check if the user is logged in
if (!isset($_SESSION['nic'])) {
  // Redirect to login page if not logged in
  header("Location: login_process.php");
  exit();
}

$nic = $_SESSION['nic'];

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home Page</title>
    <link rel="stylesheet" href="styles.css">
    <!--script src="user.js" defer></script>-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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

        .btn-cancel {
            background-color: #dc3545; /* Red color for remove button */
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="left">
    <a href="userhome.php" class="navbar-link">Home </a>
        <a href="userequest.php" class="navbar-link">Requested Books</a>
        <a href="userborrow.php" class="navbar-link">Borrowed Books</a>
        <a href="userreturn.php" class="navbar-link">Retuned Books</a>
    </div>
    
    
</nav>
        

<div class="content">
    <div class="left-content">
      <p class="greeting">My Request Book List</p>
      <!--<p class="description">Discover your favorite books.</p>-->
    </div>

    
  </div>

  
<div class="tabe-container">
  <table class="request-list-table">
    <thead>
      <tr>
        <th>Book name</th>
        <th>Book Id</th>
        <th>Author</th>
        <th>ISBN</th>
        <th>Category</th>
        <th>Year</th>
        <th>Request</th>
      </tr>
    </thead>
    <tbody>
    <?php
        $sql = "SELECT * FROM `request_book` WHERE nic = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $nic);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                <td>" . htmlspecialchars($row['Book_Name']) . "</td>
                <td>" . htmlspecialchars($row['Book_Id']) . "</td>
                <td>" . htmlspecialchars($row['Author']) . "</td>
                <td>" . htmlspecialchars($row['ISBN']) . "</td>
                <td>" . htmlspecialchars($row['Category']) . "</td>
                <td>" . htmlspecialchars($row['Year']) . "</td>
                <td>
                    <a class='btn btn-cancel' href='user_request_cancel.php?id=" . htmlspecialchars($row['Book_Id']) . "' onclick='return confirm(\"Are you sure you want to cancel this request?\")'>Cancel</a>
                </td>
                </tr>";
            }

            $stmt->close();
        } else {
            echo "<tr><td colspan='7'>Failed to retrieve data.</td></tr>";
        }
        $conn->close();
        ?>
      
    </tbody>
    
  </table>
</div>

    

    


</body>
</html>


