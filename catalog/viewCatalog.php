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

    <title>View Catalog Management</title>
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>View Catalog Details 
                            <a href="catalog.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if(isset($_GET['catalog_id'])){
                            $catalog_id = mysqli_real_escape_string($con, $_GET['catalog_id']);
                            $query = "SELECT * FROM catalog INNER JOIN supplier ON catalog.supplierID = supplier.supplierID WHERE catalog_id='$catalog_id' ";
                            $query_run = mysqli_query($con, $query);
                           
                            if(mysqli_num_rows($query_run) > 0){
                                $catalog = mysqli_fetch_array($query_run);
                                ?>
                                    <div class="mb-3">
                                        <label>Catalog ID:</label>
                                        <p class="form-control">
                                            <b><?=$catalog['catalog_id'];?></b>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Supplier ID:</label>
                                        <p class="form-control">
                                            <b><?=$catalog['supplierID'];?></b>
                                        </p>
                                    </div> 
                                    <div class="mb-3">
                                        <label>Supplier Name:</label>
                                        <p class="form-control">
                                            <b><?=$catalog['companyName'];?></b>
                                        </p>
                                    </div> 
                                    <div class="mb-3">
                                        <label>Catalog Name:</label>
                                        <p class="form-control">
                                            <b><?=$catalog['catalogFile'];?></b>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Catalog Date:</label>
                                        <p class="form-control">
                                            <b><?=$catalog['catalogDate'];?></b>
                                        </p>
                                    </div>
                                    <div class="behind">
                                        <div class="mb-3">
                                            <label>Catalog File:</label>
                                            <p class="form-control boxe">
                                                <embed src="<?= $catalog['catalogFile']?>" width="230" height="197" name="pdf"></embed>
                                            </p>
                                        </div>
                                        <a href="viewFile.php?catalog_id=<?= $catalog['catalog_id']; ?>"class="btn btn-success"><i class="fa fa-file-pdf-o"></i> View PDF</a> 
                                    </div>
                                <?php
                            } else {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div><br>
            </div>
        </div>
    </div>
    
    <style>
        .container{
            width:700px;
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
          left: 400px;
          top: 70px;
        }
        
        .btn-success{
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 48px;
        }
       
        .boxe{
            width: 255px;
            height: 210px;
        }
        
        h4{
            text-align: center;
            font-size:1.5rem;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>