<?php
    session_start();
    include('../navBar/purchasingManagerNavBar.php');
    include('../connection/dbCon.php');

    if(isset($_GET['from_date']) && isset($_GET['to_date']))
    {
        $con = mysqli_connect("localhost","root","","procurementsystem");
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];

    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/932c860bc2.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">   
    </head>
    <body>
        <div class="listOfRating">
            <div class="container">
                <div class="col-md-12">
                <div style="position:absolute; top:15px; right:100px;">
                <!-- <h4>Supplier Performance Rating</h4> -->
                    <a class="btn btn-sm btn-flat btn-default" href="maintainReport.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
                    <button onclick="window.print()"class="btn btn-sm btn-flat btn-success" style="margin-left: 10px;"><i class="fa fa-print"></i> Print</button>
                </div>
            </div>
            <div id="out_print">
                <div>
                    <img style="margin-left: 10px;" src="../png/company.jpg" alt="" height="150px">
                    <p style="text-align:right;" id="title">Printed on <?php echo date('d-m-Y')?></p>
                </div>
                <hr>
                <h3 class="text-center" id="title"><b>SUPPLIER PERFORMANCE RATING REPORT</b></h3>
                <p class="text-center" id="title">
                    <b>From : </b><?php echo $from_date ?> 
                    <b style="margin-left: 200px;"> To : </b><?php echo $to_date ?>
                </p>
                <table id="itemPurchase" class="table table-borderless">
                    <thead>
                     <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>PO ID</th>
                        <th>Quality (40%)</th>
                        <th>Delivery (30%)</th>
                        <th>Price (20%)</th>
                        <th>Service (10%)</th>
                        <th>Total Rating</th>
                     </tr>   
                    </thead>
                    <tbody>
                        <?php
                         $rating = $con->query("SELECT distinct(supplierID) from rating");
                            
                        while($rate = $rating -> fetch_assoc()){
                            $supplierID = $rate['supplierID'];
                            $supplier = $con -> query("SELECT DISTINCT(r.rateID),r.supplierID,s.companyName,r.po_id,r.quality,r.delivery,r.price,r.service,r.overallRating 
                                                            FROM rating r INNER JOIN supplier s ON s.supplierID = r.supplierID 
                                                            INNER JOIN po_details pd ON pd.po_id = r.po_id 
                                                            AND r.supplierID = '$supplierID'
                                                            WHERE pd.po_Date BETWEEN '$from_date' AND '$to_date'");
                            
                            $totalRating = 0;
                            $sumTotal = 0;
                            $averageRating = 0;
                            $no = 0;
                            $controlRow = true;
                            
                         while($row = $supplier -> fetch_assoc()){
                            
                            $supplierName = $row['companyName'];
                            $po_id = $row['po_id'];
                            $quality = $row['quality'];
                            $delivery = $row['delivery'];
                            $price = $row['price'];
                            $service = $row['service'];
                            $overallRating = $row['overallRating'];
                           // $totalRating = ($quality*0.4) + ($delivery*0.3) + ($price*0.2) + ($quality*0.1);
                            $sumTotal += $overallRating;
                            $no += 1;
                            $averageRating = $sumTotal / $no;
                            
                            if($controlRow){
                            echo '<tr>
                            <td>'.$supplierID.'</td>
                            <td>'.$supplierName.'</td>
                            <td>'.$po_id.'</td>
                            <td>'.$quality.'</td>
                            <td>'.$delivery.'</td>
                            <td>'.$price.'</td>
                            <td>'.$service.'</td>
                            <td>'.$overallRating.'</td>

                            </tr>';
                            $controlRow = false;
                        }else{
                            echo '<tr>
                            <td></td>
                            <td></td>
                            <td>'.$po_id.'</td>
                            <td>'.$quality.'</td>
                            <td>'.$delivery.'</td>
                            <td>'.$price.'</td>
                            <td>'.$service.'</td>
                            <td>'.$overallRating.'</td>

                            </tr>';
                        }
                    }
                        
                        if($averageRating != 0){
                            echo '<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="border-top border-bottom border-dark">Average : </td>
                            <td class="border-top border-bottom border-dark">'.$averageRating.'</td>
                            </tr>';
                            echo'<tr><td></td></tr>';
                            
                            }
                            
                    }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </body>
    <style>
        @media print{
        body {
            visibility: hidden;
        }
        #out_print{
            visibility: visible;
            position: absolute;
            top: 0;
        }
  
       
        }

    </style>
</html>
