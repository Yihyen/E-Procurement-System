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
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Catalog Management List</title>
    
</head>
<body>
    <div class="container mt-4">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fo">Catalog Management List</h4>
                    </div>
                    <div class="card-body">
                        <table id="search" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>File Name</th>
                                    <th>Catalog File</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyRow">
                                <?php
                                $query = "SELECT * FROM catalog";
                                $query_run = mysqli_query($con, $query);
                                if(mysqli_num_rows($query_run) > 0){
                                        foreach($query_run as $catalog){
                                            ?>
                                            <tr>
                                                <td class="id"><?= $catalog['catalog_id']; ?></td>
                                                <td class="nameF" name="file"><?= $catalog['catalogFile']; ?></td>
                                                <td class="file"><embed src="<?= $catalog['catalogFile']?>" width="150" height="100"></embed></td>
                                                <td class="doc"><?= $catalog['catalogDate']; ?></td>
                                                <td class="button">
                                                    <a href="viewCatalog.php?catalog_id=<?= $catalog['catalog_id']; ?>" class="btn btn-info btn-sm">View</a>
                                                    <a href="updateCatalog.php?catalog_id=<?= $catalog['catalog_id']; ?>" class="btn btn-success btn-sm">Update</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else{
                                        echo "<h5> No Record Found </h5>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div><br>
            </div>
        </div>
    </div>

    <script src="jquery.min.js"></script>
    <script src="tether.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.9.1/standard/ckeditor.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function () {
            
            $('#search').DataTable(); 
        });
        
        CKEDITOR.replace('editor1');
        
        let reject = "";

        function enableRejectReason(){
            document.getElementById('reason').removeAttribute('readonly');
            document.getElementById('rejectBtn').removeAttribute('style');
            document.getElementById('rejectBtn').removeAttribute('disabled');
            document.getElementById('rejectBtn').style.backgroundColor = '#3333ff';
            document.getElementById('rejectBtn').style.color = 'white';
        }

        function checkReasonEmpty(form){
            if(reject === 'true'){
                let rejectReason = document.getElementById('reason').value;
                if(rejectReason == ''){
                    alert('Please Enter A Reject Reason');
                    return false;
                }
            }
            return true;
        }

        function setReject(control){
            reject = control;
        }
    </script>
    
    <style>
        .container{
            width: 1000px;
            font-family: 'Poppins', sans-serif;
        }
        .card-header{
/*            background-color: #3333ff;
            color:white;*/
            color:#17a2b8;
        }
        h4,table.dataTable thead td{
            text-align: center;
        }

        .fo{
            padding-top: 5px;
        }
        
        td.file{
            width:100px;
        }
        
        embed{
            vertical-align: middle;
        }
        
        td.id{
            width:40px;
            vertical-align: middle;
        }
       
        td.button, td.a{
            text-align: center;
            vertical-align: middle;
                
        }
        
        td.nameF{
            width:350px;
            vertical-align: middle;
        }
        
        td.doc{
            vertical-align: middle;
        }
        
        .btn-primary{
            margin-bottom:7px;
            background-color: #f845a2;
        }
        
        .btn-info{
            margin-bottom:5px;
            background-color: #0085fd;
            color: white;
            
        }

        .btn-success{
            margin-bottom:5px; 
         
        }
        
        .btn-danger {
            margin-bottom:5px; 
        }
        
        .btn-success:hover{
            color:#fff;
            background-color:#65d535;
            border-color:#146c43
        }
        
        table.dataTable thead th,table.dataTable thead td,table.dataTable tfoot th,table.dataTable tfoot td{
            text-align:center
        }
        
    </style>
</body>
</html>

