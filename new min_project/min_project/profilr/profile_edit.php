<?php
session_start();

if (!isset($_SESSION['nic'])) {
    header("Location: login.html");
    exit();
}

$loggedInNic = $_SESSION['nic'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "min_project";

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $department = $_POST['department'];
    $post = $_POST['post'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // Initialize profile_pic variable
    $profile_pic = '';

    // Handle profile picture upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $file = $_FILES['profile_pic'];
        $file_name = basename($file['name']);
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Define allowed file types and max file size (5MB in this case)
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $max_file_size = 5 * 1024 * 1024;

        if ($file_error === UPLOAD_ERR_OK) {
            if (in_array($file_type, $allowed_types)) {
                if ($file_size <= $max_file_size) {
                    $target_dir = "uploads/";
                    $profile_pic = $target_dir . $file_name;

                    // Ensure the uploads directory exists and is writable
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0755, true);
                    }

                    if (is_writable($target_dir)) {
                        if (move_uploaded_file($file_tmp, $profile_pic)) {
                            echo "Profile picture uploaded successfully.<br>";
                        } else {
                            echo "Error moving uploaded file.<br>";
                            $profile_pic = ''; // Reset if upload fails
                        }
                    } else {
                        echo "Upload directory is not writable.<br>";
                    }
                } else {
                    echo "File size exceeds the maximum allowed size of 5MB.<br>";
                }
            } else {
                echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.<br>";
            }
        } else {
            echo "File upload error: " . $file_error . "<br>";
        }
    } else {
        // If no new file is uploaded, get the existing profile picture
        $sql = "SELECT profile_pic FROM user WHERE nic = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $loggedInNic);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $profile_pic = $user['profile_pic'];
        }
    }

    // Update user details in the database
    $sql = "UPDATE user SET first_name = ?, last_name = ?, username = ?, department = ?, post = ?, email = ?, phone_number = ?, profile_pic = ? WHERE nic = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $first_name, $last_name, $username, $department, $post, $email, $phone_number, $profile_pic, $loggedInNic);

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
        header("Location: profile_page.php");
        exit();
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
