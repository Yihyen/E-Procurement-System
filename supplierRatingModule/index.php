<?php

// Start session
session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

// Get session data
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:'';

// Get status message from session
if(!empty($sessData['status']['msg'])){
    $statusMsg = $sessData['status']['msg'];
    $statusMsgType = $sessData['status']['type'];
    unset($_SESSION['sessData']['status']);
}

// Load pagination class
require_once 'Pagination.class.php';

// Load and initialize database class
require_once 'DB.class.php';
$db = new DB();

// Page offset and limit
$perPageLimit = 6;
$offset = !empty($_GET['page'])?(($_GET['page']-1)*$perPageLimit):0;

// Get search keyword
$searchKeyword = !empty($_GET['sq'])?$_GET['sq']:'';
$searchStr = !empty($searchKeyword)?'?sq='.$searchKeyword:'';

// Search DB query
$searchArr = '';
if(!empty($searchKeyword)){
    $searchArr = array(
        'companyName' => $searchKeyword,
        'supplierEmail' => $searchKeyword
        //'phone' => $searchKeyword
    );
}

// Get count of the users
$con = array(
    'like_or' => $searchArr,
    'return_type' => 'count'
);
$rowCount = $db->getRows('supplier', $con);

// Initialize pagination class
$pagConfig = array(
    'baseURL' => 'index.php'.$searchStr,
    'totalRows' => $rowCount,
    'perPage' => $perPageLimit
);
$pagination = new Pagination($pagConfig);

// Get users from database
$con = array(
    'like_or' => $searchArr,
    'start' => $offset,
    'limit' => $perPageLimit,
    'order_by' => 'supplierID ASC',
);
$supplier = $db->getRows('supplier', $con);
?>

<!-- Display status message -->
<?php if(!empty($statusMsg) && ($statusMsgType == 'success')){ ?>
<div class="alert alert-success"><?php echo $statusMsg; ?></div>
<?php }elseif(!empty($statusMsg) && ($statusMsgType == 'error')){ ?>
<div class="alert alert-danger"><?php echo $statusMsg; ?></div>
<?php } ?>

<head>
    <meta charset="UTF-8">
    <title>Supplier Rating</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<div class="row" style="width: 80%; margin: 50px auto; padding:10px; border:1px solid black;">
    <div class="col-md-12 search-panel">
        <!-- Search form -->
        <form>
        <div class="input-group">
            <input type="text" name="sq" class="form-control" placeholder="Search by keyword..." value="<?php echo $searchKeyword; ?>">
            
                <button class="btn btn-default" type="submit">
                    Search
                </button>
           
        </div>
        </form>
        
        <!-- Add link -->
        <!--<span class="pull-right">
            <a href="addEdit.php" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> New User</a>
        </span>-->
    </div>
    
    <!-- Data list table --> 
    <form method="GET" action="">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th></th>
                <th>Supplier Name</th>
                <th>Supplier Email</th>
                <th>Supplier Rating</th>
                <th>Action</th>
      
            </tr>
        </thead>
        <tbody>
            <?php

            if(!empty($supplier))

            {   
                $count = 0; 
                foreach($supplier as $supplier){ $count++;
            ?>
            <tr>             
                <td><?php echo '#'.$count; ?></td>
                <td><?php echo $supplier['companyName']; ?></td>
                <td><?php echo $supplier['supplierEmail']; ?></td>
                
                <?php
                    $supplierID = $supplier['supplierID'];
                    $conn = mysqli_connect("localhost", "root", "", "procurementsystem");
                    $sql = "SELECT AVG(overallRating) as rating FROM rating WHERE supplierID = '$supplierID'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $supplierRating = $row['rating'];

                ?>
                 
                <td><?php 
                echo number_format((float)$supplierRating, 2, '.', '');
                ?></td>
                
                <td>
                   
                    <a style="text-decoration: none;" href="orders.php?supplierID=<?php echo $supplier['supplierID']; ?>">Purchase Orders</a>
                    
                    <!--<a href="addEdit.php?supplierID=<?php echo $supplier['supplierID']; ?>">Edit</a>
                    <a href="userAction.php?action_type=delete&supplierID=<?php echo $supplier['supplierID']; ?>" onclick="return confirm('Are you sure to delete?')">Delete</a>-->
                </td>
            </tr>
		</div>

            <?php } }else{ ?>
            <tr><td colspan="5">No user(s) found......</td></tr>
            <?php } ?>
        </tbody>
    </table>
    </form>
    
    <!-- Display pagination links -->
    <?php echo $pagination->createLinks(); ?>
</div>


