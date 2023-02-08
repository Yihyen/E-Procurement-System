<!DOCTYPE html>
<?php
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

if (isset($_POST["import"])) {
    $dataImport = $_POST["data"];
    
    $fileName = $_FILES["file"]["tmp_name"];

    if ($dataImport == 'user') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO user (user_id, user_name, name, user_email, user_contact, user_gender, user_address, branch, department, job_position, user_role, user_password, user_status) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "', '" . $column[9] . "', '" . $column[10] . "', '" . $column[11] . "', '" . $column[12] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }
            
            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
            
        }
    } else if ($dataImport == 'supplier'){
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO supplier (supplierID, companyName, registrationNum, supplierAddress, country, supplierContact, supplierEmail, faxNum, typeOfBusiness, catalog, bizProfile, supplier_status) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "', '" . $column[9] . "', '" . $column[10] . "', '" . $column[11] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }
            
            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
            
        }
    } else if ($dataImport == 'purchasebudget') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO purchasebudget (budget_id, user_id, budget_amount, budget_description, date_created, budget_status) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }
            
            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
            
        }
    } else if ($dataImport == 'itemcategory') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO itemcategory (cat_id, cat_name, cat_description) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }
            
            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
            
        }
    }else if ($dataImport == 'inventory') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO inventory (item_id, cat_id, item_name, item_description, item_quantity, item_unit_price, item_status) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'purchaseorder') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO purchaseorder (po_id, pr_id, company_id, storageLocation, ship_to_address, po_status, supplierAccNo) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'po_details') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO po_details (no, po_id, supplierID, po_documentType, po_Date, po_delivery_date, item_id, po_itemQty, po_itemPrice, po_orderTotal, po_remark) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "', '" . $column[9] . "', '" . $column[10] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'potentialsupplier') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO potential_supplier (potential_id, companyName, registrationNum, supplierAddress, country, supplierContact, supplierEmail, faxNum, typeOfBusiness, catalog, status, reason, bizProfile) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "', '" . $column[9] . "', '" . $column[10] . "', '" . $column[11] . "', '" . $column[12] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'rating') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO rating (id, rateID, supplierID, po_id, quality, delivery, price, service, overallQuality, overallDelivery, overallPrice, overallService, overallRating) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "', '" . $column[9] . "', '" . $column[10] . "', '" . $column[11] . "', '" . $column[12] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'purchaserequisition') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO purchase_requisition (pr_id, user_id, pr_status, date_request, date_deliver_by, deliver_address, pr_total_amount, pr_purpose, pr_remark) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'pr_details') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO pr_details (pr_id, item_id, qty_request, line_total) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'materialrequisition') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO material_requisition (mr_id, user_id, mr_status, date_request, date_deliver_by, deliver_address, mr_total_amount, mr_purpose, mr_remark) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'mr_details') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO mr_details (mr_id, item_id, qty_request, line_total) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'RFQ') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO rfq (id, RFQNo, pr_id, RFQ_Start_Date, productName, productQty, amount, totalPrice, supplierID, supplierEmail, Status, qrcode, supplierFeedback, quotationStatus, rejectReason) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "', '" . $column[7] . "', '" . $column[8] . "', '" . $column[9] . "', '" . $column[10] . "', '" . $column[11] . "', '" . $column[12] . "', '" . $column[13] . "', '" . $column[14] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'outsourcer') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO outsourcer (outsourcer_id, outsourcerName, contactNumber, address, email, serviceType, status) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "', '" . $column[4] . "', '" . $column[5] . "', '" . $column[6] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }else if ($dataImport == 'catalog') {
        if ($_FILES["file"]["size"] > 0) {
            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sqlInsert = "INSERT INTO catalog (catalog_id, supplierID, catalogFile, catalogDate) values ('" . $column[0] . "', '" . $column[1] . "', '" . $column[2] . "', '" . $column[3] . "')";

                $result = mysqli_query($con, $sqlInsert);
            }

            if (!empty($result)) {
                echo "<script>alert('Data successfully imported!')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            } else {
                echo "<script>alert('Data import failed! Please try again.')</script>";
                echo("<script>location.href = '../administration/importData.php';</script>");
            }
        }
    }
}

?>

<html>
    <head>
        <title>Import Data</title>

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

            .import{
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
        <br>
        <br>
        <div class="importData">
            <h2 style="font-size: 60px">Import Data</h2> <br>

            <form action = "" method="post" id="importData" class="center" enctype="multipart/form-data">

                <label for="data">Select Data to Import: </label>
                <select id="data" name="data" class="form-control" required value="">
                    <option value="user" selected="selected" >User</option>
                    <option value="supplier">Supplier</option>
                    <option value="supplier">Potential Supplier</option>
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
                
                <!--csv file-->
                <label for="file">Choose CSV File: </label>
                <input type="file" name="file" class="form-control" required value="" /> <br>
                
                <input type="submit" name="import" value="Import" class="import" onclick="return confirm('Are you sure you want to import');"><br>

            </form>
        </div>
    </body>
</html>
