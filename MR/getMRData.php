<?php
if (isset($_POST['page'])) {
    // Include pagination library file 
    include_once 'Pagination.php';

    // Include database configuration file 
    require_once 'connection.php';

    // Set some useful configuration 
    $baseURL = 'getMRData.php';
    $offset = !empty($_POST['page']) ? $_POST['page'] : 0;
    $limit = 10;

    // Set conditions for search 
    $whereSQL = '';
    if (!empty($_POST['keywords'])) {
        $whereSQL = " WHERE (mr_id LIKE '%" . $_POST['keywords'] . "%' OR user_id LIKE '%" . $_POST['keywords'] . "%' OR mr_status LIKE '%" . $_POST['keywords'] . "%') ";
    }
//    if (isset($_POST['filterBy']) && $_POST['filterBy'] != '') {
//        $whereSQL .= (strpos($whereSQL, 'WHERE') !== false) ? " AND " : " WHERE ";
//        $whereSQL .= " pr_status = " . $_POST['filterBy'];
//    }

    // Count of all records 
    $query = $con->query("SELECT COUNT(*) as rowNum FROM material_requisition " . $whereSQL);
    $result = $query->fetch_assoc();
    $rowCount = $result['rowNum'];

    // Initialize pagination class 
    $pagConfig = array(
        'baseURL' => $baseURL,
        'totalRows' => $rowCount,
        'perPage' => $limit,
        'currentPage' => $offset,
        'contentDiv' => 'dataContainer',
        'link_func' => 'searchFilter'
    );
    $pagination = new Pagination($pagConfig);

    // Fetch records based on the offset and limit 
    $query = $con->query("SELECT * FROM material_requisition $whereSQL ORDER BY mr_id LIMIT $offset,$limit");
    ?> 

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/fontawesome.min.css">-->

            <!--search-->
            <link rel="stylesheet" href="./style.css">

            <link href="css/bootstrap.min.css" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        </head>
        <body>
            <form action = "mrDetail.php" method ="post">
            <!-- Data list container --> 
            <table class="table table-striped" id="search" class="table table-bordered mt-4" style="width:90%; margin-left:auto;margin-right:auto;"> 
                <thead> 
                    <tr> 
                        <th class="col-md-1">No.</th> 
                        <th class="col-md-2">MR ID</th> 
                        <th class="col-md-2">User ID</th> 
                        <th class="col-md-2">Status</th> 
                        <th class="col-md-2">Total Amount</th> 
                        <th class="col-md-1"style="text-align: center">Update</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <?php
                    if ($query->num_rows > 0) {
                        while ($row = $query->fetch_assoc()) {
                            $offset++
                            ?> 
                            <tr> 
                                <th scope="row"><?php echo $offset; ?></th> 
                                <td><?php echo $row["mr_id"]; ?></td> 
                                <td><?php echo $row["user_id"]; ?></td> 
                                <td><?php echo $row["mr_status"]; ?></td> 
                                <td><?php echo $row["mr_total_amount"]; ?></td> 
                <td class="text-center"><button value="<?= $row["mr_id"] ?>" type="submit" id="update_button" name="mr_id" class="btn btn-primary">
                                    <i class="fa fa-edit"></i></button></td>
                        
                    </tr> 
                    <?php
                }
            } else {
                echo '<tr><td colspan="6">No records found...</td></tr>';
            }
            ?> 
        </tbody> 
    </table> 
</form>
    <!-- Display pagination links --> 
    <?php echo $pagination->createLinks(); ?> 

    <?php
}
?>
</body>
</html>  