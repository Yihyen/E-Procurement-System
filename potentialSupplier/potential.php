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
    
    <title>Potential Supplier List</title>
    
</head>
<body>
    <div class="container mt-4">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fo">Potential Supplier List</h4>
                    </div>
                    <div class="card-body">
                        <table id="search" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Company Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = "SELECT * FROM potential_supplier";
                                    $query_run = mysqli_query($con, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $potential)
                                        {
                                            ?>
                                            <tr>
                                                <td class="id"><?= $potential['potential_id']; ?></td>
                                                <td class="name"><?= $potential['companyName']; ?></td>
                                                <td class="file"><?= $potential['supplierContact']?></td>
                                                <td class="doc"><?= $potential['supplierEmail']; ?></td>
                                                <td class="status1">
                                                    <?php 
                                                    if ($potential['status'] == 'Pending') {
                                                        echo "<span class='badge badge-warning'>Pending</span>";
                                                    } else if($potential['status'] == 'Approved') {
                                                        echo "<span class='badge badge-success'>Approved</span>";
                                                    }else {
                                                        echo "<span class='badge badge-danger'>Rejected</span>";
                                                    }
                                                 ?>
                                                </td>
                                                <td class="button">
                                                    <a href="viewPotentialS.php?potential_id=<?= $potential['potential_id']; ?>" class="btn btn-info btn-sm">View</a>
                                                    <a href="updatePotentialS.php?potential_id=<?= $potential['potential_id']; ?>" class="btn btn-success btn-sm">Update</a>
                                                    <button onclick="getRowClick(this)" class="btn btn-danger btn-sm">Delete</button>
                                                 
                                                </td>
                                            </tr>
                                            
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "<h5> No Record Found </h5>";
                                    }
                                ?>
                            </tbody>
                        </table>
                         <div id="id01" class="modal">
                            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close">×</span>
                            <form class="modal-content" action="codeDatabase.php" method="POST" >
                                <input type="hidden" name="selectPotentialID" id="selectPotentialID">
                                <div class="container1">
                                    <i class="fa fa-trash"></i><br>
                                    <h1>Delete Potential Supplier</h1>
                                    <p>Are you sure you want to delete this potential supplier ?</p>
                                    <div class="clearfix">
                                        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn btn btn-danger btn-sm">Cancel</button>
                                        <button type="submit" name="delete_potential" value="<?=$potential['potential_id'];?>" class="deletebtn btn btn-danger btn-sm">Delete</button>
                                    </div>
                                    <input type="hidden" name="imgold_file" id="imgold_file">
                                    <input type="hidden" name="biz_file" id="biz_file">
                                </div>
                            </form>
                       </div>
                    </div>
                </div><br>
            </div>
        </div>
    </div>
    <script src="jquery.min.js"></script>
    <script src="tether.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function () {
            
            $('#search').DataTable(); 
        });
        
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
          if (event.target == modal) {
            modal.style.display = "none";
          }
        }
       
        function getRowClick(rowButton){ 
            let tr = rowButton.parentElement.parentElement;
            let potentialID = tr.querySelector('td:first-child').innerText;
            let file = tr.querySelector('td:nth-child(2)').innerText;
            let file1 = tr.querySelector('td:nth-child(2)').innerText;

            document.getElementById('imgold_file').value = file;
            document.getElementById('biz_file').value = file1;
            document.getElementById('selectPotentialID').value = potentialID;
            document.getElementById('id01').style.display='block';
        } 
    </script>
    
     <style>
       
        .container{
            width: 1000px;
            font-family: 'Poppins', sans-serif;
        }
        
        .card-header{
            color:#17a2b8;
        }
        
        h4,table.dataTable thead td{
            text-align: center;
        }

        .fo{
            padding-top: 5px;
            text-align: center;
            font-size:2.0rem;
        }
        
        td.file{
            width:80px;
            vertical-align: middle;
        }
        
        td.status1{
            vertical-align: middle;
        }
        
        embed{
            vertical-align: middle;
        }
        
        td.id{
            width:40px;
            vertical-align: middle;
        }
        
        td.name{
            width:180px;
            vertical-align: middle;
        }
       
        td.button{
            text-align: center
        }
        
        td.nameF{
            width:80px;
            vertical-align: middle;
        }
        
        td.doc{
            width:140px;
            vertical-align: middle;
        }
        
        .btn-primary{
            margin-bottom:7px;
            background-color: #f845a2;
        }
        
        .btn-primary:hover{
            color:#fff;
            background-color:#ff99cc;
            border-color:#146c43
        }
        
        .btn-info{
            margin-bottom:5px;
            background-color: #0085fd;
            color: white;
        }
      
        .btn-danger {
            margin-bottom:5px; 
        }

        .btn-success{
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
        
        /* Float cancel and delete buttons and add an equal width */
        .cancelbtn, .deletebtn {
          text-align: center;
          width: 100px;
          height: 50px;
          font-size: 15px;
        }

        /* Add a color to the cancel button */
        .cancelbtn {
          background-color: white;
          color: black;
          border-color: black;
        }
        
        .cancelbtn:hover {
          color: white;
          cursor: pointer;
          background-color: blue;
        }

       .deletebtn:hover {
          background-color: red;
        }

        /* Add padding and center-align text to the container */
        .container1 {
          padding: 10px;
          text-align: center;
        }
        
        /* The Modal (background) */
        .modal {
          display: none; /* Hidden by default */
          position: fixed; /* Stay in place */
          z-index: 1; /* Sit on top */
          left: 0;
          top: 0;
          width: 100%; /* Full width */
          height: 100%; /* Full height */
          overflow: auto; /* Enable scroll if needed */
          background-color: rgba(255, 255, 255, 0.4);
          padding-top: 50px;
        }
        /* Modal Content/Box */
        .modal-content {
          background-color: white;
          z-index: -1; /*挡住的*/
          margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
          border: 2px solid #888;
          width: 40%; /* Could be more or less, depending on screen size */
          height: 50%;
        }

        /* The Modal Close Button (x) */
        .close {
          position: absolute;
          right: 400px;
          top:120px;
          font-size: 60px;
          font-weight: bold;
          color: black;
          display: block;
        }

        .close:hover, .close:focus {
          color: #f44336;
          cursor: pointer;
        }

        /* Clear floats */
        .clearfix::after {
          content: "";
          clear: both;
          display: table;
        }
        
        .fa{
          width: 50%;
          text-align: center;
          padding: 12px 0;
          transition: all 0.3s ease;
          color: black;
          font-size: 60px;
        }
        
        h1 {
            font-size: 30px;
            color: red;
            font-weight: bold;
        }
        
        p {
            padding-top: 15px;
            font-size: 15px;
            font-weight: bold;
            padding-bottom: 10px;
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
 
</body>
</html>
