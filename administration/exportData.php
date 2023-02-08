<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';

if (isset($_POST["export"])) {
    $dataExport = $_POST["data"];

    if ($dataExport == 'user') {
        // Fetch records from database 
        $query = $con->query("SELECT * from user ORDER BY user_id ASC");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "user_export_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Output each row of the data, format line as csv and write to file pointer 
            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['user_id'], $row['user_name'], $row['name'], $row['user_email'], $row['user_contact'], $row['user_gender'], $row['user_address'], $row['branch'], $row['department'], $row['job_position'], $row['user_role'], $row['user_password'], $row['user_status']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
            
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'supplier') {
        // Fetch records from database 
        $query = $con->query("SELECT * from supplier ORDER BY supplierID ASC");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "supplier-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Output each row of the data, format line as csv and write to file pointer 
            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['supplierID'], $row['companyName'], $row['registrationNum'], $row['supplierAddress'], $row['country'], $row['supplierContact'], $row['supplierEmail'], $row['faxNum'], $row['typeOfBusiness'], $row['catalog'], $row['bizProfile'], $row['supplier_status']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'purchasebudget') {
        // Fetch records from database 
        $query = $con->query("SELECT * from purchasebudget");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "purchasebudget-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Output each row of the data, format line as csv and write to file pointer 
            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['budget_id'], $row['user_id'], $row['budget_amount'], $row['budget_description'], $row['date_created'], $row['budget_status']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'itemcategory') {
        // Fetch records from database 
        $query = $con->query("SELECT * from itemcategory");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "itemcategory-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Output each row of the data, format line as csv and write to file pointer 
            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['cat_id'], $row['cat_name'], $row['cat_description']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    }  else if ($dataExport == 'inventory') {
        // Fetch records from database 
        $query = $con->query("SELECT * from inventory");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "inventory-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Output each row of the data, format line as csv and write to file pointer 
            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['item_id'], $row['cat_id'], $row['item_name'], $row['item_description'], $row['item_quantity'], $row['item_unit_price'], $row['item_status']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'purchaseorder') {
        // Fetch records from database 
        $query = $con->query("SELECT * from purchaseorder");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "purchaseorder-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Output each row of the data, format line as csv and write to file pointer 
            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['po_id'], $row['pr_id'], $row['company_id'], $row['storageLocation'], $row['ship_to_address'], $row['po_status'], $row['supplierAccNo']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'po_details') {
        // Fetch records from database 
        $query = $con->query("SELECT * from po_details");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "po_details-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Output each row of the data, format line as csv and write to file pointer 
            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['no'], $row['po_id'], $row['supplierID'], $row['po_documentType'], $row['po_Date'], $row['po_delivery_date'], $row['item_id'], $row['po_itemQty'], $row['po_itemPrice'], $row['po_orderTotal'], $row['po_remark']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'potentialsupplier') {
        // Fetch records from database 
        $query = $con->query("SELECT * from potential_supplier");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "potentialsupplier-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Output each row of the data, format line as csv and write to file pointer 
            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['potential_id'], $row['companyName'], $row['registrationNum'], $row['supplierAddress'], $row['country'], $row['supplierContact'], $row['supplierEmail'], $row['faxNum'], $row['typeOfBusiness'], $row['catalog'], $row['status'], $row['reason'], $row['bizProfile']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'rating') {
        // Fetch records from database 
        $query = $con->query("SELECT * from rating");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "rating-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            // Output each row of the data, format line as csv and write to file pointer 
            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['id'], $row['rateID'], $row['supplierID'], $row['po_id'], $row['quality'], $row['delivery'], $row['price'], $row['service'], $row['overallQuality'], $row['overallDelivery'], $row['overallPrice'], $row['overallService'], $row['overallRating']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    }  else if ($dataExport == 'purchaserequisition') {
        // Fetch records from database 
        $query = $con->query("SELECT * from purchase_requisition");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "purchaserequisition-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['pr_id'], $row['user_id'], $row['pr_status'], $row['date_request'], $row['date_deliver_by'], $row['deliver_address'], $row['pr_total_amount'], $row['pr_purpose'], $row['pr_remark']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'pr_details') {
        // Fetch records from database 
        $query = $con->query("SELECT * from pr_details");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "pr_details-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['pr_id'], $row['item_id'], $row['qty_request'], $row['line_total']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'materialrequisition') {
        // Fetch records from database 
        $query = $con->query("SELECT * from material_requisition");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "materialrequisition-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['mr_id'], $row['user_id'], $row['mr_status'], $row['date_request'], $row['date_deliver_by'], $row['deliver_address'], $row['mr_total_amount'], $row['mr_purpose'], $row['mr_remark']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'mr_details') {
        // Fetch records from database 
        $query = $con->query("SELECT * from mr_details");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "mr_details-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['mr_id'], $row['item_id'], $row['qty_request'], $row['line_total']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'RFQ') {
        // Fetch records from database 
        $query = $con->query("SELECT * from rfq");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "rfq-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['id'], $row['RFQNo'], $row['pr_id'], $row['RFQ_Start_Date'], $row['productName'], $row['productQty'], $row['amount'], $row['totalPrice'], $row['supplierID'], $row['supplierEmail'], $row['Status'], $row['qrcode'], $row['supplierFeedback'], $row['quotationStatus'], $row['rejectReason']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'outsourcer') {
        // Fetch records from database 
        $query = $con->query("SELECT * from outsourcer");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "outsourcer-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['outsourcer_id'], $row['outsourcerName'], $row['contactNumber'], $row['address'], $row['email'], $row['serviceType'], $row['status']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    } else if ($dataExport == 'catalog') {
        // Fetch records from database 
        $query = $con->query("SELECT * from catalog");

        ob_end_clean();

        if ($query->num_rows > 0) {
            $delimiter = ",";
            $filename = "catalog-data_" . date('Y-m-d') . ".csv";

            // Create a file pointer 
            $f = fopen('php://memory', 'w');

            while ($row = $query->fetch_assoc()) {
                $lineData = array($row['catalog_id'], $row['supplierID'], $row['catalogFile'], $row['catalogDate']);
                fputcsv($f, $lineData, $delimiter);
            }

            // Move back to beginning of file 
            fseek($f, 0);

            // Set headers to download file rather than displayed 
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '";');

            //output all remaining data on a file pointer 
            fpassthru($f);
        }else{
            echo "<script>alert('No data in database!')</script>";
            echo("<script>location.href = '../administration/exportData.php';</script>");
        }
        exit;
    }
}
?>

<html>
    <head>
        <title>Export Data</title>

        <style>
            h2 {
                text-align: center;
                padding: 0.4em;
                margin-bottom: 0em;
            }

            label{
                width: 300px;
                display: inline-block;
                margin: 6px;
            }

            form{
                max-width: 700px;
                padding: 10px 20px;
                background: #f4f7f8;
                margin: 10px auto;
                padding: 20px;
                background: #f4f7f8;
                border-radius: 8px;
                font-family: Arial;
            }

            input {
                color: white;
                padding: 8px;
                font-family: Arial;
                background-color: #e7e7e7;
                color: black;
                display: block;
                border: 2px solid #ccc;
                width: 100%;
                margin: 10px auto;
                border-radius: 5px;
            }

            textarea {
                color: white;
                padding: 8px;
                font-family: Arial;
                background-color: #e7e7e7;
                color: black;
                display: block;
                border: 2px solid #ccc;
                width: 100%;
                margin: 10px auto;
                border-radius: 5px;
            }

            select {
                color: white;
                padding: 8px;
                font-family: Arial;
                background-color: #e7e7e7;
                color: black;
                display: block;
                border: 2px solid #ccc;
                width: 100%;
                margin: 10px auto;
                border-radius: 5px;
            }

            .submit{
                background-color: powderblue;
                font-family: 'Poppins', sans-serif;
            }
        </style>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <!--Bootstrap CSS library--> 
        <link rel="stylesheet" href=
              "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity=
              "sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              crossorigin="anonymous">

        <!--jQuery library--> 
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
                integrity=
                "sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>

        <!--JS library--> 
        <script src=
                "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity=
                "sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    </head>
    
    <body>
        <?php
        include '../administration/verifyUserType.php';
        ?>
        <br>
        <br>
        <div class="table-responsive mt-12">
            <h2 style="font-size: 60px">Export Data</h2> <br>
            <form action='' method='POST'>
                <label for="data">Select Data to Export: </label>
                <select id="data" name="data" class="form-control" required value="">
                    <option value="user" selected="selected" >User</option>
                    <option value="supplier">Supplier</option>
                    <option value="purchasebudget">Purchase Budget</option>
                    <option value="itemcategory">Item Category</option>
                    <option value="inventory">Inventory</option>
                    <option value="purchaseorder">Purchase Order</option>
                    <option value="po_details">Purchase Order Details</option>
                    <option value="potentialsupplier">Potential Supplier</option>
                    <option value="rating">Rating</option>
                    <option value="purchaserequisition">Purchase Requisition</option>
                    <option value="pr_details">Purchase Requisition Details</option>
                    <option value="materialrequisition">Material Requisition</option>
                    <option value="mr_details">Material Requisition Details</option>
                    <option value="RFQ">RFQ</option>
                    <option value="outsourcer">Outsourcer</option>
                    <option value="catalog">Catalog</option>
                </select> <br>

                <input type='submit' name='export' value="Export" class="submit" onclick="return confirm('Are you sure you want to export?');"> <br>
            </form>     
        </div>
    </body>
</html>
