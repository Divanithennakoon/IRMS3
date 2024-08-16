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


$loggedInNic = $_SESSION['nic'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $department = $_POST['department'];
    $post = $_POST['post'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    
    // Handle profile picture upload
    $profile_pic = '';
    if (!empty($_FILES['profile_pic']['name'])) {
        $profile_pic_name = basename($_FILES['profile_pic']['name']);
        $target_dir = "profile_pic/";
        $target_file = $target_dir . $profile_pic_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
        } else {
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
                $profile_pic = $target_file;
            } else {
                echo "<script>alert('Error uploading profile picture.');</script>";
            }
        }
    }

    // Update user details in the database
    $sql = "UPDATE user SET first_name = ?, last_name = ?, username = ?, department = ?, post = ?, email = ?, phone_number = ?, profile_pic = ? WHERE nic = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $first_name, $last_name, $username, $department, $post, $email, $phone_number, $profile_pic, $loggedInNic);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile_page.php';</script>";
    } else {
        echo "<script>alert('Error updating profile: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_profile.css">
</head>
<body>
    <div class="navbar">
        <a href="javascript:history.back()">Back</a>
    </div>

    <div class="main">
        <div class="view">
            <div class="container">
                <h1>Edit Profile</h1>
                <form action="profile_edit.php" method="post" enctype="multipart/form-data">
                    <div class="form-group1">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>

                    <div class="form-group1">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="department">Department:</label>
                            <input type="text" id="department" name="department" required>
                        </div>
                    </div>

                    <div class="form-group1">
                        <div class="form-group">
                            <label for="post">Position:</label>
                            <input type="text" id="post" name="post" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="form-group1">
                        <div class="form-group">
                            <label for="phone_number">Phone Number:</label>
                            <input type="text" id="phone_number" name="phone_number" required>
                        </div>
                        <div class="form-group">
                            <label for="profile_pic">Profile Picture:</label>
                            <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
