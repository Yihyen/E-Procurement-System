<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

$db_server = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'procurementsystem';
$con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

?>

<head>
    <meta charset="UTF-8">
    <title>Purchase Orders</title>
    <!-- <link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/main.2.8.css" rel="stylesheet" type="text/css">
    <link href="css/responsive1.1.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-multiEmail.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link href="css/responsive.dataTables.min.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrapValidator.css" rel="stylesheet" type="text/css">
    <link href="css/notification.css" rel="stylesheet" type="text/css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .container {
            margin-top: 5%;
        }
    </style>

</head>

<body>
    <div class="container">
        <h1>Purchase Orders</h1>
        <form action="" method="GET">
            <table class="table table-striped table-bordered table-hover" id="sample_1">
                <thead>
                    <tr>
                        <th>Purchase Order ID</th>
                        <th>Supplier ID</th>
                        <!-- <th>Item Description</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_GET['supplierID'])) {
                        $_SESSION['supplierID'] = $_GET['supplierID'];
                        $supplierID = $_SESSION['supplierID'];
                        //$query = "SELECT orderInfo.orderID, orderInfo.supplierID, orderInfo.itemDesc, rating.averageRating FROM orderInfo INNER JOIN rating ON orderInfo.orderID = rating.orderID";
                        $query = "SELECT * FROM po_details WHERE supplierID='$supplierID' GROUP BY po_id";
                        //check if po_id from po_details is rated and store in rating table
                        // $query2 = "SELECT * FROM rating WHERE po_id IN (SELECT po_id FROM po_details WHERE supplierID='$supplierID')";
                        $result = mysqli_query($con, $query);
                        // $result2 = mysqli_query($con, $query2);
                        // while ($row2 = mysqli_fetch_array($result2)) {
                            while ($row = mysqli_fetch_array($result)) {

                                echo "<tr>";
                                echo "<td>" . $row['po_id'] . "</td>";
                                echo "<td>" . $row['supplierID'] . "</td>";
                                // echo "<td>".$row['itemDesc']."</td>";
                    
                                //use loop to check if po_id is rated
                                // if ($row['po_id'] == $row2['po_id']) {
                                //     echo "<td><a style='text-decoration: none;' href='rating.php?po_id=" . $row['po_id'] . "' id='rate' onclick='disableButton()'>Rated</a></td>";
                                // } else {
                                //     echo "<td><a style='text-decoration: none;' href='rating.php?po_id=" . $row['po_id'] . "' id='rate'>Rate</a></td>";
                                // }

                                echo "<td><a style='text-decoration: none;' href='rating.php?po_id=" . $row['po_id'] . "' onchange='this.disabled=true'>Rate</a></td>";
                                echo "</tr>";

                            }
                        }
                    // }
                    ?>
                </tbody>
            </table>

            <div>

                <button class="btn btn-primary" type="submit" name="back"><a href="index.php"
                        style="text-decoration: none; color: white;">Back</a></button>

            </div>

        </form>
    </div>
</body>

</html>

<script>

    function disableButton() {
        document.getElementById("rate").innerHTML = "Rated";
        //make the hover disable
        document.getElementById("rate").style.pointerEvents = "none";
        //remove the link
        document.getElementById("rate").removeAttribute("href");


    }


</script>