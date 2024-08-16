<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nic'])) {
    header("Location: login.html");
    exit();
}

// Get the logged-in user's NIC and other session data
$loggedInNic = $_SESSION['nic'];
$user = $_SESSION['user']; // Retrieve user data from session

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "min_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accessType = $_POST['access'];

    // Fetch user permission from the database
    $stmt = $conn->prepare("SELECT * FROM permission WHERE nic = ?");
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $loggedInNic);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // user and admin pages based on the access type
        if ($accessType == 'library') 
        {
            $permission = $row['library_management'];
            handlePermission($permission, 'library_user/userhome.php', 'library_admin/managebook.php');
        } 
        elseif ($accessType == 'inventory') 
        {
            $permission = $row['inventory'];
            handlePermission($permission, 'inventory_user.php', 'Inventory/admin_I.php');
        } 
        elseif ($accessType == 'file_tracking') 
        {
            $permission = $row['file_tracking'];
            handlePermission($permission, 'file_tracking_user/user.php', 'file_tracking_admin/admin.php');
        } 
        else {
            $error_message = "Invalid access type.";
        }
    } else {
        $error_message = "No permissions found for the user.";
    }

    $stmt->close();
    $conn->close();
}

function handlePermission($permission, $userPage, $adminPage) {
    global $error_message;
    if ($permission == 'admin') {
        header("Location: $adminPage");
        exit();
    } elseif ($permission == 'user') {
        header("Location: $userPage");
        exit();
    } elseif ($permission == 'not_access') {
        $error_message = "Sorry, you have no access to this system.";
    } else {
        $error_message = "Invalid permission type.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #005246;
            color: white;
            padding: 15px;
            border-radius: 5px;
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
         .welcome-container {
            position: relative; /* Make container relative for absolute positioning */
        }
        .profile-icon {
            margin-right: 10px; /* Add space between profile icon and logout button */
            vertical-align: middle; /* Align icon vertically */
        }
        .logout-btn {
            position: absolute;
            top: 10px; /* Adjust top position as needed */
            left: 10px; /* Adjust left position as needed */
            background-color: #005246;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            z-index: 1000; /* Ensure button is above other elements */
        }
        .logout-btn:hover {
            background-color: #777;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <a href="logout.php" class="logout-btn">Logout</a>
        <div class="background-image"></div>
        <div class="content-box">
            <div class="welcome-text">
                <h1>WELCOME</h1>
                <p>Explore our services and offerings</p>
            </div>
            <div class="buttons">
                <form action="welcome.php" method="post" class="buttons">
                    <button type="submit" name="access" value="library">LIBRARY SYSTEM</button>
                    <button type="submit" name="access" value="inventory">INVENTORY SYSTEM</button>
                    <button type="submit" name="access" value="file_tracking">FILE TRACKING SYSTEM</button>
                </form>
            </div>
            <div class="logos">
                <img src="gover.jpg" alt="Logo 1">
                <img src="log.jpg" alt="Logo 2">
            </div>
        </div>
        <img src="profile.jpg" alt="Profile Icon" class="profile-icon">
    </div>
    <div class="notification" id="notification"></div>
    <script>
        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }
        <?php if ($error_message): ?>
            showNotification("<?php echo htmlspecialchars($error_message); ?>");
        <?php endif; ?>
    </script>
</body>
</html>
