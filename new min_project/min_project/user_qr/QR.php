<?php
    include "connection.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Scanner</title>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <link rel="stylesheet" herf="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="scanner.css">
</head>

<body>
    <div class="container">
    <h1>QR Scanner</h1>

        <div class="scanner-container">
        <video id="preview" width="40%"></video>
        <!--<label>SCAN QR CODE</label>-->
        <input type="hidden" name="text" id="text" readonly="" placeholder="scan qrcode" class="form-control">
        </div>
        <div class="button-container">
            <form action="user_qr.html" method="post" class="buttons">
            <button class="back-btn">Back</button>
            
        </div>

    </div>

    <table class="my-table table table-bordered mt-3">
  <thead>
    <tr>
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
    <!-- Rows will be dynamically added here -->
  </tbody>
</table>

    <script>
        let scanner= new Instascan.Scanner({video: document.getElementById('preview')});
        Instascan.Camera.getCameras().then(function(cameras){
            if(cameras.length>0)
        {
            scanner.start(cameras[0]);
        }
        else{
            alert("no camera found");
        }
        }).catch(function(e)
    {
        console.error(e);
    });

    scanner.addListener('scan',function(c){
        document.getElementById("text").value=c;

        // Fetch book details using AJAX
        fetch('fetch_book_details.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ Book_Id: c })
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('.my-table tbody');
                if (data.error) {
            alert('No book found');
            return;}

                tbody.innerHTML = `
                    <tr>
                        <td>${data.nic}</td>
                        <td>${data.Book_Name}</td>
                        <td>${data.Book_Id}</td>
                        <td>${data.Author}</td>
                        <td>${data.Category}</td>
                        <td>${data.Year}</td>
                        <td>${data.issued_date}</td>
                        <td>
                            <form action="scanreturn.php" method="POST">
                            <input type="hidden" name="nic" value="${data.nic}">
                            <input type="hidden" name="Book_Id" value="${data.Book_Id}">
                            <input type="hidden" name="ISBN" value="${data.ISBN}">
                            <input type="hidden" name="Book_Name" value="${data.Book_Name}">
                            <input type="hidden" name="Author" value="${data.Author}">
                            <input type="hidden" name="Year" value="${data.Year}">
                            <input type="hidden" name="Category" value="${data.Category}">
                            <input type="hidden" name="username" value="${data.username}">
                            <input type="hidden" name="issue_date" value="${data.issued_date}">
                            <button type="submit" class="return-btn" onclick='return confirm("Are you sure you want to return this book?")'>Return</button>
                </form>
                        </td>
                    </tr>
                `;
            })
            .catch(error => console.error('Error:', error));
    });
        
    </script>
    
</body>
</html>
