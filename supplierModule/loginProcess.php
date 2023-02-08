<?php 
session_start();
$_SESSION['companyName'] = $_POST['companyName'];
$_SESSION['password'] = $_POST['password'];

$companyName = stripslashes($_POST['companyName']);
$password = stripslashes($_POST['password']);
// $supplierName = mysqli_real_escape_string($_POST['supplierName']);
// $password = mysqli_real_escape_string($_POST['password']);
$conn = mysqli_connect("localhost", "root", "", "procurementsystem");

    $result = mysqli_query($conn, "SELECT * FROM users WHERE companyName = '$companyName' AND supplierPass = '$password'")
        or die("Failed to query database ".mysqli_error($conn));
        
    $row = mysqli_fetch_array($result);

    if ($row['companyName'] == $companyName && $row['supplierPass'] == $password) {
        $success = "Login success! Welcome ".$row['companyName'];
      ?>
      <!DOCTYPE html>
    <html>
    <head>
        <title>Home Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <style>
            .container {
                margin-top: 15%;
            }


            .btn {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 20%;
                background-color: whitesmoke;
                color:  gainsboro;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-left: auto;
                margin-right: auto;

            }
        </style>

    </head>
        
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="text-align: center; color: cadetblue;"><?php echo $success; ?></h1>
        
                    <button class="btn" style="text-decoration: none;" onclick = "window.location.href = 'quotationSupplier.php';">View RFQ</button>

    
                </div>
            </div>
        </div>

    </body>

</html>
<?php
      
    } else {
        echo "Failed to login!";
    }
?>



