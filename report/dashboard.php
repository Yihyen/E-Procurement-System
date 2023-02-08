<?php
   session_start();
   include('../navBar/purchasingManagerNavBar.php');
   include('../connection/dbCon.php');

    $query = "SELECT item_id, count(*) as number FROM po_details GROUP BY item_id";
    $result = mysqli_query($con,$query);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/932c860bc2.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">   
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                ['Month','Total Amount'],
               <?php
               $item = $con -> query("SELECT DISTINCT(MONTHNAME(po_Date)) AS month, SUM(po_itemQty) AS quantity, SUM(po_orderTotal) as amount
                                            FROM po_details GROUP BY MONTH(po_Date)");
                while($record = $item -> fetch_assoc()){
                    echo "['".$record['month']."',".$record['amount']."],";
                }
               ?>
                ]);

                var options = {
                title: 'Total Amount of Purchase Order Based on Month',
                curveType: 'function',
                legend: { position: 'bottom' }
                };

                var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                chart.draw(data, options);
            }

            google.charts.setOnLoadCallback(drawPieChart);
            function drawPieChart() {
            
            var data = google.visualization.arrayToDataTable([
                ['Purchase Order','Number']
                <?php
                //$poStatus = $connection -> query("SELECT * from purchaseorder");
               $poStatus = $con -> query("SELECT DISTINCT(po_status) AS status, COUNT(po_id) AS countID FROM purchaseorder GROUP BY po_status");
                while($record = $poStatus -> fetch_assoc()){
                    //$po_id = $poStatus['po_id'];
                    //$numPO = $connection ->query("SELECT * FROM prurchaseorder WHERE po_id = '$po_id'") ->num_rows;
                    echo "['".$record['status']."',".$record['countID']."],";
                }
               ?>
                
                ]);

                var options = {
                title: 'Purchase Order Status ',
                is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(data, options);
            }
            
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <br>
                    <h1 class="text-center m-0" style="color: #00b3b3;">Dashboard</h1>
                    <br>
                    <br>
                    
                    <div class="card" id="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">No. Of Item</h4>
                            <h1 class="card-text text-center">
                                <?php
                                    $count = 0;
                                    $res=mysqli_query($con,"SELECT * FROM inventory");
                                    $count=mysqli_num_rows($res);
                                    echo $count;
                                    ?>
                            </h1>
                        </div>
                    </div>
                
                    <div class="card" id="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">No. Of Supplier</h4>
                            <h1 class="card-text text-center">
                                <?php
                                    $count = 0;
                                    $res=mysqli_query($con,"SELECT * FROM supplier");
                                    $count=mysqli_num_rows($res);
                                    echo $count;
                                    ?>
                            </h1>
                        </div>
                    </div>

                    <div class="card" id="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">No. Of Approved PO</h4>
                            <h1 class="card-text text-center">
                                <?php
                                    $count = 0;
                                    $res=mysqli_query($con,"SELECT * FROM purchaseorder  WHERE po_status ='Approved'");
                                    $count=mysqli_num_rows($res);
                                    echo $count;
                                    ?>
                            </h1>
                        </div>
                    </div>
        

                    <div class="card" id="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">No. Of Denied PO</h4>
                            <h1 class="card-text text-center">
                                <?php
                                    $count = 0;
                                    $res=mysqli_query($con,"SELECT * FROM purchaseorder WHERE po_status ='Denied'");
                                    $count=mysqli_num_rows($res);
                                    echo $count;
                                    ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div id="curve_chart" style="width: 900px; height: 500px"></div>
            </div>
            <div class="row">
                <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
            </div>
        </div>
        <div>
            
        </div>
        <div>
      
        </script>
        </div>
        
    
    </body>
    
    <style> 
    #card{
        width: 18rem; 
        border-style:solid; 
        border-width:1px; 
        border-radius:10px;
        float:left;
        margin-right: 10px;
    }
    </style>
</html>