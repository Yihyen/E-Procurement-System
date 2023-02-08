<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';
?>

<html>
    <head>
        <title>Maintain Item Category</title>

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
        <h1 class="text-center text-info m-0">Item Category List</h1>
        <br> <br>
        <div class="container">
            <div class="table-responsive mt-12">
                <a href="../administration/addItemCategory.php">
                    <button type="button" class="btn btn-primary">Add Item Category</button>
                </a>
                <br><br>
                <form action='' method='POST'>
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>Category ID</th>
                                <th>Category Name</th>
                                <th>Category Description</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->prepare('SELECT * FROM itemcategory');
                            $stmt->execute();
                            $res = $stmt->get_result();

                            while ($row = $res->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $row['cat_id'] ?></td>
                                    <td><?= $row['cat_name'] ?></td>
                                    <td><?= $row['cat_description'] ?></td>

                                    <td>
                                        <a href="../administration/deleteItemCategory.php?itemCatID=<?= $row['cat_id'] ?>" class="btn btn-danger btn-block" onclick="return confirm('Are you sure want to remove this item category?');">Remove</a>
                                    </td>

                                    <td>
                                        <a href="../administration/editItemCategory.php?icid=<?php echo $row['cat_id']; ?>">
                                            <button type="button" class="btn btn-primary" data-id="<?php echo $row['cat_id'] ?>">Edit</button>
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
            document.title = "Maintain Item Category";

            $(document).ready(function () {
                $('table').DataTable();
            });
        </script>
        
    </body>
</html>
