<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

$res = $con->query("SELECT * FROM company LIMIT 1")->fetch_array();
?>

<html>
    <head>
        <title>Purchase Budget</title>

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
        <br><br>
        <h1 class="text-center text-info m-0">Purchase Budget</h1>
        <br> <br>
        <div class="container">
            <div class="table-responsive">
                <a href="../administration/addPurchaseBudget.php">
                    <button type="button" class="btn btn-primary">Add Purchase Budget</button>
                </a>
                <br><br>
                <form action='' method='POST'>
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Budget ID</th>
                                <th>User ID</th>
                                <th>Budget Amount (<?php echo $res['currency']; ?>) </th>
                                <th>Budget Description</th>
                                <th>Date Created</th>
                                <th>Budget Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->prepare('SELECT * FROM purchasebudget');
                            $stmt->execute();
                            $res = $stmt->get_result();

                            while ($row = $res->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $row['budget_id'] ?></td>
                                    <td><?= $row['user_id'] ?></td>
                                    <td><?= $row['budget_amount'] ?></td>
                                    <td><?= $row['budget_description'] ?></td>
                                    <td><?= $row['date_created'] ?></td>
                                    <td><?= $row['budget_status'] ?></td>

                                    <td>
                                        <a href="../administration/deletePurchaseBudget.php?removeBudget=<?= $row['budget_id'] ?>" class="btn btn-danger btn-block" onclick="return confirm('Are you sure want to remove this purchase budget?');">Remove</a>
                                    </td>

                                    <td>
                                        <a href="../administration/editPurchaseBudget.php?budgetID=<?php echo $row['budget_id']; ?>">
                                            <button type="button" class="btn btn-primary" data-id="<?php echo $row['budget_id'] ?>">Edit</button>
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
            document.title = "Maintain Purchase Budget";

            $(document).ready(function () {
                $('table').DataTable();
            });
        </script>
        
    </body>
</html>
