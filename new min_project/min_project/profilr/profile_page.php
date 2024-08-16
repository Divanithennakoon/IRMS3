<?php
session_start();

if (!isset($_SESSION['nic'])) {
    header("Location: login.html");
    exit();
}

$loggedInNic = $_SESSION['nic'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "min_project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT first_name, last_name, department, post, email, phone_number, nic, profile_pic FROM user WHERE nic = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $loggedInNic);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();

function displayField($field) {
    return empty($field) ? "Enter here..." : htmlspecialchars($field);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link rel="stylesheet" href="profile.css">
</head>
<body>

  <div class="container">

    <div class="navbar">
      <a href="javascript:history.back()">Back</a>
      <a href="welcome.php">Welcome Page</a>
    </div>

    <div class="main">
      <div class="view">
        <div class="image">
           <img src="<?php echo empty($user['profile_pic']) ? 'uploads/defaultpic.jpg' : htmlspecialchars($user['profile_pic']); ?>" id="profilepic" alt="Profile Picture">
       </div>

        <div class="details">
            <h2>
              <?php echo displayField($user['first_name']) . ' ' . displayField($user['last_name']); ?>
            </h2>
            <p><?php echo displayField($user['post']); ?></p>
            <p><?php echo displayField($user['department']); ?></p>
            <div class="btnclass">
              <a href="edit_profile.php" class="btnset" id="btn1">Edit</a>
            </div>
        </div>
      </div>
      
      <div class="hdetails">
        <h3>Full Name</h3>
        <p><?php echo displayField($user['first_name']) . ' ' . displayField($user['last_name']); ?></p>
    
        <h3>Email</h3>
        <p><?php echo displayField($user['email']); ?></p>
        
        <h3>Phone</h3>
        <p><?php echo displayField($user['phone_number']); ?></p>
        
        <h3>NIC</h3>
        <p><?php echo displayField($user['nic']); ?></p>
      </div>
        
    </div>

  </div>

</body>
</html>
