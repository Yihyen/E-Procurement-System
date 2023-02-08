<?php
session_start();
include '../administration/verifyUserType.php';
include('connection.php');
?>

<?php
// Include pagination library file 
include_once 'Pagination.php';

// Include database configuration file 
require_once 'connection.php';

// Set some useful configuration 
$baseURL = 'getMRData.php';
$limit = 10;

// Count of all records 
$query = $con->query("SELECT COUNT(*) as rowNum FROM material_requisition");
$result = $query->fetch_assoc();
$rowCount = $result['rowNum'];

// Initialize pagination class 
$pagConfig = array(
    'baseURL' => $baseURL,
    'totalRows' => $rowCount,
    'perPage' => $limit,
    'contentDiv' => 'dataContainer',
    'link_func' => 'searchFilter'
);
$pagination = new Pagination($pagConfig);

// Fetch records based on the limit 
$query = $con->query("SELECT * FROM material_requisition ORDER BY mr_id LIMIT $limit");
?>

<style>
    .has-search .form-control {
        padding-left: 2.375rem;
    }

    .has-search .form-control-feedback {
        position: absolute;
        z-index: 2;
        display: block;
        width: 2.375rem;
        height: 2.375rem;
        line-height: 2.375rem;
        text-align: center;
        pointer-events: none;
        color: #aaa;
        font-size: 18px;
    }
</style>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>MR Approval</title>
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
        <script>
            function searchFilter(page_num) {
                page_num = page_num ? page_num : 0;
                var keywords = $('#keywords').val();
                $.ajax({
                    type: 'POST',
                    url: 'getMRData.php',
                    data: 'page=' + page_num + '&keywords=' + keywords,
                    beforeSend: function () {
                        $('.loading-overlay').show();
                    },
                    success: function (html) {
                        $('#dataContainer').html(html);
                        $('.loading-overlay').fadeOut("slow");
                    }
                });
            }
        </script>
        <br>
        <h2 class="text-center mt-3">Material Requisition Approval</h2>
        <div class="mt-5 border-1" style="margin-left:260px;margin-right:260px;">
            <div class="table-repsonsive table-bordered">
                <div class="card-body">
                    <div class="card-body">

                        <div class="search-panel">
                            <div class="row">
                                <div class="form-group d-flex col-md-5 mt-5 has-search" style="margin-left:75px;margin-right:70px;">
                                    <span class="fa fa-search form-control-feedback"></span>
                                    <input type="text" class="form-control" id="keywords" placeholder="Search by MR ID, User ID, Status" onkeyup="searchFilter();">
                                    <div class="input-group-append mt-2 h4 text-body" style="flex:10% 0 0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="datalist-wrapper">
                            <div id="dataContainer" class="mt-5">
                                <table class="table table-striped" class="table table-bordered mt-5" style="width:90%; margin-left:auto;margin-right:auto;">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">No.</th>
                                            <th class="col-md-2">MR ID</th>
                                            <th class="col-md-2">User ID</th>
                                            <th class="col-md-2">Status</th>
                                            <th class="col-md-2">Total Amount</th>
                                            <th class="col-md-1" style="text-align: center">Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($query->num_rows > 0) {
                                            $i = 0;
                                            while ($row = $query->fetch_assoc()) {
                                                $i++;
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td><?php echo $row["mr_id"]; ?></td>
                                                    <td><?php echo $row["user_id"]; ?></td>
                                                    <td><?php echo $row["mr_status"]; ?></td>
                                                    <td><?php echo $row["mr_total_amount"]; ?></td>
                                            <form action = "mrDetail.php" method ="post">
                                                <td class="text-center"><button type="submit" id="update_button" name="update" class="btn btn-primary">
                                                        <i class="fa fa-edit"></i></button></td>
                                                <input type = "hidden" name = "mr_id" value = "<?= $row['mr_id'] ?>"/>
                                            </form>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="6">No records found...</td></tr>';
                                    }
                                    ?>

                                    </tbody>
                                </table>
                                <?php echo $pagination->createLinks(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>                   

