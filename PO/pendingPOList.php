<?php 
   session_start();
   
   include('../connection/dbCon.php');
   include '../administration/verifyUserType.php';
?>

<style>
    
    .listOfPO{
        margin-left: 100px;
        width: 93%;
        position: inherit;
    }
     
    h3{
        background:#D9D9D6;
        padding:15px;
    }
    
    .button{
        background-color: #717171;
        margin-left: 800px;
        position:static;
        transition: 0.3s;
        display: inline-block;
        padding: 10px 28px;
        text-align: center;
        font-size: 16px;
        cursor: pointer;
        color: white;
        text-align: center;
        border-radius: 8px;
    }
    
    .button:hover {
        background-color: #ddd;
        color: black;
    }
    
    .card-body{
        width: 90%;
        padding-top: 20px;
        margin-top: 30px;
        margin-left: 160px;

    }

    
    .tablePO{
        width:85%;
        padding-top: 20px;
        padding-bottom: 20px;
        margin-left : 20px;
        position: inherit;
    }

    .btn-view{
        color: green;
        margin-left: 20px;
    }

    .btn-approve{
        background-color: green;
        color:white;
        padding: 0 8px 0 8px;
        margin-right:10px;
        border-radius: 5px;
        /* color: green;
        margin-right: 10px; */
    }


    .btn-denied{
        background-color: red;
        color: white;
        padding: 0 10px 0 10px;
        border-radius: 5px;
        /* color: red; */
    }
    
    .btn-pending{
      background-color: grey;
      color: white;
      padding: 0 15px 0 15px;
      border-radius: 5px;
    }

</style>

<!doctype html>
<html>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="../plugin/sweetalert2.all.min.js"></script>
  
        
    </head>
    <body>


    
        <div class="listOfPO"> 
            <br>
            <br>
            <h1 class="text-center m-0" style="color: #00b3b3;">Approve PO</h1> 
            <br>
            <br>
    
                <div class="card-body">
                    <div class="card-content">
                    <div class="col-md-10">
                        <table id="tablePO" class="table table-hover table-striped center" style="margin-left:-10px;">
                    
                    <thead>
                        <tr class="thead-dark">
                            <th>PO Number</th>
                            <th>Date Created</th>
                            <th>Supplier</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="center">
                        <?php
                    // Read all row from database table 
                    $purchaseOrder = $con->query("SELECT * FROM purchaseorder WHERE po_status = 'Pending' ORDER BY po_id");

                    // Read data of each row 
                    while($row = $purchaseOrder->fetch_assoc()){
                        $po_id = $row['po_id'];
                        $po_orderTotal = 0;
                        $po_detail = $con->query("SELECT * FROM po_details WHERE po_id = '$po_id'");
                        $row_detail = $po_detail->fetch_assoc();
                        $po_Date = $row_detail['po_Date'];
                        $supplierID = $row_detail['supplierID'];
                        $item_id = $row_detail['item_id'];
                        $cal_total = $con->query("SELECT * FROM po_details WHERE po_id = '$po_id'");
                        while($sum = $cal_total->fetch_assoc()){
                            $po_orderTotal += $sum['po_orderTotal'];
                        }
                        $po_status = $row['po_status'];
                        $output = '<tr>
                        <td scope="row"><a class = "btn" role="button">'.$po_id.'</td>
                        <td>'.$po_Date.'</td>
                        <td>'.$supplierID.'</td>
                        <td>'.$item_id.'</td>
                        <td>'.$po_orderTotal.'</td>
                        <td>';
                            switch($po_status) {
                                case 'Completed':
                                    $output .= '<span class="btn-flat btn-completed">Completed</span>';
                                    break;
                                case 'Approved':
                                    $output .= '<span class="btn-flat btn-approve">Approved</span>';
                                    break;
                                case 'Denied':
                                    $output .= '<span class="btn-flat btn-denied">Denied</span>';
                                    break;
                                default:
                                    $output.= '<span class="btn-flat btn-pending">Pending</span>'; 
                                    break;
                            }
                        $output .= '</td>';
                        $output .= '<td> 
                            <a class = "btn-view" href="pendingPOView.php?po_id='.$po_id.'" role="button"><i class="fa fa-eye"></i></a>
                        </td>
                        <td class="d-flex">
                        <input type="hidden" name="po_id" id="po_id_value" value='.$po_id.'>
                        <form method ="post" action="" class="d-flex">
                            <button type="button" class="btn-approve mb-3" name="approved" value='.$po_id.'><i class="fa-solid fa-check"></i></button>
                            <button type="button" class="btn-denied mb-3" name="denied" value='.$po_id.'><i class="fa-solid fa-x"></i></button>   
                        </form>
                        </td>
                        </tr>';
                        echo $output;
                    }
                    ?>
                    </div>
                
                    </tbody>
                </table>
                </div>
                
            </div>
                </div>
                </div>
                <script src="../plugin/poJv.js"></script>
                <script type="text/javascript">
                   
                    $('.btn-approve').click(function(e){
                        

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Selected Purchase Order will be approved.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                po_id = $('#po_id_value').val();
                                
                                let rowID = e.currentTarget.parentElement.parentElement.parentElement.querySelector('td:first-child a').innerHTML;
                                
                                $.ajax({
                                    type:"POST",
                                    url: "../process/updatePOStatus.php",
                                    data: "updatePO" + "&po_id=" + rowID,
                                    success: function(response) {
                                        if(response == "success") {
                                            
                                            Swal.fire({
                                                title: 'Approved!',
                                                text: 'PO has been approved.',
                                                icon: 'success',
                                                confirmButtonText: 'Yes'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    location.reload();
                                                }
                                            })
                                        } else {
                                            alert(response);
                                        }
                                    }
                                })                                             
                            }
                            
                        })
                      
                    });

                    $('.btn-denied').click(function(e){
                        Swal.fire({
                        title: 'Why are you deny the Purchase Order?',
                        input:'text',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        showLoaderOnConfirm: true
                        }).then((result) => {
                        
                            if(result.value){
                            remark = `${result.value}`;
                            let rowID = e.currentTarget.parentElement.parentElement.parentElement.querySelector('td:first-child a').innerHTML;

                                $.ajax({
                                    type:"POST",
                                    url: "../process/updatePOStatus.php",
                                    data: "denyPO" + "&po_id=" + rowID + "&remark=" + remark,
                                    success: function(response) {
                                        if(response == "success") {
                                            
                                            Swal.fire({
                                                title: 'Submit!',
                                                text: 'PO has been denied!',
                                                icon: 'success',
                                                confirmButtonText: 'Yes'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    location.reload();
                                                }
                                            })
                                        } else {
                                            alert(response);
                                        }
                                    }
                                })
                            }
                        })

                    });
                    
                </script>
        
    </body>
</html>
