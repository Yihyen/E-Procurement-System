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
    <div class="listOfItem"> 
  <div class="container" >
        <div class="col-md-12"> 
            <div style="position:absolute; top:15px; right:100px;">
                <!-- <h4>Total Purchase by Item</h4> -->
                <a class="btn btn-sm btn-flat btn-default" href="maintainReport.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
                <button onclick="window.print()"class="btn btn-sm btn-flat btn-success" style="margin-left: 10px;"><i class="fa fa-print"></i> Print</button>
            </div>
            <div id="out_print">
            <div>
                <img style="margin-left: 10px;" src="../png/company.jpg" alt="" height="150px">
                <p style="text-align:right;" id="title">Printed on <?php echo date('d-m-Y')?></p>
            </div>
            <hr>
            <h3 class="text-center" id="title"><b>TOTAL PURCHASE BY ITEM ANALYSIS REPORT</b></h3>
            <p class="text-center" id="title">
                <b>From : </b><?php echo $from_date ?> 
                <b style="margin-left: 200px;"> To : </b><?php echo $to_date ?>
            </p>
                <table id="itemPurchase" class="table table-borderless">
                    <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Category ID</th>
                        <th>Quantity</th>
                        <th>Order Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 

                // $inventory = $connection->query("SELECT SUM(po_itemQty) AS quantity, SUM(po_orderTotal) AS orderTotal FROM po_details WHERE item_id = ''");
                // $item = $connection -> query("SELECT * FROM inventory i, po_details pd WHERE i.item_id = pd.item_id");
                $po_details = $con->query("SELECT distinct(item_id) FROM po_details");
                // Read data of each row 
               
                while($row = $po_details->fetch_assoc()) {
                    $item_id = $row['item_id'];
                    $inventory = $con->query("SELECT * FROM inventory i , po_details pd WHERE pd.item_id = '$item_id' AND i.item_id = pd.item_id AND pd.po_Date BETWEEN '$from_date' AND '$to_date';");
                    $itemTotalQty = 0;
                    $itemOrderTotal = 0;

                    $controlRow = true;
                    while($row_detail = $inventory->fetch_assoc()) {
                        $po_itemQty = $row_detail['po_itemQty'];
                        $po_orderTotal = $row_detail['po_orderTotal'];
                        $item_name = $row_detail['item_name'];
                        $cat_id = $row_detail['cat_id'];
                        $itemTotalQty += $po_itemQty;
                        $itemOrderTotal += $po_orderTotal;
                 
                    if($controlRow){
                        echo '<tr>
                        <td scope="row">'.$item_id.'</td>
                        <td>'.$item_name.'</td>
                        <td>'.$cat_id.'</td>
                        <td>'.$po_itemQty.'</td>
                        <td>'.$po_orderTotal.'</td>
                        </tr>'; 
                        $controlRow = false;
                    }else{
                        echo '<tr>
                        <td scope="row"></td>
                        <td></td>
                        <td></td>
                        <td>'.$po_itemQty.'</td>
                        <td>'.$po_orderTotal.'</td>
                        </tr>'; 
                    }
                }

                    if($itemOrderTotal != 0){
                    echo '<tr>
                    <td></td>
                    <td></td>
                    <td class="border-top border-bottom border-dark">Total : </td>
                    <td class="border-top border-bottom border-dark">'.$itemTotalQty.'</td>
                    <td class="border-top border-bottom border-dark">'.$itemOrderTotal.'</td>
                    </tr>';
                    echo'<tr><td></td></tr>';
                    }
                    
                } ?>
                   
                
                </tbody>
                </table>
                </form>
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