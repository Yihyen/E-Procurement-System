<?php
session_start();
include '../administration/verifyUserType.php';
include('connection.php');
$mrid = $_POST['mr_id'];
$mr_query1 = mysqli_query($result, "SELECT * from mr_details WHERE mr_id = '" . $mrid . "' ORDER BY mr_id ");
//if (mysqli_num_rows($pr_query1) > 0) {
while ($rows = mysqli_fetch_array($mr_query1)) {
    $mr_id = $rows['mr_id'];
    $item_id = $rows['item_id'];
    $qty_request = $rows['qty_request'];
    $line_total = $rows['line_total'];
    ?>
    <?php
}
?>

<?php
$mr_query = mysqli_query($result, "select * from material_requisition MR JOIN user u WHERE u.user_id = MR.user_id AND MR.mr_id = '" . $mrid . "'");
if (mysqli_num_rows($mr_query) > 0) {
    while ($rows = mysqli_fetch_array($mr_query)) {
        $mr_id = $rows['mr_id'];
        $user_id = $rows['user_id'];
        $user_name = $rows['name'];
        $mr_status = $rows['mr_status'];
        $date_request = $rows['date_request'];
        $mr_total_amount = $rows['mr_total_amount'];
        $mr_remark = $rows['mr_remark'];
        $branch = $rows['branch'];
        $address = $rows['user_address'];
        $user_contact = $rows['user_contact'];
        $user_email = $rows['user_email'];
        $department = $rows['department'];
        $mr_purpose = $rows['mr_purpose'];
        $date_deliver_by = $rows['date_deliver_by'];
        $deliver_address = $rows['deliver_address'];
        ?>
        <?php
    }
}

$orgDate = "$date_request";
$newDate = date("d-m-Y", strtotime($orgDate));

$date_deliver = "$date_deliver_by";
$new_date_deliver_by = date("d-m-Y", strtotime($date_deliver));
?>

<style>
    .key {
        width: 25%;
    }

    .key2 {
        width: 12.3%;
    }

    .key3 {
        width: 25.6%;
    }

    .val::before {
        content: ': ';
    }

    input {
        color: white;
        /*padding: 8px;*/
        font-family: Arial;
        font-size: 6px;
        background-color: #e7e7e7;
        color: black;
        /*display: block;*/
        border: 2px solid #ccc;
        /*                width: 100%;
                        margin: 10px auto;*/
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

    td{
        color: white;
        font-family: Arial;
        background-color: #e7e7e7;
        color: black;
        border: 2px solid #ccc;
    }

    label {
        font-family: Arial;
    }

</style>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>MR Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    </head>
    <body>
        <br>
        <div class="container p-3 my-6 mt-5 border">
            <div align="right">
                <label type="submit" id="close_button" name="close" style="font-size:24px" onClick="document.location.href = 'approve_mr.php'">
                    <i class="fa fa-close"></i></label>
            </div>
            <form name="detailForm" id="detailForm" method="POST" action="MRemail.php">
                <div class="row">
                    <div class="form-group col-md-6 ml-md-5 mt-3 form-inline">
                        <label class="key" for="mr_id">PR ID </label>
                        <label class="ml-md-3 val" id="prid" name='mrid'><?php echo $mr_id; ?></label>
                        <input value="<?php echo $mr_id; ?>" type = "hidden" name = "mr_id">
                    </div>

                    <div id="requestDate" class="form-group col-md-6 ml-md-5 mt-3 form-inline">
                        <label class="key" for="dateRequest">Date Request  </label>
                        <label class="ml-md-3 val"><?php echo $newDate; ?></label>
                        <input value="<?php echo $newDate; ?>" type = "hidden" name = "date_request">
                    </div>

                    <div class="form-group col-md-6 ml-md-5 mt-2 mt-3">
                        <label class="key" for="user_id">User ID  </label>
                        <label class="mt-1 val"><?php echo $user_id; ?></label>
                        <input value="<?php echo $user_id; ?>" type = "hidden" name = "user_id">
                        <input value="<?php echo $user_name; ?>" type = "hidden" name = "user_name">
                    </div>

                    <div id="department" class="form-group col-md-6 ml-md-5 mt-3">
                        <label class="key" for="department">Department  </label>
                        <label class="mt-1 val"><?php echo $department; ?></label>
                        <input value="<?php echo $department; ?>" type = "hidden" name = "department">
                    </div>

                    <div id="user_email" class="form-group col-md-6 ml-md-5 mt-3">
                        <label class="key" for="user_email">Email  </label>
                        <label class="mt-1 val" id="user_email" name="user_email"><?php echo $user_email; ?></label>
                        <input value="<?php echo $user_email; ?>" type = "hidden" name = "user_email">
                    </div>

                    <div class="form-group col-md-6 ml-md-5 mt-3">
                        <label class="key" for="branch">Branch  </label>
                        <label class="mt-1 val"><?php echo $branch; ?></label>
                        <input value="<?php echo $branch; ?>" type = "hidden" name = "branch">
                    </div>

                    <div id="user_contact" class="form-group col-md-6 ml-md-5 mt-3">
                        <label class="key" for="user_contact">Contact Number  </label>
                        <label class="mt-1 val"><?php echo $user_contact; ?></label>
                        <input value="<?php echo $user_contact; ?>" type = "hidden" name = "user_contact">
                    </div>

                    <div id="address" class="form-group ml-md-5 mt-3">
                        <label class="key2" for="address">Address  </label>
                        <label class="mt-1 val"><?php echo $address; ?></label>
                        <input value="<?php echo $address; ?>" type = "hidden" name = "address">
                    </div>

                    <hr class="mt-5">

                    <div class="form-group position-relative ml-md-5 mt-4">
                        <label class="key2" for="inputPurpose">Purpose </label>
                        <label class="mt-1 val"><?php echo $mr_purpose; ?></label>
                        <input value="<?php echo $mr_purpose; ?>" type = "hidden" name = "mr_purpose">
                    </div>

                    <div class="form-group position-relative mt-4 ml-md-5">
                        <label class="key2" for="inputAddress">Address </label>
                        <label class="mt-1 val"><?php echo $deliver_address; ?></label>
                        <input value="<?php echo $deliver_address; ?>" type = "hidden" name = "deliver_address">
                    </div>

                    <div class="form-group position-relative mt-4 ml-md-5">
                        <label class="key2" for="input_mr_remark">Remark </label>
                        <label class="mt-1 val"><?php echo $mr_remark; ?></label>
                        <input value="<?php echo $mr_remark; ?>" type = "hidden" name = "mr_remark">
                    </div>

                    <div class="form-group position-relative col-md-6 mt-4 ml-md-5">
                        <label class="key" for="inputDeliveryDate">Delivery Date </label>
                        <label class="mt-1 val"><?php echo $new_date_deliver_by; ?></label>
                        <input value="<?php echo $new_date_deliver_by; ?>" type = "hidden" name = "new_date_deliver_by">
                    </div>

                    <div class="form-group position-relative col-md-6 mt-4 ml-md-5">
                        <label class="key" for="input_mr_status">Status</label>
                        <span class="val"></span>
                        <select class="mt-1" name="mrStatus" id="prStatus" onchange="showfield(this.options[this.selectedIndex].value)">
                            <option value="" disabled selected><?php echo $mr_status; ?></option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div id="div1" class="form-group position-relative col-md-6 mt-4 ml-md-5">
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-repsonsive">
                        <table class="table table-bordered mt-5" style=" margin-left:auto;margin-right:auto;">
                            <thead>
                                <tr>
                                    <th class="col-md-1" style="text-align: center">No.</th>
                                    <th class="col-md-3" style="text-align: center">Item ID</th>
                                    <th class="col-md-3" style="text-align: center">Quantity</th>
                                    <th class="col-md-3" style="text-align: center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sl = 0;
                                $prid = $_POST['mr_id'];
                                $mr_query1 = mysqli_query($result, "SELECT * from mr_details WHERE mr_id = '" . $mrid . "' ORDER BY mr_id ");
                                if (mysqli_num_rows($mr_query1) > 0) {
                                    while ($rows = mysqli_fetch_array($mr_query1)) {
                                        $sl++;
                                        $mr_id = $rows['mr_id'];
                                        $item_id = $rows['item_id'];
                                        $qty_request = $rows['qty_request'];
                                        $line_total = $rows['line_total'];
                                        ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo $sl; ?>.</td>
                                            <td style="text-align: center"><?php echo $item_id; ?></td>
                                            <td style="text-align: center"><?php echo $qty_request; ?></td>
                                            <td style="text-align: center"><?php echo $line_total; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th id="total" colspan="3" style="text-align: right">Total :</th>
                                    <td style="text-align: center"><?php echo $mr_total_amount; ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div style="text-align: center">
                    <button type="submit" style="text-align: center" id="update_button" name="update_button" class="btn btn-success col-md-1" onclick="clicked()" >Update</button>
                    <input type="hidden" name="update_button" value="">

                    <button type="reset" style="text-align: center" id="cancel_button" name="cancel_button" class="btn btn-danger col-md-1">Cancel</button>      
                </div>
            </form>
        </div>

        <script type="text/javascript">
            function showfield(name) {
                if (name == 'Rejected')
                    document.getElementById('div1').innerHTML = '<label class="key3" for="reason">Reason</label><span class="val"></span><input class="col-md-8 ml-md-5" type="text" name="reason" required=""/>';
                else
                    document.getElementById('div1').innerHTML = '<input type = "hidden" class="col-md-8 ml-md-5" type="text" name="reason" value="N/A"/>';
            }
        </script>

        <script>
            var el = document.getElementById('detailForm');

            el.addEventListener('submit', function () {
                return confirm('Are you sure you want to update this MR status?');
            }, false);
        </script>

        <script>

            $("#cancel_button").on("click", function () {
                $("#mrStatus").val('<?php echo $mr_status; ?>');
            });
        </script>
    </body>
</html>                   

