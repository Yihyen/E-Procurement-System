<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';
?>

<html>
    <head>
        <title>Maintain Supplier</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css"/>

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    </head>

    <body>
        <br> <br>
        <h1 class="text-center text-info m-0">Supplier List</h1>
        <br> <br>
        <div class="container">
            <div class="table-responsive">
                <a href="addSupplier.php">
                    <button type="button" class="btn btn-primary">Add Supplier</button>
                </a>
                <br><br>
                <form action='' method='POST'>
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Supplier ID</th>
                                <th>Company Name</th>
                                <th>Registration Number</th>
                                <th>Supplier Address</th>
                                <th>Country</th>
                                <th>Supplier Contact</th>
                                <th>Supplier Email</th>
                                <th>Fax Number</th>
                                <th>Type Of Business</th>
                                <th>Catalog</th>
                                <th>Biz Profile</th>
                                <th>Supplier Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->prepare('SELECT * FROM supplier');
                            $stmt->execute();
                            $res = $stmt->get_result();

                            while ($row = $res->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $row['supplierID'] ?></td>
                                    <td><?= $row['companyName'] ?></td>
                                    <td><?= $row['registrationNum'] ?></td>
                                    <td><?= $row['supplierAddress'] ?></td>
                                    <td><?= $row['country'] ?></td>
                                    <td><?= $row['supplierContact'] ?></td>
                                    <td><?= $row['supplierEmail'] ?></td>
                                    <td><?= $row['faxNum'] ?></td>
                                    <td><?= $row['typeOfBusiness'] ?></td>
                                    <td><a href="../files/<?php echo $row['catalog']; ?>">Download</a></td>
                                    <td><a href="../files/<?php echo $row['bizProfile']; ?>">Download</a></td>
                                    <td><?= $row['supplier_status'] ?></td>
                                    
                                    <td>
                                        <a href="../administration/deleteSupplier.php?supplierID=<?= $row['supplierID'] ?>" class="btn btn-danger btn-block" onclick="return confirm('Are you sure want to remove this supplier?');">Remove</a>
                                    </td>

                                    <td>
                                        <a href="../administration/editSupplier.php?sid=<?php echo $row['supplierID']; ?>">
                                            <button type="button" class="btn btn-primary" data-id="<?php echo $row['supplierID'] ?>">Edit</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <br>
        </div>
        
        <script language="javascript" type="text/javascript">
            document.title = "Maintain Supplier";

            $(document).ready(function () {
                $('table').DataTable();
            });
        </script>
        
    </body>
</html>
