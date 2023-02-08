<?php  
    session_start();
    //Database connectivity  
    $con=mysqli_connect('localhost','root','','procurementsystem'); 
    
    // $sql=mysqli_query($con,"select * from rfq");  
    // //Get Update id and status   
    // if (isset($_GET['RFQNo']) && isset($_GET['Status'])) {  
    //     $quotationID=$_GET['quotationID'];  
    //     $returnQuoteStatus=$_GET['returnQuoteStatus'];  
    //     mysqli_query($con,"update rfq set returnQuoteStatus='$returnQuoteStatus' where quotationID='$quotationID'");  
    //     header("location:quotationSupplier.php");  
    //     die();  
    // }

?>

<!DOCTYPE html>
<html>
<head>
    <title>RFQ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .btn {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 20%;
                background-color: thistle;
                color: blue;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-left: auto;
                margin-right: auto;

            }

            .viewbtn{
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 20%;
                background-color: thistle;
                color: blue;
                padding: 10px 10px;
                margin: 8px 0;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-left: auto;
                margin-right: auto;
            }

            .container {
                margin-top: 5%;
            }
    </style>

</head>

<body>
    <div class="container">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>RFQ ID</th>
                <th>Customer Name</th>
                <th>Date Created</th>
                <th>RFQ Status</th>
                <th>Return Quotation Action</th>

            </tr>
        </thead>

        <tbody>
            <?php
                
                $conn = mysqli_connect ("localhost" , "root" , "" , "procurementsystem");
                $companyName = $_SESSION['companyName'];
                
                $sql = "SELECT * FROM rfq r, supplier s WHERE r.Status = 'Pending' AND r.supplierID = s.supplierID AND s.companyName = '$companyName'";
               
                $result = mysqli_query($conn, $sql);

                if(mysqli_num_rows($result) == 0){
                    echo "<tr><td colspan='5' style='text-align:center;'>No Request For Quotation Currently</td></tr>";
                }else{
                    $previewRow = '';
                    while ($row = mysqli_fetch_array($result)) {
                        if($row['RFQNo'] != $previewRow ){
                ?>
                        
                
                    <tr>
                        <td><?php echo $row['RFQNo']; ?></td>
                        <td><?php echo $companyName; ?></td>
                        <td><?php echo $row['RFQ_Start_Date']; ?></td>
                        <td><?php echo $row['Status']; ?></td>     
                        <td>
                            <p><a style="text-decoration: none;" href="viewQuote.php?RFQNo=<?php echo $row['RFQNo']; ?>"class="viewbtn">View</a></p>
                        </td>
                    </tr>

                <?php 
                    }
                    $previewRow = $row['RFQNo'];
                    } 
                }
                ?>
    
        </tbody>
    </table>

    <a href="index.php" class="btn">Back</a>
    </div>
</body>
</html>