<?php
      session_start();
      include('../navBar/purchasingManagerNavBar.php');
      include('../connection/dbCon.php');

    if(isset($_GET['from_date']) && isset($_GET['to_date']))
    {
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];
    }

    if(isset($_GET['productName']))
    {
        $productName = $_GET['productName'];

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
        <div class="container">
            <div class="col-md-12">
                <div style="position:absolute; top:15px; right:100px;">
                    <!-- <h4>Quotation Comparison</h4> -->
                    <a class="btn btn-sm btn-flat btn-default" href="maintainReport.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
                <button onclick="window.print()"class="btn btn-sm btn-flat btn-success" style="margin-left: 10px;"><i class="fa fa-print"></i> Print</button>
                </div>
                <div id="out_print">
                    <div>
                        <img style="margin-left: 10px;" src="../png/company.jpg" alt="" height="150px">
                        <p style="text-align:right;" id="title">Printed on <?php echo date('d-m-Y')?></p>
                    </div>
                    <hr>
                    <h3 class="text-center" id="title"><b>QUOTATION COMPARISON REPORT</b></h3>
                    <p class="text-center" id="title">
                        <b>From : </b><?php echo $from_date ?> 
                        <b style="margin-left: 200px;"> To : </b><?php echo $to_date ?>
                    </p>
                    <table class="table table-bordered">
             
                    <tbody>
                    <b> Item : </b> <?php echo $productName ?>
                            <?php 
                            $quotation = $con -> query("SELECT * FROM rfq WHERE productName = '$productName' AND RFQ_Start_Date BETWEEN '$from_date' AND '$to_date'");
                   
                            $productName = '';
                            $RFQNo = '';
                            $supplierID = '';
                            $supplierEmail = '';
                            $productQty = '';
                            $amount = '';
                            $no = "";
                            $number = 0;
                            
                            while($row = mysqli_fetch_assoc($quotation)){
                                    $productName .= $row['productName'];
                                    $RFQNo .= "<td>".$row['RFQNo']."</td>";
                                    $supplierID .= "<td>".$row['supplierID']."</td>";
                                    $supplierEmail .= "<td>".$row['supplierEmail']."</td>";
                                    $productQty .= "<td>".$row['productQty']."</td>";
                                    $amount .= "<td>".$row['amount']."</td>";
                                    $number += 1;
                                    $no .= "<td>". $number ."</td>";
                            }
                            // } ?>
                            
                            
                            <div style="margin-top: 10px;">
                            <tr>
                                <th>No.</th>
                                <?php echo $no;?>
                            </tr>
                            <tr>
                                <th>Quotation</th>
                                    
                                    <?php echo $RFQNo; ?>
                                    
                            </tr>
                            <tr>
                                <th>Supplier ID</th>
                                    <?php  echo $supplierID; ?>
                                    
                            </tr>
                            <tr>
                                <th>Supplier Email</th>
                                    <?php echo $supplierEmail; ?>
                                    
                            </tr>
                            <tr>
                                <th>Quantity</th>
                                    <?php echo $productQty; ?>
                            </tr>
                            <tr>
                                <th>Price</th>
                                    <?php echo $amount; ?>
                            </tr>
               
                          </div>
                
                       
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
            margin-left: 60px;
        }
  
       
         }
    </style>
</html>
