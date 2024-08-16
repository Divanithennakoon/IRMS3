<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Super Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height to center vertically */
        }

        .button {
            display: inline-block;
            background-color: #005246;
            color: #fff;
            text-align: center;
            padding: 15px 30px;
            margin: 10px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #003d36; /* Slightly darker green for hover effect */
        }

        .view-btn {
            background-color: #005246;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .view-btn:hover {
            background-color: #003d36;
        }

        .message-box {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .message {
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>  

<div class="content">
    <div class="left-content">
        <p class="greeting">Hi, Welcome!</p>
        <p class="description">Let's think positively about everything...</p>
    </div>
</div>

<div class="message-boxes">
    <div id="message-container">
        <?php
        // Database connection details
        $servername = "localhost"; 
        $username = "root"; 
        $password = ""; 
        $dbname = "min_project"; 

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Fetch new user registrations from the database
        $sql = "SELECT * FROM user_temp";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<div class='message-box'>";
                echo "<p class='message'>New user registration:</p>";
                echo "<p>Name: " . $row['first_name'] . " " . $row['last_name'] . "</p>";
                echo "<p>NIC: " . $row['nic'] . "</p>";
                echo "<form action='view_user.php' method='post'>";
                echo "<input type='hidden' name='nic' value='" . $row['nic'] . "'>";
                echo "<button type='submit' name='view' class='view-btn'>View</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>No new registrations</p>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>
</div>

</body>
</html>
