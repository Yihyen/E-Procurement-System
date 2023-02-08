<?php
include '../connection/dbCon.php';
session_start();

$res = $con->query("SELECT * FROM user where user_name='" . $_SESSION["username"] . "'")->fetch_array();
if ($res["user_role"] == 'Purchasing Staff') {
    include '../navBar/purchasingStaffNavBar.php';
} else if ($res["user_role"] == 'Purchasing Manager') {
    include '../navBar/purchasingManagerNavBar.php';
} 

if(isset($_GET['prid'])) {
    $pr_id = $_GET['prid'];
    //Purchase Order Details
    
    $prDetails = $con->query("SELECT * FROM pr_details prd, purchase_requisition pr WHERE pr.pr_id = prd.pr_id AND pr.pr_id = '$pr_id'");
    $pr = mysqli_fetch_array($prDetails);
    //FROM PR
    $pr_id = $pr['pr_id'];
    $pr_status = $pr['pr_status'];
    $pr_date = $pr['date_request'];
    $delivery_address = $pr['deliver_address'];
    $pr_remark = $pr['pr_remark'];

    // //FROM PR_details
    $item_id = $pr['item_id'];
    $item_qty = $pr['qty_request'];
}

$query = "SELECT p.po_id FROM purchaseorder p, po_details o WHERE p.po_id = o.po_id ORDER BY p.po_id DESC";
$result = $con->query($query);     
$row = mysqli_fetch_array($result);
$lastpoId = $row['po_id'];

if(empty($lastpoId)){
$po_id = "22PO000001";
}
else{
$idd = str_replace("22PO","",$lastpoId);
$id = str_pad($idd + 1,6,0,STR_PAD_LEFT);
$po_id = '22PO' .$id;
}


?>

<style>
span.select2-selection.select2-selection--single {
        border-radius: 0;
        padding: 0.25rem 0.5rem;
        padding-top: 0.25rem;
        padding-right: 0.5rem;
        padding-bottom: 0.25rem;
        padding-left: 0.5rem;
        height: auto;
    }
	/* Chrome, Safari, Edge, Opera */
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
		}
.createPO-body{
    border: 1px black;
    border-style: inherit;
    padding-left: 180px;
}

hr.new1 {
  width: 85%;
}

</style>

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Procurement System</title>
    <script src="https://kit.fontawesome.com/932c860bc2.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="bootstrap.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="java/jquery-3.6.2.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="java/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="create-container">
        <div class="createPO-header">
        <br>
        <h1 class="text-center m-0">Create New Reccuring PO</h1>
        <br> <br>
            
        </div>    
        <div class="createPO-body">
            <form action="" method="post" onsubmit="">
                <div class="row">
                <div class="col-2">
                    <label for="pr_id" style="text-align: right"><strong>PR Number</strong></label>
                    <br>
                    <label for="pr_date" style="text-align: right"><strong>PR Date</strong></label>
                </div>
                <div class="col-4">
                    <div class="col-sm-6 form-group">
                        <input type="text" class="form-control form-control-sm rounded-2" id="pr_id" name="pr_id" value="<?php echo $pr_id?>" readonly>
                        <input type="date" class="form-control form-control-sm rounded-2" id="date_request" name="date_request" value="<?php echo $pr_date?>" readonly>
                </div>
            </div>
                <div class="col-2">
                    <label for="po_Date" style="text-align: right"><strong>PO Date</strong></label>
                    <br>
                     <label for="po_id" style="text-align: right"><strong>PO Number</strong> <span class="po_err_msg text-danger"></span></label>
                </div>
                <div class="col-4">
                    <div class="col-sm-6 form-group">
                        <input type="date" class="form-control form-control-sm rounded-2" name="po_Date" value = "<?php echo date("Y-m-d")?>" readonly>
                        <input type="text" class="form-control form-control-sm rounded-2" id="po_id" name="po_id" style="color:blue; font-weight: bold;" value="<?php echo $po_id?>" readonly>
                    </div>
                </div>
                
                </div>
                <hr class="new1">
                
                <!-- Second Row -->
                <div class="row">
                    <div class="col">
                    <div class = "col-md-5 form-group">
                    <label class="supplierID">Supplier</label>
                    <?php
                            $sql = mysqli_query($con,"SELECT * FROM supplier ORDER BY companyName ASC");
                    ?>
                    <select id="supplierID" name="supplierID" class="form-control control-select-sm rounded-2" onchange="changeSupplierID(this)">
                        <option>-- Select Supplier --</option>
                        <?php
                        while($result = mysqli_fetch_array($sql)){
                            $k = $result["supplierID"];
                            echo '<option value="'.$result["supplierID"].'" supplierID = "'.$result["supplierID"].'">'.$result['companyName'].'</option>';
                        }
                        ?>
                    </select>
                    </div>

                    <td class="align-middle p-1 supplierAddress">
                            <input type="text" name="supplierAddress" id = "supplierAddress" class=" w-100 border-0 supplierAddress" readonly>
                    </td>

                    <td class="align-middle p-1 supplierContact">
                            <input type="text" name="supplierContact" id="supplierContact" class=" w-100 border-0 supplierContact" readonly>
                    </td>

                    <td class="align-middle p-1 supplierEmail">
                            <input type="text" name="supplierEmail" id="supplierEmail" class=" w-100 border-0 supplierEmail" readonly>
                    </td>

                    <div class="col-md-5 form-group" style="margin-top:20px;">
					    <label for="supplierAccNo">Supplier Bank Details <span class="form-label"></span></label>
					    <input type="text" class="form-control form-control-sm rounded-2" id="supplierAccNo" name="supplierAccNo"  required>
			        </div>
                    </div> 

                    <div class="col">
                        <div class="col-md-5 form-group">
                        <label for="po_delivery_date">PO Delivery Date</label>
                        <input type="date" class="form-control form-control-sm rounded-2" id="po_delivery_date" name="po_delivery_date" required>
                    </div>

                    <div class = "col-md-5 form-group">
                        <label class="storageLocation">Storage Location</label>
                        <select id="storageLocation" name="storageLocation" class="form-control control-select-sm rounded-2" value="<?php echo $storageLocation?>">
                            <option>-- Select Storage Location --</option>
                            <option> ST01</option>
                            <option> ST02</option>
                            <option> ST03</option>
                            <option> ST04</option>
                            <option> ST05</option>
                        </select>
                    </div>
                    <div class="col-md-7 form-group">
				        <label for="ship_to_address" class="control-label">Ship to Address</label>
				        <textarea name="ship_to_address" id="ship_to_address" rows="3" class="form-control rounded-2" required><?php echo $delivery_address ?></textarea>
			        </div>
                    </div>
                </div>

                <!-- Third Row -->
            <div class="row">
                

                
            </div>
            <br>
            <div class="row">
            <div class="col-md-10">
                <table class="table table-bordered" id="item-list">
                        <colgroup>
							<col width="20%">
							<col width="35%">
                            <col width="5%">
							<col width="10%">
							<col width="10%">
						</colgroup>
						<thead class="bg-secondary text-light">
							<tr class="bg-navy disabled">
								<th class="px-1 py-1 text-center">Item</th>
								<th class="px-1 py-1 text-center">Description</th>
                                <th class="px-1 py-1 text-center">Qty</th>
								<th class="px-1 py-1 text-center">Price</th>
								<th class="px-1 py-1 text-center">Total</th>
							</tr>
						</thead>
                        <tbody id="add_item">
                        <?php 
                                    $prID = $_GET['prid'];
                                    $sql4 = $con -> query("SELECT * FROM pr_details prd, purchase_requisition pr 
                                    WHERE prd.pr_id = pr.pr_id
                                    AND pr.pr_id = '$prID'");

                                    $sql5 = mysqli_query($con,"SELECT * FROM inventory i, pr_details prd WHERE i.item_id = prd.item_id AND prd.pr_id = '$prID'");
                                    $item = mysqli_fetch_array($sql5);
                                    $itemPrice = $item['item_unit_price'];
                                    
                                    $orderTotal = 0;

                                    while($itemRow = mysqli_fetch_array($sql4)){
                                    //Calculate Row Total
                                    $rowTotal = $itemRow['qty_request'] * $itemPrice;

                                    // $status = $itemRow['pr_status'];
                                    $orderTotal += $rowTotal;

                                    
                            ?>
                            <tr class="po-item" date-id="">
                               
                                <td class="align-middle p-1">
                                    <?php
                                    $sql = mysqli_query($con,"SELECT * FROM inventory i ORDER BY item_name ASC");
                                    ?>
                                    <input type="hidden" class="form-control form-control-sm rounded-0 item_id" name="item_id[]" id = "item_id" onchange='changeItemID(this)' value="<?php echo $itemRow['item_id']?>" readonly>

                                    <?php
                                    $item_description = "";
                                    while($result = mysqli_fetch_array($sql)){
                                        $k = $result["item_id"];
                                        
                                        if($k == $itemRow['item_id']){
                                            echo '<input type="text" class="form-control form-control-sm rounded-0 item_id" name="item_id[]" id = "item_id" onchange="changeItemID(this)" data-itemid="'.$itemRow['item_id'].'" value="'.$result['item_name'].'" readonly>';
                                             $item_description = $result['item_description'];
                                            continue;                       
                                        }                         
                                    }
                                    ?> 
                                    </select>
                                </td>
                                    <!-- <select class="item_id" name="item_id[]" id = "item_id" class="text-left w-100 border-0 item_id" onchange='changeItemID(this)'>
                                    <option value="0" disabled selected>-- Select Item --</option>
                                    <?php
                                    while($result = mysqli_fetch_array($sql)){
                                        $k = $result["item_id"];
                                        echo '<option value="'.$k.'" item_id = "'.$k.'">'.$result['item_name'].'</option>';                       
                                    }
                                    ?> 
                                    </select>
                                </td> -->
                                <!-- Description -->
                                <td class="align-middle p-1 item-description">
                                <textarea class="form-control form-control-sm rounded-0 item_description" name="item_description[]" id = "item_description" rows="3" readonly style="resize:none;"><?php echo $item_description?></textarea>
                                </td>
                                <!-- Quantity -->
                                <td class="align-middle p-1 text-center">
                                    <input type="number" class="text-center w-100 border-0 po_itemQty" step="any" id = "po_itemQty" name="po_itemQty[]" min="0" value="<?php echo $itemRow['qty_request'] ?>"required onchange="calTotal(this)" readonly/>
                                </td>
                                <!-- Price -->
                                
                                <td class="align-middle p-1 text-center">
                                    <input type="number" step="any" class="text-center w-100 border-0 po_itemPrice" id ="po_itemPrice" name="po_itemPrice[]" min="0" value="<?php echo $itemPrice?>"required onchange="calTotal(this)" readonly/>
                                </td>
                                <!-- Total -->                                
                                <td class="align-middle p-1 text-center total-price">
                                    <input type="number" class="text-center w-100 border-0 po_total" name="po_total[]" id = "po_total" value="<?php echo $rowTotal?>" required readonly>
                                </td>
                                <input type="hidden" name="serial[]" class="sl" id="hd" value="1">
                                <div id="next"></div>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
							<tr class="thead-dark">
								<tr>                            
									<th class="p-1 text-right" colspan="4">Sub Total</th>
									<th class="p-1 text-center" id="total">
                                        <!-- <label for="total">Total</label> -->
                                        <input type="text" class="text-center w-100 border-0" name="po_orderTotal" id="po_orderTotal"  value="<?php echo $orderTotal?>" required readonly/>
                                    </th>
								</tr>
							</tr>
						</tfoot>
                </table>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-6">
                        <label for="remark" class="control-label">Remarks</label>
                        <textarea name="po_remark" id="po_remark" cols="10" rows="5" class="form-control rounded-2"><?php echo $pr_remark?></textarea>
                    </div>
                    <div class="col-md-4">
							<label for="po_status" class="control-label">Status</label>
							<select name="po_status" id="po_status" class="form-control form-control-sm rounded-2">
                                <option>Pending</option>
								<!-- <option value="Pending" <?php echo $po_status ?>>Pending</option> -->
								<!-- <option value="Approved" <?php echo $po_status ?>>Approved</option>
								<option value="Denied" <?php echo $po_status ?>>Denied</option> -->
							</select>
						</div>
                </div>

            <div class="createPO-footer py-1 text-center">
                <button type="button" class="btn btn-primary" name="submit" id="submit" onclick="fetchItems()">Submit</button>
                <a class="btn btn-outline-primary" href="purchaseOrderBootstrap.php" role="button">Cancel</a>
            </div>

            
            <?php
$sql = mysqli_query($con,"SELECT * FROM inventory ORDER BY item_name ASC");
?> 

<script>
    function rem_item(_this){
		_this.closest('tr').remove()
	}

    function calTotal(inputObj) {
        let po_orderTotal = 0;
        let currentTr = inputObj.parentElement.parentElement;
        po_itemQty = currentTr.querySelector('.po_itemQty').value;
        po_itemPrice = currentTr.querySelector('.po_itemPrice').value;

        po_total = po_itemQty * po_itemPrice;

        currentTr.querySelector('.po_total').value = po_total;

        let allRowTotal = currentTr.parentElement.querySelectorAll('.po_total');

        for(let i = 0; i < allRowTotal.length; i++){
            po_orderTotal += parseInt(allRowTotal[i].value);
        }
        
        document.getElementById('po_orderTotal').value = po_orderTotal;
    }

    async function fetchItems(){
        //For Insert Into purchaseorder
        let poID = document.getElementById('po_id').value;
        let prID = document.getElementById('pr_id').value;
        let supplierID = document.getElementById('supplierID').value;
        let deliveryDate = document.getElementById('po_delivery_date').value;
        let storageLocation = document.getElementById('storageLocation').value;
        let supplierAccNo = document.getElementById('supplierAccNo').value;
        let shippingAdd = document.getElementById('ship_to_address').value;
        
        //Insert into po_details
        let poRemark = document.getElementById('po_remark').value;

        let allTr = document.querySelectorAll('#add_item tr');
        let storeItemDetails = [];
        let i = 0;
        
        allTr.forEach(row => {
            let itemID = row.querySelector('td:first-child input:nth-child(2)').dataset.itemid;
            let itemQty = row.querySelector('td:nth-child(3) input').value;
            let itemPrice = row.querySelector('td:nth-child(4) input').value;
            let rowTotal = row.querySelector('td:nth-child(5) input').value;

            storeItemDetails[i] = {
                "itemID": itemID,
                "itemQty": itemQty,
                "itemPrice": itemPrice,
                "rowTotal": rowTotal
            }

            i++;
        });
        
        let url = `ajaxCreateNewReccuringPO.php?createPO&poID=${poID}&prID=${prID}&supplierID=${supplierID}&deliveryDate=${deliveryDate}&storageLocation=${storageLocation}&supplierAccNo=${supplierAccNo}&shippingAdd=${shippingAdd}&poRemark=${poRemark}&storeItemDetails=${JSON.stringify(storeItemDetails)}`;

        let response = await fetch(url).then(response => response.json());

        if(response == 'success'){
            alert('Recurring PO Created Successfully');
            window.location.href = 'purchaseOrderBootstrap.php';
        }
    }

    async function changeItemID(selectObj){
        let selectedOption = selectObj.value;
 
       let response = await fetch(`fetchitem.php?find_desc&item_id=${selectedOption}`).then(response => response.text());
       let desc = JSON.parse(response);

        selectObj.parentElement.parentElement.querySelector('td:nth-child(3) input').value = desc;
    }

    function changeSupplierID(selectObj){
        let selectedOption2 = selectObj.value;
        console.log(selectedOption2)

        $.ajax({
            url:"fetchSupplier.php",
            method:"POST",
            data: "find_sup" + "&supplierID=" + selectedOption2,
            success: function(data){
                let supplier = JSON.parse(data);
                document.getElementById("supplierAddress").value = supplier[0]['supplierAddress'];
                document.getElementById("supplierContact").value = supplier[0]['supplierContact'];
                document.getElementById("supplierEmail").value = supplier[0]['supplierEmail'];
            }
        });
    }

    $(document).ready(function() {

        $('#add_row').click(function() {
            var length = $('.sl').length;
            var a = parseInt(length)+parseInt(1);
            var row = "<tr class='po-item' date-id=''>"
                row += "<td class='align-middle p-1 text-center'>"
                row += "<button class='btn btn-sm btn-danger py-0' type='button' onclick='rem_item($(this))'><i class='fa fa-times'></i></button>";
                row += "</td>"
                row += "<td class='align-middle p-1'>"
                row += "<?php $sql = mysqli_query($con,"SELECT * FROM inventory ORDER BY item_name ASC");?>"
                row += "<select id ='item_id'+a+''class='item_id' name='item_id[]' class='text-left w-100 border-0 item_id' onchange='changeItemID(this)'>";
                row += "<option value='0' disabled selected>-- Select Item --</option>";   
                row += "<?php while($result = mysqli_fetch_array($sql)): ?>";                
                row += "<option value='<?php echo $result['item_id']; ?>'><?php echo $result['item_name']; ?></option>";
                row += "<?php endwhile; ?>";
                row += "</select>";                  
                row += "</td>";              
                row += "<td class='align-middle p-1 item-description'>";              
                row += "<input type='text' id = 'item_description'+a+'' name='item_description[]' class='text-center w-100 border-0 item_description' style='resize:none;' readonly>";              
                row += "</td>";              
                row += "<td class='align-middle p-1 text-center'>";              
                row += "<input type='number' id='po_itemQty'+a+'' class='text-center w-100 border-0 po_itemQty' step='any' name='po_itemQty[]' min='0' value='0' required onchange='calTotal(this)'/>";                  
                row += "</td>";             
                row += "<td class='align-middle p-1 text-center'>";              
                row += "<input type='number' step='any' class='text-center w-100 border-0 po_itemPrice' id='po_itemPrice'+a+'' name='po_itemPrice[]' min='0' value='0.00' required onchange='calTotal(this)'/>";                  
                row += "</td>";              
                row += "<td class='align-middle p-1 text-center total-price'>";
                row += "<input type='text' class='text-center w-100 border-0 po_total' id='po_total'+a+'' name='po_total[]' value='0.00' readonly required>"             
                row += "</tr>";  
                row += "<input type='hidden' name='serial[]' class='sl' value'+a+'>";  
                row += "<script>"                
                document.getElementById('add_item').insertRow().innerHTML = row;
        });
    });

</script> 
            </form>
        </div>    
        
    </div>

</body>
</html>