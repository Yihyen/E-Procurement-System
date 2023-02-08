<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

$res = $con->query("SELECT * FROM company LIMIT 1")->fetch_array();
?>

<html>
    <head>
        <title>Maintain Inventory</title>

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
        <h1 class="text-center text-info m-0">Inventory List</h1>
        <br> <br>
        <div class="container">
            <div class="table-responsive mt-12">
                <a href="addItem.php">
                    <button type="button" class="btn btn-primary">Add Item</button>
                </a>
                <br><br>
                <form action='' method='POST'>
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Category ID</th>
                                <th>Item Name</th>
                                <th>Item Description</th>
                                <th>Quantity</th>
                                <th>Unit Price (<?php echo $res['currency']; ?>)</th>
                                <th>Item Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->prepare('SELECT * FROM inventory');
                            $stmt->execute();
                            $res2 = $stmt->get_result();

                            while ($row = $res2->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $row['item_id'] ?></td>
                                    <td><?= $row['cat_id'] ?></td>
                                    <td><?= $row['item_name'] ?></td>
                                    <td><?= $row['item_description'] ?></td>
                                    <td><?= $row['item_quantity'] ?></td>
                                    <td><?= $row['item_unit_price'] ?></td>
                                    <td><?= $row['item_status'] ?></td>

                                    <td>
                                        <a href="../administration/deleteItem.php?itemID=<?= $row['item_id'] ?>" class="btn btn-danger btn-block" onclick="return confirm('Are you sure want to remove this item?');">Remove</a>
                                    </td>

                                    <td>
                                        <a href="../administration/editItem.php?itemid=<?php echo $row['item_id']; ?>">
                                            <button type="button" class="btn btn-primary" data-id="<?php echo $row['item_id'] ?>">Edit</button>
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
            document.title = "Maintain Inventory";

            $(document).ready(function () {
                $('table').DataTable();
            });
        </script>
        
    </body>
</html>
