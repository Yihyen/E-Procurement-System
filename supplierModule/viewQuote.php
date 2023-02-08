<?php
include 'dbconnect.php';
$con = dbcon();
session_start();
//get related data from passed quotation ID from quotationModule\index.php
$RFQNo = $_GET['RFQNo'];
//join rfqtest2 with supplier table
$sql = "SELECT * FROM rfq JOIN supplier ON rfq.supplierID = supplier.supplierID WHERE RFQNo  = '$RFQNo'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial;
        }

        table thead tr th:nth-child(1),
        table tbody tr td:nth-child(1){
            width: 4%;
        }

        table thead tr th:nth-child(2),
        table tbody tr td:nth-child(2){
            width: 15%;
        }


        table thead tr th:nth-child(3),
        table thead tr th:nth-child(4),
        table thead tr th:nth-child(5),
        table tbody tr td:nth-child(3),
        table tbody tr td:nth-child(4),
        table tbody tr td:nth-child(5){
            width:8%;
        }

        table thead tr th:nth-child(6),
        table tbody tr td:nth-child(6){
            width:11%;
        }

        table thead tr th:nth-child(7),
        table tbody tr td:nth-child(7){
            width:15%;
        }

        #tbody tr td:last-child {
            display: flex;
            justify-content: space-between;

        }

        /* Style the buttons inside the tab */
        #tbody button {
            border: none;
            outline: none;
            cursor: pointer;
            padding: 5px 10px;
            transition: 0.3s;
            font-size: 17px;
        }

        #tbody button.reject{
            background-color: #f44336;
            color: white;
        }

        #tbody button.approve{
            background-color: #4CAF50;
            color: white;
            margin-right: 10px;
        }

        /* Change background color of buttons on hover */
        #tbody button.reject:hover {
            background-color: #e87558;
        }

        /* Change background color of buttons on hover */
        #tbody button.approve:hover {
            background-color: #7cbf58;
        }

    </style>

    <title>Respond to Quotation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--get data from selected value-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="js/supplier.js"></script>
    <script src="js/item.js"></script>
    <script src="js/item2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jQuery UI library -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $("#change").autocomplete({
                source: "fetchData.php",
                minLength: 1

            });
        });
    </script>
    <!-- <script src="./js/addItemRows.js"></script> -->
</head>

<body>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <br>
                    <h2>Respond to Quotation</h2>
                </div>
                <div class="col-md-6">
                    <label for="quotationID">Quotation ID</label>
                    <input text="text" name="RFQNo " id="RFQNo " class="form-control"
                        value="<?php echo $_GET['RFQNo']; ?>" readonly></br>
                </div>

                <div class="col-md-6">
                    <label for="supplierID">Supplier ID</label>
                    <input type="text" name="supplierID" id="supplierID" class="form-control"
                        value="<?php echo $row['supplierID']; ?>" readonly></br>
                </div>

                <div class="col-md-6">
                    <label for="companyName">Company Name</label>
                    <input type="text" name="companyName" id="companyName" class="form-control"
                        value="<?php echo $row['companyName']; ?>" readonly></br>
                </div>

            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Unit Price (RM)</th>
                    <th>Amount (RM)</th>
                    <th>Respond</th>
                    <th>Action</th>
                    <th>Reject Reason</th>
                </tr>
            </thead>

            <tbody id="tbody">
                
                <?php 
                    $sql = "SELECT * FROM rfq JOIN inventory ON rfq.productName = inventory.item_name WHERE RFQNo = '" . $_GET['RFQNo'] . "'";
                    $result = mysqli_query($con, $sql);
                    $i = 1;
                    $curItem = array();
                    while ($row = mysqli_fetch_array($result)) {
                        array_push($curItem, $row['item_name']);
                        ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td>
                        <input type="text" name="productName[]" id="productName" class="form-control"
                            value="<?php echo $row['productName']; ?>" readonly>
                    </td>

                    <td>
                        <input type="number" min="1" name="productQty[]" id="productQty" class="form-control"
                            value="<?php echo $row['productQty']; ?>" onchange="calculateRowTotal(this)" readonly>
                    </td>

                    <td>
                        <input type="text" name="item_unit_price[]" id="item_unit_price" class="form-control"
                            value="<?php echo $row['item_unit_price']; ?>" readonly>
                    </td>

                    <td>
                        <input type="text" name="amt[]" id="amt" class="form-control"
                            value="<?php echo $row['amount']; ?>" readonly>
                    </td>

                    <td>
                        <input type="text" name="respond[]" id="respond" class="form-control"
                            value="<?php echo $row['Status']; ?>" readonly>
                    </td>

                    <td>
                        <button type='button' name='approve' onclick="changeStatus(this)" class='btn approve'>Approve</button>
                        <button type='button' name='reject' onclick="changeStatus(this)" class='btn reject'>Reject</button>
                    </td>

                    <td>
                        <input type="text" name="rejectReason" id="respond" class="form-control" value="" readonly>
                    </td>

                </tr>
                <?php
                        $i++;
                    }
                ?>
            </tbody>
        </table>

        <?php
        $proceedItem = '';
            for($i = 0; $i < count($curItem); $i++){
                if($i == count($curItem) - 1){
                    $proceedItem .= "'" . $curItem[$i] . "'";
                }else{
                    $proceedItem .= "'" . $curItem[$i] . "',";
                }
            }
            //Select inventory from database
            $sql2 = "SELECT * FROM inventory WHERE item_name NOT IN ($proceedItem)";
            $result2 = mysqli_query($con, $sql2);

            if(mysqli_num_rows($result2) > 0){
                //Put inventory into associative array
                $itemArray = array();
    
                while($row2 = mysqli_fetch_array($result2)){
                    $itemArray[] = array(
                        'item_name' => $row2['item_name'],
                        'item_unit_price' => $row2['item_unit_price'],
                        'itemSelected' => ''
                    );
                }
                //If 0, means could add item
                $declineAddNewRow = '0';
            }else{
                //If 1, means no more item to add
                $declineAddNewRow = '1';
                $itemArray = [];
            }

        ?>
        <div class="col-md-3">
            <label for="totalPrice" class="form-label">Total Price (RM)</label>

            <input type="text" name="total" id="total" class="form-control" 
                value="<?php 
                $sql="SELECT SUM(amount) AS totalPrice FROM rfq WHERE RFQNo = '" . $_GET['RFQNo'] . "'"; 
                $result = mysqli_query($con, $sql); 
                $row = mysqli_fetch_array($result);
                echo $row['totalPrice']; ?>" readonly>
            
        </div>
            </br>
        <div class="col-md-3">
            <button type="button" name="update" id="update" class="btn btn-primary" onclick="feedbackRFQ()">Update</button>
        </div>

</html>

<script>
    let itemJson = <?php echo json_encode($itemArray); ?>;

    async function updateRFQ(){
        let tbody = document.querySelector('#tbody');
        let allRow = tbody.querySelectorAll('tr');
        let updateJson = [];
        let insertJson = [];
        let controlExistJson = 0, controlInsertJson = 0;

        for(let i = 0; i < allRow.length; i++){
            let currentRow = allRow[i];
            let currentRowItem = currentRow.querySelector('td:nth-child(2) select').value;
            let currentRowQty = currentRow.querySelector('td:nth-child(3) input').value;
            let currentRowAmt = currentRow.querySelector('td:nth-child(5) input').value;

            if(currentRow.hasAttribute('data-exist')){
                updateJson[controlExistJson] = {
                    'itemName': currentRowItem,
                    'itemQty': currentRowQty,
                    'itemAmt': currentRowAmt
                };
                controlExistJson++;

            }else{
                insertJson[controlInsertJson] = {
                    'itemName': currentRowItem,
                    'itemQty': currentRowQty,
                    'itemAmt': currentRowAmt
                };
                controlInsertJson++;
            }
        }

        let totalPrice = document.querySelector('#total').value;

        let url = `updateQuote.php?id=<?php echo $RFQNo;?>&updateJson=${JSON.stringify(updateJson)}&insertJson=${JSON.stringify(insertJson)}&totalPrice=${totalPrice}`;

        let response = await fetch(url).then(response => response.json());

        if(response == 'success'){
            alert('Update successful');
            window.location.href = 'index.php';
        }else{
            alert('Update failed');
            window.location.reload();
        }
    }

    async function feedbackRFQ(){
        let RFQNo = '<?php echo $_GET['RFQNo']; ?>';
        let tr = document.querySelectorAll('#tbody tr');
        let productJson = [];

        for(let i = 0; i < tr.length; i++){
            let productName = tr[i].querySelector('td:nth-child(2) input').value;

            if(tr[i].querySelector('td:nth-child(6) input').value == 'Pending'){
                alert('Please approve or reject all items');
                return;
            }else if(tr[i].querySelector('td:nth-child(6) input').value == 'Rejected' && 
            tr[i].querySelector('td:last-child input').value == ''){
                alert('Please enter a reason for every rejected items');
                return;
            }else{
                productJson[i] = {
                    'productName': productName,
                    'status': tr[i].querySelector('td:nth-child(6) input').value,
                    'rejectReason': tr[i].querySelector('td:last-child input').value,
                }
            }
        }

        let url = `ajaxFeedbackRFQ.php?RFQNo=${RFQNo}&productJson=${JSON.stringify(productJson)}`;
        let response = await fetch(url).then(response => response.json());

        if(response == 'success'){
            alert('Feedback successful');
            window.location.href = '../supplierModule/quotationSupplier.php';
        }else{
            alert('Feedback failed');
            window.location.href = '../supplierModule/quotationSupplier.php';
        }
    }

    function changeStatus(btnObject){
        let currentRow = btnObject.parentElement.parentElement;
        let btnType = btnObject.name;

        if(btnType == 'approve'){
            currentRow.querySelector('td:nth-child(6) input').value = 'Approved';
            currentRow.querySelector('td:nth-child(6) input').style.backgroundColor = '#7cbf58';
            currentRow.querySelector('td:last-child input').setAttribute('readonly', '');
            currentRow.querySelector('td:last-child input').removeAttribute('placeholder');
        }else if(btnType == 'reject'){
            currentRow.querySelector('td:nth-child(6) input').value = 'Rejected';
            currentRow.querySelector('td:nth-child(6) input').style.backgroundColor = '#e87558';
            currentRow.querySelector('td:last-child input').removeAttribute('readonly');
            currentRow.querySelector('td:last-child input').focus();
            currentRow.querySelector('td:last-child input').setAttribute('placeholder', 'Please enter a reason');
        }
    }
</script>