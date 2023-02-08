<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

if(isset($_SESSION['message'])){
    echo "<script>alert('Catalog Successfully Created')</script>";
    unset ($_SESSION['message']);
} 

//generate catalog ID
$query = "SELECT * FROM catalog ORDER BY catalog_id DESC LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
$lastid = $row['catalog_id'];

if (empty($lastid)) {
    $cid = "C0001";
} else {
    $get_id = str_replace("C", "", $lastid);
    $get_string = str_pad($get_id + 1, 4, 0, STR_PAD_LEFT);
    $cid = 'C' . $get_string;
}

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
        
        <title>Add Catalog Management</title>
        
    </head>
    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Catalog 
                                <a href="catalog.php" class="btn btn-danger float-end">BACK</a>
                            </h4>
                        </div>
                        <div class="card-body">
                            <form action="codeDatabase.php" enctype="multipart/form-data" method="POST" onkeyup="check()" >
                                <div class="mb-3">
                                    <label>Catalog ID:</label>
                                    <input type="text" name="catalog_id" class="form-control" id = "catalog_id" value="<?php echo $cid; ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Supplier ID:</label>
                                    <select name="supplierID" id="supplierID" class="form-control">
                                    <?php 
                                        $query = "SELECT * FROM supplier WHERE supplierID NOT IN (SELECT supplierID FROM catalog);";
                                        $query_run = mysqli_query($con, $query);
                                        $result = mysqli_fetch_all($query_run);
                                        foreach($result as $supplier){          
                                        ?>
                                            <option value="<?php echo $supplier[0]?>"><?php echo $supplier[0]?></option>
                                        <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="icons">
                                    <span class="icon1 fas fa-exclamation"></span> <!--！-->
                                    <span class="icon2 fas fa-check"></span> <!--v-->
                                </div>
                                <div class="error-text">
                                    Please Enter Valid Supplier ID
                                </div>
                                <div class="mb-3">
                                    <label>Catalog File:</label>
                                    <input type="file"  data-default-file="pdf" accept=".pdf" name="img_file" id="img_file" onchange="getImagePreview()" required>
                                    <div class="mvv">
                                        <iframe id="preview" frameborder="0" scrolling="no" width="430px"></iframe>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Date:</label>
                                    <input type="date" name="date" class="form-control" min="<?=$CDT;?>" max="<?=$FDT;?>" value="<?=$FDT;?>" readonly required>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" name="save_catalog" class="btn btn-primary">Add Catalog</button>
                                </div>
                            </form>
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
