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

    <title>Supplier Details View</title>
</head>
<body>

    <div class="container mt-5">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Supplier Details 
                            <a href="statusSupplier.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['potential_id']))
                        {
                            $id = mysqli_real_escape_string($con, $_GET['potential_id']);
                            $query = "SELECT * FROM potential_supplier WHERE potential_id='$id' ";
                            $query_run = mysqli_query($con, $query);
                           
                            if(mysqli_num_rows($query_run) > 0){
                                $potential = mysqli_fetch_array($query_run);
                                ?>
                                    <div class="mb-3">
                                        <label>ID &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</label><b> <?=$potential['potential_id'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        <label>Company &nbsp &nbsp:</label><b> <?=$potential['companyName'];?></b>
                                    </div> 
                                    <div class="mb-3">
                                        <label>Country &nbsp &nbsp &nbsp :</label><b> <?=$potential['country'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        <label>Phone &nbsp &nbsp &nbsp &nbsp &nbsp:</label><b> <?=$potential['supplierContact'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email &nbsp &nbsp &nbsp &nbsp &nbsp :</label><b> <?=$potential['supplierEmail'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        <label>Address &nbsp &nbsp &nbsp:</label><b> <?=$potential['supplierAddress'];?></b>
                                    </div>
                                     <div class="mb-3">
                                        <label>Fax &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp :</label><b> <?=$potential['faxNum'];?></b>
                                    </div>
                                     <div class="mb-3">
                                        <label>Business &nbsp &nbsp :</label><b> <?=$potential['typeOfBusiness'];?></b>
                                    </div>
                                    <div class="mb-3">
                                        
                                        <?php
                                                    if ($potential['status'] == 'Rejected') {
                                                        echo "<label>Reason &nbsp&nbsp &nbsp &nbsp: &nbsp</label>";
                                                        echo "<b>".$potential['reason']."</b>";
                                                    }
                                            ?>
                                    </div>
                                    <div class="behind">
                                         <div class="mb-3">
                                            <label>Registration Number :</label><b> <?=$potential['registrationNum'];?></b>
                                         </div>
                                         <div class="mb-3">
                                            <label>Catalog File :</label>
                                            <p class="form-control boxe1">
                                                <embed src="<?= $potential['catalog']?>" width="270" height="197" name="pdf"></embed>
                                            </p>
                                            <a href="viewFile.php?potential_id=<?= $potential['potential_id']; ?>"class="btn btn-success"><i class="fa fa-file-pdf-o"></i> View PDF</a> 
                                         </div>
                                    </div>
                                    <div class="behind1">
                                        <div class="mb-3">
                                            <label>Status&nbsp &nbsp:</label>
                                            <?php
                                                    if ($potential['status'] == 'Pending') {
                                                        echo "<span class='badge badge-warning'>Pending</span>";
                                                    } else if($potential['status'] == 'Approved') {
                                                        echo "<span class='badge badge-success'>Approved</span>";
                                                    }else {
                                                        echo "<span class='badge badge-danger'>Rejected</span><br>";
                                                    }
                                            ?>
                                        </div>
                                        <div class="mb-3">
                                            <label>Biz Profile :</label>
                                            <p class="form-control boxe">
                                                <embed src="<?= $potential['bizProfile']?>" width="230" height="197" name="pdf"></embed>
                                            </p>
                                        </div>
                                            <a href="viewFile1.php?potential_id=<?= $potential['potential_id']; ?>"class="btn btn-success"><i class="fa fa-file-pdf-o"></i> View PDF</a> 
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
            width:1000px;
            font-family: 'Poppins', sans-serif;
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
        
        .card-header{
            color:#17a2b8;
        }
        h4{
            text-align: center;
            font-size:2.0rem;
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
        
         .badge-success {
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