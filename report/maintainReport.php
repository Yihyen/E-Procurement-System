<?php
    session_start();
    include('../navBar/purchasingManagerNavBar.php');
    include('../connection/dbCon.php');

?>
 



<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>E-Procurement System</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/932c860bc2.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">   
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js" integrity="sha512-tWHlutFnuG0C6nQRlpvrEhE4QpkG1nn2MOUMWmUeRePl4e3Aki0VB6W1v3oLjFtd0hVOtRQ9PHpSfN6u6/QXkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="sweetalert2/dist/sweetalert2.min.js"></script>
        <script src="../plugin/jquery-3.6.1.min.js"></script>
        <script src="../plugin/sweetalert2.all.min.js"></script>

</head>
  
<body>
    <div class="container">
        <div class="col-md-12">
            <br>
            <br>
            <h1 class="text-center m-0" style="color: #00b3b3;">Report</h1> 
            <br>
            <br>
            <div class="center">
                <form name="reportForm" action="" method="post">
                    <div>
                    <label>Select the report:</label><br>
                        <select name="report" id="report">
                            <option></option>
                            <option value="totalPurchase">Total Purchases</option>
                            <option value="cancelledPO">Cancelled Purchase Order</option>
                            <option value="quotation">Quotation Comparison</option>
                            <option value="supplierRating">Supplier Performance Rating</option>
                            <option value="poOutstanding">Purchase Order Outstanding</option>
                        </select>
                    </div>
                    <div>
                        <div id="sorting" style="margin-top: 10px;">
                            <label>Sort by</label>
                            <select name="sort" id="sort">
                            <option value="item">Item</option>
                            <option value="supplier">Supplier</option>
                            </select>
                        </div>
                        <div id="item" style="margin-top: 10px;">
                            <label>Item Name</label>
                            <select name="productName" id="productName">
                                <?php 
                                $item = mysqli_query($con,"SELECT distinct(productName) FROM rfq");
                                while ($row = mysqli_fetch_array($item)){
                                ?>
                                    <option value="<?php echo $row['productName'];?>"><?php echo $row['productName'];?></option>   
                                <?php 
                                } ?>
                            </select>
                        </div>
                        <div class="d-flex small-center" >
                            <div style="margin-right:60px; margin-left:60px;">
                            <label>From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control">
                            </div>
                            <div>
                            <label>To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control">
                            </div>
                            <!-- <button type="submit" class="btn btn-primary" name="btnFilter" style="margin-top: 25px;"><i class="fa-solid fa-magnifying-glass"></i> Filter</button> -->
                        </div>
                        <div style="margin-top: 20px; margin-bottom:20px; text-align:center;">
                            <input class="btn btn-sm btn-flat btn-success" type="button" id="redirect" name="redirect" value="Generate"/>
                        </div>  
                    </div>
                </form>
            </div>
    </div>

</body>

   <script type="text/javascript">
        $(document).ready(function () {
            $('#sorting').hide();
            $('#item').hide();

            $('#report').change(function() {
            if ($(this).val() == 'totalPurchase') {
                $('#sorting').show();
            } else {
                $('#sorting').hide();
            }
            });

            $('#report').change(function() {
            if ($(this).val() == 'quotation') {
                $('#item').show();
            } else {
                $('#item').hide();
            }
            });


            $('#redirect').click(function() {
                report = $('#report').val();
                sort = $('#sort').val();
                from_date = $('#from_date').val();
                to_date = $('#to_date').val();
                productName = $('#productName').val();

                if(report == ""){
                    //alert("Please select the start date and to date to generate report");
                    Swal.fire('Please select a report type!');
                }else if(from_date == "" || to_date == "") {
                    Swal.fire('Please select the date!');
                } else {
                    switch(report){
                        case 'totalPurchase':
                            if(sort == 'item') {
                                window.location.href = "./reportPurchaseByItem.php?from_date=" + from_date + "&to_date=" + to_date;
                            } else if(sort == 'supplier') { 
                                window.location.href = "./reportPurchaseBySupplier.php?from_date=" + from_date + "&to_date=" + to_date;
                            }
                            break;
                        case 'cancelledPO':
                            window.location.href = "./reportCancelledPO.php?from_date=" + from_date + "&to_date=" + to_date;
                            break;
                        case 'quotation':
                            window.location.href = "./reportQuotationComparison.php?productName=" + productName + "&from_date=" + from_date + "&to_date=" + to_date;
                            break;
                        case 'supplierRating':
                            window.location.href ="./reportSupplierPerformanceRating.php?from_date=" + from_date + "&to_date=" + to_date;
                            break;
                        case 'poOutstanding':
                            window.location.href ="./reportPOOutstanding.php?from_date=" + from_date + "&to_date=" + to_date;
                            break;
                        default:
                            alert("Something went wrong");
                    }
                }
            })
        });


    </script>
    <style>
        .center {
        margin: auto;
        width: 50%;
        border: 2px solid grey;
        padding: 10px;
        }
        .small-center{
        margin: auto;
        width: 90%;
        border: 2px solid grey;
        padding: 10px;
        margin-top: 20px;
        }

        
    </style>

                       
  
</html>