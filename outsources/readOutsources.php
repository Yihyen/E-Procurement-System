<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Outsourcer View</title>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>View Outsourcer Details 
                            <a href="outsourcesList.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if(isset($_GET['id'])){
                            $outsourcer_id = mysqli_real_escape_string($con, $_GET['id']);
                            $query = "SELECT * FROM outsourcerlist WHERE id='$outsourcer_id' ";
                            $query_run = mysqli_query($con, $query);
                           
                            if(mysqli_num_rows($query_run) > 0){
                                $outsourcer = mysqli_fetch_array($query_run);
                                ?>
                                    <div class="mb-3">
                                        <label>Outsourcer ID &nbsp &nbsp &nbsp &nbsp : </label><b> <?=$outsourcer['id'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        <label>Outsourcer Name&nbsp: </label><b> <?=$outsourcer['outsourcerName'];?></b>
                                    </div> 
                                    <div class="mb-3">
                                        <label>Phone &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp: </label><b> <?=$outsourcer['contactNumber'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        <label>Address &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp: </label><b> <?=$outsourcer['address'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp: </label><b> <?=$outsourcer['email'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        <label>Service Type &nbsp &nbsp &nbsp &nbsp &nbsp: </label><b> <?=$outsourcer['serviceType'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        <label>Status&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp: </label>
                                        <?php
                                            if ($outsourcer['status'] == 'Invite') {
                                                echo "<span class='badge badge-warning'>Invite</span>";
                                            } else {
                                                echo "<span class='badge badge-danger'>Invited</span>";
                                            }
                                        ?>
                                    </div>
                                <?php
                            } else {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .container{
            width:500px;
            font-family: 'Poppins', sans-serif;
        }
        .card-header{
            text-align: center;
            color:#17a2b8;
        }
        .form-control{
            width:370px;
        }
        
        .behind{
          position: absolute;
          left: 360px;
          top: 70px;
        }
        
        .behind1{
          position: absolute;
          left: 700px;
          top: 70px;
        }
        
        .btn-success {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 10px;
        }
       
        .boxe{
            width: 255px;
            height: 210px;
        }
        
        .boxe1{
            width: 295px;
            height: 210px;
        }
        
        h4{
            text-align: center;
            font-size:1.5rem;
        }
        
        .c{
            color:red;
        }
        .badge-danger {
            background-color: red;
            color: white;
            padding: 4px 8px;
            text-align: center;
            border-radius: 5px;
        }
        
        .badge-warning {
            background-color: #ffd11a;
            color: white;
            padding: 4px 8px;
            text-align: center;
            border-radius: 5px;
        }
        
         .badge-warning {
            background-color: green;
            color: white;
            padding: 4px 8px;
            text-align: center;
            border-radius: 5px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>