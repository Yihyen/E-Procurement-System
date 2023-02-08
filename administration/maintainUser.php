<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';
?>

<html>
    <head>
        <title>Maintain User</title>

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
        <br>
        <br>
        <h1 class="text-center text-info m-0">User List</h1>
        <br>
        <div class="container">
            <div class="table-responsive mt-12">
                <a href="../administration/addUser.php">
                    <button type="button" class="btn btn-primary">Add User</button>
                </a>
                <br><br>
                <form action='' method='POST'>
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact No</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Job Position</th>
                                <th>User Role</th>
                                <th>User Status</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->prepare('SELECT * FROM user');
                            $stmt->execute();
                            $res = $stmt->get_result();

                            while ($row = $res->fetch_assoc()):
                                ?>
                                <tr>
                                    <td><?= $row['user_id'] ?></td>
                                    <td><?= $row['user_name'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['user_email'] ?></td>
                                    <td><?= $row['user_contact'] ?></td>
                                    <td><?= $row['user_gender'] ?></td>
                                    <td><?= $row['user_address'] ?></td>
                                    <td><?= $row['branch'] ?></td>
                                    <td><?= $row['department'] ?></td>
                                    <td><?= $row['job_position'] ?></td>
                                    <td><?= $row['user_role'] ?></td>
                                    <td><?= $row['user_status'] ?></td>

                                    <td>
                                        <a href="../administration/deleteUser.php?userID=<?= $row['user_id'] ?>" class="btn btn-danger btn-block" onclick="return confirm('Are you sure want to remove this user?');">Remove</a>
                                    </td>

                                    <td>
                                        <a href="../administration/editUser.php?uid=<?php echo $row['user_id']; ?>">
                                            <button type="button" class="btn btn-primary" data-id="<?php echo $row['user_id'] ?>">Edit</button>
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
            document.title = "Maintain User";

            $(document).ready(function () {
                $('table').DataTable();
            });
        </script>

    </body>
</html>
