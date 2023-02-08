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
    
    <title>Status</title>
    
</head>
<body>
    <div class="container mt-4">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fo">Application status</h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                        <!----Section2 for showing Pending ---->
                        <section id="post">
                            <div class="container">
                                <div class="row">
                                    <table id="search" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <th>ID</th>
                                            <th>Company Name</th>
                                            <th>Type of Business</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($_GET['potential_id'])){
                                                $potential_id = mysqli_real_escape_string($con, $_GET['potential_id']);
                                                $query = "SELECT * FROM potential_supplier WHERE potential_id='$potential_id' ";
                                                $query_run = mysqli_query($con, $query);
                                                
                                                if(mysqli_num_rows($query_run) > 0){
                                                    $result = mysqli_fetch_array($query_run);
                                                     ?>
                                                    <tr>
                                                        <td><?php echo $result['potential_id']; ?></td>
                                                        <td><?php echo $result['companyName']; ?></td>
                                                        <td><?php echo $result['typeOfBusiness']; ?></td>
                                                        <td><?php echo $result['supplierEmail']; ?></td>
                                                        <td><?php
                                                            if ($result['status'] == 'Pending') {
                                                                echo "<span class='badge badge-warning'>Pending</span>";
                                                            } else if($result['status'] == 'Approved') {
                                                                echo "<span class='badge badge-success'>Approved</span>";
                                                            }else {
                                                                echo "<span class='badge badge-danger'>Rejected</span>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><a href="supplierView.php?potential_id=<?= $result['potential_id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                                    </tr><?php
                                                    }
                                            }
                                           
                                            ?>
                                              
                                        </tbody>
                                    </table>
                                 </div>
                            </div>
                        </section>

                        <!-- Creating Modal -->
                        <!-- Pending -->
                        <div class="modal fade" id="addPostModal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-white">
                                        <div class="modal-title">
                                            <h5>Pending Status List</h5>
                                        </div>
                                        <button class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Company Name</th>
                                                <th>View</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM potential_supplier WHERE status = 'Pending'";
                                                $que = mysqli_query($con, $sql);
                                                $cnt = 1;
                                                while ($result = mysqli_fetch_assoc($que)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $cnt; ?></td>
                                                        <td><?php echo $result['potential_id']; ?></td>
                                                        <td><?php echo $result['companyName']; ?></td>
                                                        <td><a href="viewPotentialS1.php?potential_id=<?= $result['potential_id']; ?>" class="btn btn-info btn-sm">View</a></td>
                                                        <td>
                                                            <?php
                                                            if ($result['status'] == 'Pending') {
                                                                echo "<span class='badge badge-warning'>Pending</span>";
                                                                ?>
                                                        </td>
                                                        <td>
                                                            <form action="codeDatabase.php?potential_id=<?php echo $result['potential_id']; ?>" method="POST">
                                                                <input type="hidden" name="appid" value="<?php echo $result['potential_id']; ?>">
                                                                <input type="submit" class="btn btn-sm btn-success" name="approve" value="Approve">
                                                                <input type="submit" class="btn btn-sm btn-danger" name="reject" value="Reject">
                                                            </form>
                                                        </td>
                                                            <?php
                                                            } else if($result['status'] == 'Approved') {
                                                                echo "Approved";
                                                            }else {
                                                                echo "Rejected";
                                                            }
                                                            $cnt++;
                                                }
                                                ?>  </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--Approved-->
                        <div class="modal fade" id="addCateModal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <div class="modal-title">
                                            <h5>Approved List</h5>
                                        </div>
                                        <button class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Company Name</th>
                                                <th>Type of Business</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM potential_supplier WHERE status = 'Approved'";
                                                $que = mysqli_query($con, $sql);
                                                $cnt = 1;
                                                while ($result = mysqli_fetch_assoc($que)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $result['potential_id']; ?></td>
                                                    <td><?php echo $result['companyName']; ?></td>
                                                    <td><?php echo $result['typeOfBusiness']; ?></td>
                                                    <td><?php echo $result['supplierEmail']; ?></td>
                                                    <td><?php
                                                        if ($result['status'] == 'Pending') {
                                                            echo "<span class='badge badge-warning'>Pending</span>";
                                                        } else if($result['status'] == 'Approved') {
                                                            echo "<span class='badge badge-success'>Approved</span>";
                                                        } else {
                                                            echo "<span class='badge badge-danger'>Rejected</span>";
                                                        }
                                                        $cnt++;
                                                }?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Rejected -->
                        <div class="modal fade" id="addUsertModal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <div class="modal-title">
                                            <h5>Rejected List</h5>
                                        </div>
                                        <button class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <th>#</th>
                                                <th>ID</th>
                                                <th>Company Name</th>
                                                <th>Type of Business</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM potential_supplier WHERE status = 'Rejected'";
                                                $que = mysqli_query($con, $sql);
                                                $cnt = 1;
                                                while ($result = mysqli_fetch_assoc($que)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $result['potential_id']; ?></td>
                                                    <td><?php echo $result['companyName']; ?></td>
                                                    <td><?php echo $result['typeOfBusiness']; ?></td>
                                                    <td><?php echo $result['supplierEmail']; ?></td>
                                                    <td><?php
                                                        if ($result['status'] == 'Pending') {
                                                            echo "<span class='badge badge-warning'>Pending</span>";
                                                        } else if($result['status'] == 'Approved') {
                                                            echo "<span class='badge badge-success'>Approved</span>";
                                                        }else {
                                                            echo "<span class='badge badge-danger'>Rejected</span>";
                                                        }
                                                        $cnt++;
                                                } ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div><br>
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
    </script>
    
    <style>
        .mt-4{
            width: 1000px;
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

