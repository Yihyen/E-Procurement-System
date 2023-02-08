<?php 
session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Thank You</title>
    
</head>
<body>
    <div class="container mt-4">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fo">Thank You !!!</h4>
                    </div>
                    <div class="card-body">
                        <p>Thank you for <b>rejecting</b> our request, hope to have the opportunity to cooperate with you next time.</p>
                        <img src="../photo/tq.gif" >
                    </div>
                </div><br>
            </div>
        </div>
    </div>
    
     <style>
        .container{
            width: 1000px;
            font-family: 'Poppins', sans-serif;
        }
        
        .card-header{
            color:#17a2b8;
        }
        
        p, .button1, h4{
            text-align: center;
        }
        
        b{
            color: red;
        }
        
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        
    </style>
</body>
</html>