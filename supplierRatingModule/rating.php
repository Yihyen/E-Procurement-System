<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

include_once 'dbconnect.php';
$con = dbcon();

$sql = "SELECT rateID FROM rating ORDER BY rateID ASC";
$result = mysqli_query($con, $sql);
$lastid = NULL;
while($row = mysqli_fetch_array($result)){
    $lastid = $row['rateID'];
}

if ($lastid == NULL) {
    $number = "RT0001";
} else {
    $idd = str_replace("RT", "", $lastid);
    $id = str_pad($idd + 1, 4, 0, STR_PAD_LEFT);
    $number = 'RT' . $id;
}
?>
<!DOCTYPE html>
<html lang="en">

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
            margin-top: 3%;
        }

        .calBtn {

            background-color: blue;
            border: none;
            color: white;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
        }

        .saveBtn {
            background-color: green;
            border: none;
            color: white;
            text-align: center;
            font-size: 16px;
            cursor: pointer;

        }

        .bckBtn {
            background-color: blue;
            border: none;
            color: white;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            float: right;


        }

        h1 {
            text-align: left;
            color: midnightblue;
        }
    </style>

</head>

<body>
    <?php
    $qualityEmptyError = $deliveryEmptyError = $priceEmptyError = $serviceError = "";
    $quality = $delivery = $price = $service = "";
    $qualityWeight = $deliveryWeight = $priceWeight = $serviceWeight = "";
    $totalRating = $qualityScore = $deliveryScore = $priceScore = $serviceScore = $totalScore = "";
    $averageRating = "";

    if (isset($_POST['calculate'])) {
        $quality = $_POST['quality'];
        $delivery = $_POST['delivery'];
        $price = $_POST['price'];
        $service = $_POST['service'];


        if (empty($quality)) {
            $qualityEmptyError = "Please enter 0-5 rating for quality";
        }

        if (empty($delivery)) {
            $deliveryEmptyError = "Please enter 0-5 rating for delivery";
        }

        if (empty($price)) {
            $priceEmptyError = "Please enter 0-5 rating for price";
        }

        if (empty($service)) {
            $serviceError = "Please enter 0-5 rating for service";
        } //else if($service != 40 && $service != 70 && $service != 100){
        //$serviceError = "Only 40, 70 OR 100 rating for service";
        else {
            $qualityWeight = 40;
            $deliveryWeight = 30;
            $priceWeight = 20;
            $serviceWeight = 10;
            //$service = $service/100;
            $totalRating = 5;

            $qualityScore = $quality / $totalRating * $qualityWeight;
            $deliveryScore = $delivery / $totalRating * $deliveryWeight;
            $priceScore = $price / $totalRating * $priceWeight;
            $serviceScore = $service / $totalRating * $serviceWeight;

            $totalScore = $qualityScore + $deliveryScore + $priceScore + $serviceScore;

            $averageRating = $totalScore / 100 * 5;

            $supplierID = $_SESSION['supplierID'];
            $_SESSION['po_id'] = $_GET['po_id'];

        }

    } else if (isset($_POST['rateID']) && isset($_POST['save'])) {
       
        $rateID = $_POST['rateID'];
        $quality = $_POST['quality'];
        $delivery = $_POST['delivery'];
        $price = $_POST['price'];
        $service = $_POST['service'];
        $qualityScore = $_POST['qualityScore'];
        $deliveryScore = $_POST['deliveryScore'];
        $priceScore = $_POST['priceScore'];
        $serviceScore = $_POST['serviceScore'];
        $totalScore = $_POST['totalScore'];
        $averageRating = $_POST['averageRating'];

        $con = mysqli_connect("localhost", "root", "", "procurementsystem");

        $sql = "INSERT INTO rating (rateID, supplierID, po_id, quality, delivery, price, service, overallQuality, overallDelivery, overallPrice, overallService, overallRating) VALUES ('$rateID', '$_SESSION[supplierID]', '$_SESSION[po_id]', '$quality', '$delivery', '$price', '$service', '$qualityScore', '$deliveryScore', '$priceScore', '$serviceScore', '$averageRating')";

        $result = mysqli_query($con, $sql);

        if ($result) {
            // $sql = 'UPDATE supplier SET supplierRating = (SELECT AVG(overallRating) FROM rating WHERE supplierID = "'.$_SESSION['supplierID'].'") WHERE supplierID ="'.$_SESSION['supplierID'].'"';

            // $result = mysqli_query($con, $sql);

            // if ($result) {
                 echo "<script>alert('Rating saved successfully!')</script>";

            //     // echo "<script>window.location.href = 'rating.php?orderID=$_SESSION[orderID]';</script>";
                 echo "<script>window.location.href = 'index.php';</script>";

            // }

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

    }

    ?>
    <div class="container">
        <h1>Rating for PO
            <?php echo $_GET['po_id']; ?>

            <button class="bckBtn"
                onclick="window.location.href = 'orders.php?supplierID=<?php echo $_SESSION['supplierID']; ?>';">Back</button>
        </h1>
        <label>
            <h3>Evaluate the supplier</h3>
        </label>

        <form action="#" method="POST">
        <div class="col-md-3">
            <label for="rateID"><b>Rate ID</b></label>
            <input text="text" name="rateID" id="rateID" class="form-control" value="<?php echo $number; ?>"
                readonly></br>
        </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Factor</th>
                        <th>Weight</th>
                        <th>How Measured</th>
                        <th>Supplier Rating</th>
                        <th>Supplier Score</th>
                    </tr>
                </thead>

                <tr>
                    <th>Quality</th>
                    <th>40</th>
                    <td>Worst - Best: 0 -5</td>
                    <td><input type="number" name="quality" min="1" max="5" value="<?php echo $quality; ?>"><span
                            class="error"> *
                            <?php echo $qualityEmptyError; ?>
                        </span></td>

                    <td><input type="number" name="qualityScore" value="<?php echo $qualityScore; ?>"
                            style="background:#e6e4e3;" readonly></td>
                </tr>

                <tr>
                    <th>Delivery</th>
                    <th>30</th>
                    <td>Worst - Best: 0 -5</td>
                    <td><input type="number" name="delivery" min="1" max="5" value="<?php echo $delivery; ?>"><span
                            class="error"> *
                            <?php echo $deliveryEmptyError; ?>
                        </span></td>

                    <td><input type="number" name="deliveryScore" style="background:#e6e4e3;"
                            value="<?php echo $deliveryScore; ?>" readonly></td>
                </tr>

                <tr>
                    <th>Price</th>
                    <th>20</th>
                    <td>Worst - Best: 0 -5</td>
                    <td><input type="number" name="price" min="1" max="5" value="<?php echo $price; ?>"><span
                            class="error"> *
                            <?php echo $priceEmptyError; ?>
                        </span></td>

                    <td><input type="number" name="priceScore" style="background:#e6e4e3;"
                            value="<?php echo $priceScore; ?>" readonly></td>
                </tr>

                <tr>
                    <th>Service</th>
                    <th>10</th>
                    <td>Worst - Best: 0 -5</td>
                    <td><input type="number" name="service" min="1" max="5" value="<?php echo $service; ?>"><span
                            class="error"> *
                            <?php echo $serviceError; ?>
                        </span></td>

                    <td><input type="number" name="serviceScore" style="background:#e6e4e3;"
                            value="<?php echo $serviceScore; ?>" readonly></td>
                </tr>

                <tr>
                    <th>Total Points</th>
                    <th>100</th>
                    <td></td>
                    <td><button type="submit" name="calculate" class="calBtn">Calculate</button></td>
                    <td><input type="number" name="totalScore" style="background:#e6e4e3;"
                            value="<?php echo $totalScore; ?>"></td>
                </tr>

                <tr>
                    <th>Average Rating</th>
                    <th></th>
                    <td></td>
                    <td></td>
                    <td><input type="number" name="averageRating" style="background:#e6e4e3;"
                            value="<?php echo $averageRating; ?>" readonly></td>
                </tr>

                <tr>
                    <th></th>
                    <th></th>
                    <td></td>
                    <td></td>
                    <td><button type="submit" name="save" class="saveBtn">Save</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>