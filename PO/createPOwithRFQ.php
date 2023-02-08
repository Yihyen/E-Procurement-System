<?php
include '../connection/dbCon.php';
session_start();

$res = $con->query("SELECT * FROM user where user_name='" . $_SESSION["username"] . "'")->fetch_array();
if ($res["user_role"] == 'Purchasing Staff') {
    include '../navBar/purchasingStaffNavBar.php';
} else if ($res["user_role"] == 'Purchasing Manager') {
    include '../navBar/purchasingManagerNavBar.php';
} 

//RFQ
$rfq = $con->query("SELECT DISTINCT RFQNo FROM rfq ORDER BY RFQNo ");
// $rfqRow = mysqli_fetch_array($rfq);

//Supplier
// $supplier = $con->query("SELECT * FROM supplier s, rfq WHERE s.supplierID = rfq.supplierID AND rfq.RFQNo = '$RFQNo'");
// $supp = mysqli_fetch_array($supplier);


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
    .createPO-body{
        padding-left: 180px;
    }

    hr.new1{
        width: 85%;
    }
</style>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create wit RFQ</title>
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
        <div class="createPO-header">
            <br>
            <h1 class="text-center m-0">Create New PO with RFQ</h1>
            <br> <br>
        </div>    
        <div class="createPO-body">
            <form action="" method="post" onsubmit="">
            <div class="row">
                <div class="col-2">
                    <label for="rfq_id" style="text-align: right"><strong>RFQ ID</strong></label>
                    <?php 
                       $rfq2 = mysqli_query($con, "SELECT * FROM rfq");
                    ?>
                </div>
                <div class="col-4">
                    <div class="col-sm-6 form-group">
                    <select id="rfqID" name="rfqID" class="form-select control-select-sm rounded-1" onchange="changeRFQID(this)" required>
                                <option value="" selected disabled hidden>Choose RFQ ID</option>
                                <?php
                                while ($rfqRow = mysqli_fetch_array($rfq)){
                                    $r = $rfqRow['RFQNo'];
                                    echo "<option value='" . $rfqRow["RFQNo"] . "'>" . $rfqRow["RFQNo"] . "</option>";
                                }
                                
                                ?>
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
                <!-- <label class="supplier_id">Supplier</label>
                <?php
                        $sql = mysqli_query($con,"SELECT * FROM supplier ORDER BY companyName ASC");
                ?>
                <select id="supplier_id" disabled name="supplier_id" class=" custom-select-sm rounded-0">
                    <option><?php echo $supp['companyName'];?></option>
                    <?php
                    while($result = mysqli_fetch_array($sql)){
                        echo '<option  value="'.$result["supplier_id"].'" supplier_id = "'.$result["supplierID"].'">'.$result['companyName'].'</option>';                       
                    }
                    ?>
                </select> -->
            </div>

                <td class="align-middle p-1 supplierID">
                            <input type="text" name="supplierID" id = "supplierID" class=" w-100 border-0 supplierID" readonly>
                    </td>

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
				        <textarea name="ship_to_address" id="ship_to_address" rows="3" class="form-control rounded-2" required></textarea>
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
                        
                            
                        </tbody>
                        <tfoot>
							<tr class="thead-dark">
								<tr>                            
									<th class="p-1 text-right" colspan="4">Sub Total</th>
									<th class="p-1 text-center" id="total">
                                        <!-- <label for="total">Total</label> -->
                                        <input type="text" class="text-center w-100 border-0" name="po_orderTotal" id="po_orderTotal"  value="" required readonly/>
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
                        <textarea name="po_remark" id="po_remark" cols="10" rows="5" class="form-control rounded-2"><?php //echo $pr_remark?></textarea>
                    </div>
                    <div class="col-md-4">
							<label for="po_status" class="control-label">Status</label>
							<select name="po_status" id="po_status" class="form-control form-control-sm rounded-2">
                                <option>Pending</option>
								<!-- <option value="Pending" <?php //echo $po_status ?>>Pending</option> -->
								<!-- <option value="Approved" <?php //echo $po_status ?>>Approved</option>
								<option value="Denied" <?php //echo $po_status ?>>Denied</option> -->
							</select>
						</div>
                </div>

            <div class="createPO-footer py-1 text-center">
                <button type="button" class="btn btn-primary" name="submit" id="submit" onclick="fetchItems()">Submit</button>
                <a class="btn btn-outline-primary" href="purchaseOrderBootstrap2.php" role="button">Cancel</a>
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
        let supplierID = document.getElementById('supplierID').dataset.supplierid;
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
            let itemID = row.querySelector('td:first-child input:first-child').dataset.itemid;
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
        
        let url = `ajaxCreateNewPOwithRFQ.php?poWithRfq&poID=${poID}&supplierID=${supplierID}&deliveryDate=${deliveryDate}&storageLocation=${storageLocation}&supplierAccNo=${supplierAccNo}&shippingAdd=${shippingAdd}&poRemark=${poRemark}&storeItemDetails=${JSON.stringify(storeItemDetails)}`;

        let response = await fetch(url).then(response => response.json());

        if(response == 'success'){
            alert('PO with RFQ Created Successfully');
            window.location.href = 'purchaseOrderBootstrap.php';
        }
    }

    function changeRFQID(selectObj){
        let selectedOption = selectObj.value;
        document.getElementById("add_item").innerHTML = '';

        $.ajax({
            url:"fetchRFQ.php",
            method:"POST",
            data: "find_rfq" + "&rfqID=" + selectedOption,
            success: function(data){
                let rfq = JSON.parse(data);
                console.log(rfq);
                document.getElementById("supplierID").value = rfq[0]['supplierName'];
                document.getElementById("supplierID").setAttribute('data-supplierid', rfq[0]['supplierID']);

                document.getElementById("supplierAddress").value = rfq[0]['supplierAddress'];
                document.getElementById("supplierContact").value = rfq[0]['supplierContact'];
                document.getElementById("supplierEmail").value = rfq[0]['supplierEmail'];

                let tbody = document.getElementById("add_item");
                let orderTotalElement = document.getElementById('po_orderTotal');
                let poOrderTotal = 0;

                for(let i = 0; i < rfq.length; i++){
                    //Create New Row
                    let tr = document.createElement('tr');

                    let itemNameTd = document.createElement('td');
                    let descTd = document.createElement('td');
                    let itemQtyTd = document.createElement('td');
                    let itemPriceTd = document.createElement('td');
                    let itemTotalTd = document.createElement('td');

                    //Create New Input
                    let itemNameInput = document.createElement('input');
                    let descInput = document.createElement('input');
                    let itemQtyInput = document.createElement('input');
                    let itemPriceInput = document.createElement('input');
                    let itemTotalInput = document.createElement('input');

                    //Set Attribute
                    itemNameInput.setAttribute('type', 'text');
                    itemNameInput.setAttribute('data-itemid', rfq[i]['item_id']);
                    itemNameInput.setAttribute('name', 'itemName[]');
                    itemNameInput.setAttribute('class', 'form-control');
                    itemNameInput.setAttribute('value', rfq[i]['productName']);
                    itemNameInput.setAttribute('readonly', 'readonly');

                    descInput.setAttribute('type', 'text');
                    descInput.setAttribute('name', 'desc[]');
                    descInput.setAttribute('class', 'form-control');
                    descInput.setAttribute('value', rfq[i]['item_description']);
                    descInput.setAttribute('readonly', 'readonly');

                    itemQtyInput.setAttribute('type', 'text');
                    itemQtyInput.setAttribute('name', 'itemQty[]');
                    itemQtyInput.setAttribute('class', 'form-control');
                    itemQtyInput.setAttribute('value', rfq[i]['productQty']);
                    itemQtyInput.setAttribute('readonly', 'readonly');

                    itemPriceInput.setAttribute('type', 'text');
                    itemPriceInput.setAttribute('name', 'itemPrice[]');
                    itemPriceInput.setAttribute('class', 'form-control');
                    itemPriceInput.setAttribute('value', rfq[i]['item_unit_price']);
                    itemPriceInput.setAttribute('readonly', 'readonly');

                    let rowTotal = rfq[i]['productQty'] * rfq[i]['item_unit_price'];
                    poOrderTotal += rowTotal;

                    itemTotalInput.setAttribute('type', 'text');
                    itemTotalInput.setAttribute('name', 'itemTotal[]');
                    itemTotalInput.setAttribute('class', 'form-control');
                    itemTotalInput.setAttribute('value', rowTotal);
                    itemTotalInput.setAttribute('readonly', 'readonly');

                    //Append Input to td
                    itemNameTd.appendChild(itemNameInput);
                    descTd.appendChild(descInput);
                    itemQtyTd.appendChild(itemQtyInput);
                    itemPriceTd.appendChild(itemPriceInput);
                    itemTotalTd.appendChild(itemTotalInput);

                    //Append td to tr
                    tr.appendChild(itemNameTd);
                    tr.appendChild(descTd);
                    tr.appendChild(itemQtyTd);
                    tr.appendChild(itemPriceTd);
                    tr.appendChild(itemTotalTd);

                    //Append tr to tbody
                    tbody.appendChild(tr);
                }

                orderTotalElement.value = poOrderTotal;
            }
        })
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
                           
    </body>