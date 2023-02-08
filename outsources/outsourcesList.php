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
    
    <title>Outsourcing Company List</title>
    
</head>
<body>
    <div class="container mt-4">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fo">Outsourcing Company List
                            <a href="addOutsourcesList.php" class="btn btn-primary float-end">Add</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <!----Section2 for Invite ---->
                        <section id="post">
                            <div class="container">
                                <div class="row">
                                    <table id="search" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <th>ID</th>
                                            <th>Company Name</th>
                                            <th>Contact</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                            <th>Status</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM outsourcerlist";
                                            $que = mysqli_query($con, $sql);
                                            while ($result = mysqli_fetch_assoc($que)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $result['id']; ?></td>
                                                <td><?php echo $result['outsourcerName']; ?></td>
                                                <td><?php echo $result['contactNumber']; ?></td>
                                                <td><?php echo $result['email']; ?></td>
                                                <td class="button">
                                                    <a href="readOutsources.php?id=<?= $result['id']; ?>" class="btn btn-info btn-sm">View</a>
                                                    <a href="updateOutsourcesList.php?id=<?= $result['id']; ?>" class="btn btn-success btn-sm">Update</a>
                                                    <button onclick="getRowClick(this)" class="btn btn-danger btn-sm">Delete</button>
                                                </td>
                                                <td><?php
                                                    if ($result['status'] == 'Invite') {
                                                        ?> 
                                                            <form action="codeDatabase.php?id=<?php echo $result['id'];?>&cmpName=<?php echo $result['outsourcerName'];?>&contact=<?php echo $result['contactNumber'];?>&email=<?php echo $result['email'];?>&serviceType=<?php echo $result['serviceType'];?>" method="POST">
                                                                <input type="hidden" name="appid" value="<?php echo $result['id']; ?>">
                                                                <button type="submit" name="invite" value="Invite" class="badge badge-warning">Invite</button> 
                                                            </form>
                                                    <?php
                                                    }else {
                                                        echo "<span class='badge badge-danger'>Invited</span>";
                                                    }
                                            }
                                            ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div id="id01" class="modal">
                                        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close">×</span>
                                        <form class="modal-content" action="codeDatabase.php" method="POST" >
                                            <input type="hidden" name="selectListID" id="selectListID">
                                            <div class="container1">
                                                <i class="fa fa-trash"></i><br>
                                                <h1>Delete Outsources List</h1>
                                                <p>Are you sure you want to delete this list ?</p>
                                                <div class="clearfix">
                                                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn btn btn-danger btn-sm">Cancel</button>
                                                    <button type="submit" name="delete" class="deletebtn btn btn-danger btn-sm">Delete</button>
                                                </div>  
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div><br>
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
            let ListID = tr.querySelector('td:first-child').innerText;
            document.getElementById('selectListID').value = ListID;
            document.getElementById('id01').style.display='block';
        }
    </script>
    
    <style>
        .mt-4{
            width: 1040px;
            font-family: 'Poppins', sans-serif;
        }
        .card-header{
            color:#17a2b8;
        }
        .fo{
            text-align: center;
        }
        .model.modal-title h5{
            text-align: center;
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

    </style>
</body>
</html>

