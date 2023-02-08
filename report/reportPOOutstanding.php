<?php
    session_start();
    include('../navBar/purchasingManagerNavBar.php');
    include('../connection/dbCon.php');
   
    if(isset($_GET['from_date']) && isset($_GET['to_date']))
    {
        $con = mysqli_connect("localhost","root","","procurementsystem");
        $from_date = $_GET['from_date'];
        $to_date = $_GET['to_date'];

        $query = "SELECT o.*, p.po_status FROM purchaseorder p, po_details o WHERE p.po_id = o.po_id AND o.po_Date BETWEEN '$from_date' AND '$to_date' AND p.po_status = 'Approved'";
        $query_run = mysqli_query($con, $query);
    }
?>

<!DOCTYPE html>
<html lang="en">
    
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
                <!-- <h4>Outstanding PO</h4> -->
                <a class="btn btn-sm btn-flat btn-default" href="maintainReport.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
                <!-- <a class="btn btn-sm btn-flat btn-default" href="cancelledPO.php"><i class="fa-solid fa-arrow-left"></i> Back</a> -->
                <button onClick="window.print()" class="btn btn-sm btn-flat btn-success" style="margin-left: 10px;"><i class="fa fa-print"></i> Print</button>
            </div>
            <div id="out_print">
                <img style="margin-left: 10px;" src="../png/company.jpg" alt="" height="200px">
                <h2 class="text-center d-inline-block" style="position:absolute; top:90px; right:50px;" id="title"><b>OUTSTANDING PURCHASE ORDER</b></h2>
                <div>
                    <p class="justify-content-end" style="position:absolute; top:150px; right:50px; text-align:right;" id="title">Printed on <?php echo date('d-m-Y')?></p>
                </div>
            </div>
            <div style="margin-left: 50px;" id="out_print">
                <b>From : </b><?php echo $from_date ?> 
                <b style="margin-left: 200px;"> To : </b><?php echo $to_date ?>
                <hr>
            </div>
          

            <div class="card-body" id="out_print">
                <table class="table table-borderless" id="outstandingPO">
                    <thead>
                    <tr>
                      
                        <th>PO Number</th>
                        <th>Remark</th>
                        <th>Date Created</th>
                        <th>Supplier</th>
                        <th>Items</th>
                        <th>Quantity</th>
                        <th>Item Price</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                      $po_details = $con->query("SELECT distinct(po_id) FROM po_details");
                      while($row = $po_details->fetch_assoc()) {
                          $po_id = $row['po_id'];
                          $po = $con->query("SELECT * FROM purchaseorder po , po_details pd WHERE pd.po_id = po.po_id AND pd.po_id = '$po_id' AND pd.po_Date BETWEEN '$from_date' AND '$to_date' AND po.po_status = 'Approved';");
                          $poOrderTotal = 0;
                          $controlRow = true;

                          while($row_detail = $po->fetch_assoc()) {
                              $po_Date = $row_detail['po_Date'];
                              $supplierID = $row_detail['supplierID'];
                              $item_id = $row_detail['item_id'];
                              $po_status = $row_detail['po_status'];
                              $po_remark = $row_detail['po_remark'];
                              $po_itemQty = $row_detail['po_itemQty'];
                              $po_itemPrice = $row_detail['po_itemPrice'];
                              $po_orderTotal = $row_detail['po_orderTotal'];
                              
                              $poOrderTotal += $po_orderTotal;
                              if($controlRow){
                                echo '<tr>
                                <td scope="row">'.$po_id.'</td>
                                <td>'.$po_remark.'</td>
                                <td>'.$po_Date.'</td>
                                <td>'.$supplierID.'</td>
                                <td>'.$item_id.'</td>
                                <td>'.$po_itemQty.'</td>
                                <td>'.$po_itemPrice.'</td>
                                <td>'.$po_orderTotal.'</td>
                               <tr>';
                                 $controlRow = false;
                            }else{
                                echo '<tr>
                                <td scope="row"></td>
                                <td></td>
                                <td>'.$po_Date.'</td>
                                <td>'.$supplierID.'</td>
                                <td>'.$item_id.'</td>
                                <td>'.$po_itemQty.'</td>
                                <td>'.$po_itemPrice.'</td>
                                <td>'.$po_orderTotal.'</td>
                               <tr>';
                            }
                    }
                     if($poOrderTotal != 0) {
                         echo '<tr>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td class="border-top border-bottom border-dark">Total : </td>
                         <td class="border-top border-bottom border-dark">'.$poOrderTotal.'</td>
                         </tr>';
                         echo'<tr><td></td></tr>';
                     }
                    } ?>
            
                        
                        
                    </tbody>
                </table>
        </div>
        </div>
        </div>

        <script>
            $(document).ready(function() {
                date = new Date().toLocaleDateString("de-DE");
                $('#currentDate').val(date);
            })
        </script>
    </body>

        <style>
            @media print{
            body {
                visibility: hidden;
            }
            #out_print{
                visibility: visible;

            }
            #title{
                position: absolute;
                top: 0px;
                right: 0px;
            }
        
        }

    </style>
    