<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

//set date
date_default_timezone_set('Asia/Kuala_Lumpur');
$Format = 'Y-m-d';
$CDT = date($Format);
$FDT = date($Format);
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        
        <title>Update Catalog Management</title>
        
    </head>
    <body>

        <div class="container mt-5">
            <?php include('message.php'); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Catalog
                                <a href="catalog.php" class="btn btn-danger float-end">BACK</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <?php
                                if(isset($_GET['catalog_id'])){
                                   $catalog_id = mysqli_real_escape_string($con, $_GET['catalog_id']);
                                   $query = "SELECT * FROM catalog WHERE catalog_id='$catalog_id' ";
                                   $query_run = mysqli_query($con, $query);
                                   
                                   if(mysqli_num_rows($query_run) > 0){
                                        $catalog = mysqli_fetch_array($query_run);
                                        ?>
                                        <form action="codeDatabase.php" enctype="multipart/form-data" method="POST" onkeyup="check()" >
                                            <div class="mb-3">
                                                <label>Catalog ID:</label>
                                                <input type="text" name="catalog_id" value="<?=$catalog['catalog_id'];?>" class="form-control" id="catalog_id" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label>Supplier ID:</label>
                                                <input type="text" name="supplierID" value="<?=$catalog['supplierID'];?>" id="supplierID" class="form-control"readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label>Catalog File:</label>
                                                <input type="file"  data-default-file="pdf" accept=".pdf" name="img_file" id="img_file" onchange="getImagePreview()" required>
                                                <input type="hidden" name="imgold_file" value="<?= $catalog['catalogFile'];?>">
                                                <div class="mvv">
                                                    <iframe src="<?= $catalog['catalogFile']?>" id="preview" frameborder="0" scrolling="no" width="430px"></iframe>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label>Date:</label>
                                                <input type="date" name="date" class="form-control" min="<?=$CDT;?>" max="<?=$FDT;?>" value="<?=$FDT;?>" readonly required>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" name="update_catalog" class="btn btn-primary">Update Catalog</button>
                                            </div>
                                        </form>
                                    <?php
                                    }else{
                                        echo "<h4>No Such Catalog ID Found </h4>";
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
            width:500px;
            font-family: 'Poppins', sans-serif;
        }
        .card-header{
            text-align: center;
            color:#17a2b8;
        }
        
        h4{
            font-size:2.5rem;
        }
        .card-header{
            text-align: center;
        }
        
        form .icons{
            position: absolute;
            right: 25px;
            transform: translateY(-190%);
        }
        
        .icons span{ /*error circle*/
            height: 25px;
            width: 25px;
            border: 2px solid;
            border-radius: 50%;
            line-height: 23px;
            display:none;
        }
        
        .icons span.icon1{
            color: #e74c3c;
            border-color: #e74c3c;
            text-align: center;
        }
        
        .icons span.icon2{
            color: #27ae60;
            border-color: #27ae60;
            text-align: center;
        }
        
        form .error-text{
            position: relative;
            margin: 15px 0 10px 0;
            background: #e74c3c;
            color: #fceae8;
            font-size: 15px;
            padding: 8px;
            border-radius: 5px;
            user-select: none;
            display: none;
        }
        
        form .error-text:before{
            position: absolute;
            content: '';
            height: 15px;
            width: 15px;
            background: #e74c3c;
            right: 20px;
            top: -5px;
            transform: rotate(45deg);
        }
        
        .mvv{
            border: 5px dashed #e7e7e7;
        }
        
        iframe{
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        
        .mb-3 input{
            margin-bottom: 10px;
        }
        
        .btn-primary {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
            
    </style>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        
        function getImagePreview(){
            pdffile = document.getElementById("img_file").files[0];
            pdffile_url = URL.createObjectURL(pdffile);
            $('#preview').attr('src', pdffile_url);
        }
        
    </script>

</body>
</html>
