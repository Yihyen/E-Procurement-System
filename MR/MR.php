<?php
session_start();
include '../administration/verifyUserType.php';
?>

<?php
include('../connection/dbCon.php');

function fill_select_item_box($con) {
    $output = '';
    $sql = "SELECT * FROM inventory WHERE item_status = 'available' AND item_quantity >=1 ORDER BY item_id ASC";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($result)) {
        $output .= '<option value ="' . $row["item_unit_price"] . '">' . $row["item_id"] . '</option>';
    }
    return $output;
}
?>

<?php
$query2 = "select mr_id from material_requisition order by mr_id desc";
$result2 = mysqli_query($con, $query2);
$row = mysqli_fetch_array($result2);

$last_id = $row['mr_id'] ?? null;

if (!is_null($row)) {

    $idd = str_replace("22MR", "", $last_id);

    $id = str_pad($idd + 1, 6, 0, STR_PAD_LEFT);
    $mr_ID = '22MR' . $id;
} else {
    $mr_ID = "22MR000001";
}
?>

<?php
$result = $con->query("SELECT * FROM user where user_name='" . $_SESSION["username"] . "'")->fetch_array();
?>

<style>
    .key {
        width: 25%;
    }

    .key2 {
        width: 16.6%;
    }

    .key3 {
        width: 14.8%;
    }

    .val::before {
        content: ': ';
    }

    .submit{
        background-color: powderblue;
        font-family: 'Poppins', sans-serif;
    }
    label {
        font-size: 15px;
    }

    input {
        color: white;
        padding: 8px;
        font-family: Arial;
        font-size: 6px;
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

    td{
        color: white;
        font-family: Arial;
        background-color: #e7e7e7;
        color: black;
        border: 2px solid #ccc;
    }
</style>

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="UTF-8">
        <title>Material Requisition</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="pr.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <h2 class="text-center mt-4">Material Requisition Form</h2>

        <div class="container p-3 my-6 mt-5 border">
            <form method="POST" id="insert_form">
                <div align="right">
                    <label type="submit" id="close_button" name="close" style="font-size:24px" onClick="document.location.href = '../administration/homePage.php'">
                        <i class="fa fa-close"></i></label>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 ml-md-5 mt-3">
                        <label class="key" for="pr_id">MR ID </label>
                        <label class="ml-md-3 val"><?php echo $mr_ID; ?></label>
                    </div>

                    <div id="requestDate" class="form-group col-md-4 ml-md-5 mt-3">
                        <label class="key" for="dateRequest">Date Request </label>
                        <label class="ml-md-3 val"><?php echo date('d-m-Y'); ?></label>
                    </div>

                    <div class="form-group col-md-6 ml-md-5 mt-2">
                        <label class="key" for="inputUserid">User ID </label>
                        <label class="ml-md-3 val" id="inputUserid" name="inputUserid"><?php echo $result["user_id"]; ?></label>
                        <input value="<?php echo $result["user_id"]; ?>" type = "hidden" name = "inputUserid1">
                    </div>

                    <div id="department" class="form-group col-md-4 ml-md-5 mt-2">
                        <label class="key" for="department">Department </label>
                        <label class="ml-md-3 val"><?php echo $result["department"]; ?></label>
                    </div>

                    <div id="user_email" class="form-group col-md-6 ml-md-5">
                        <label class="key" for="user_email">Email </label>
                        <label class="ml-md-3 val"><?php echo $result["user_email"]; ?></label>
                    </div>

                    <div class="form-group col-md-4 ml-md-5 ">
                        <label class="key" for="branch">Branch </label>
                        <label class="ml-md-3 val"><?php echo $result["branch"]; ?></label>
                    </div>

                    <div id="user_contact" class="form-group col-md-6 ml-md-5">
                        <label class="key" for="user_contact">Contact Number </label>
                        <label class="ml-md-3 val"><?php echo $result["user_contact"]; ?></label>
                    </div>

                    <div id="address" class="form-group col-md-10 ml-md-5">
                        <label class="key3" for="address">Address </label>
                        <label class="ml-md-3 val"><?php echo$result["user_address"]; ?></label>
                    </div>
                </div>

                <div class="form-group position-relative mt-5 ml-md-3">
                    <label for="inputPurpose">Purpose :</label>
                    <textarea id="inputPurpose" name="inputPurpose" rows="3" required="" 
                              oninvalid="this.setCustomValidity('Please enter your purpose!')"
                              oninput="setCustomValidity('')"></textarea> 
                </div>

                <div class="form-group position-relative mt-5 ml-md-3">
                    <label for="inputAddress">Address :</label>
                    <input type="text" id="inputAddress" name="inputAddress" placeholder="" required="" 
                           oninvalid="this.setCustomValidity('Please enter your address!')"
                           oninput="setCustomValidity('')">
                </div>

                <div class="form-group position-relative mt-5 ml-md-3">
                    <label for="inputDeliveryDate">Delivery Date :</label>
                    <input type="date" class="col-md-3" id="inputDeliveryDate" name="inputDeliveryDate" required="" 
                           oninvalid="this.setCustomValidity('Please select date!')"
                           oninput="setCustomValidity('')"/>
                </div>

                <br />
                <div class="container">
                    <div class="card">
                        <div class="card-header">Enter Item Details</div>
                        <div class="card-body">
                            <span id="error"></span>
                            <div class="table-repsonsive">
                                <table class="table table-bordered" id="item_table">
                                    <tr calss="item">
                                        <th class="col-md-2">Item ID</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th style="display: none">Unit Price</th>
                                        <th>Total</th>
                                        <th><button type="button" id="add_button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                    <tfoot>
                                        <tr>
                                            <th id="total" colspan="3" style="text-align: right">Total :</th>
                                            <td><input type="text" class="ml-md-1 grandTotal" style="text-align: right" name="grandTotal" id="grandTotal" disabled/></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group position-relative mt-3 ml-md-3">
                    <label for="inputRemark">Remark :</label>
                    <input type="text" class="form-control" id="inputAddress" name="inputRemark" placeholder="Enter Your Remark" value="N/A" />
                </div>

                <div class="form-group mt-4 ml-md-3">
                    <input type="submit" name="submit" id="submit_button" class="submit" value="Submit" />
                </div>
            </form>
        </div>

        <script>
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;
            $('#inputDeliveryDate').attr('min', today);
        </script>

        <script>
            $(document).ready(function () {

                var count = 0;

                function add_input_field(count)
                {
                    var html = '';
                    html += '<tr>';
                    html += '<td><select name="itemid[]" id="itemid" class=" selectpicker" data-live-search="true" required=""><option value="" disabled selected>Select Item ID</option><?php echo fill_select_item_box($con); ?></select></td>';
                    html += '<td><input type="number" name="quantity[]" id="quantity" min="1" oninput="this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null" value="1" style="text-align: center" placeholder="Enter quantity" style="text-align: center" class="qty"/></td>';
                    html += '<td><input type="text" name="unitPrice[]" id="unitPrice" class="price unitPrice" style="text-align: right" disabled/></td>';
                    html += '<td style= "display: none"><input type="hidden" name="itemid2[]" id="itemid2" class="itemid2 form-control" style="text-align: right" disabled/></td>';
                    html += '<td><input type="text" name="lineTotal[]" id="lineTotal" class="lineTotal" style="text-align: right" disabled/></td>';

                    var remove_button = '';
                    if (count > 0)
                    {
                        remove_button = '<button type="button" id="remove_button" name="remove" class="btn btn-danger btn-sm remove mt-2"><i class="fa fa-minus"></i></button>';
                    }

                    html += '<td>' + remove_button + '</td></tr>';
                    return html;
                }
                ;

                $('#item_table').append(add_input_field(0));
                $('.selectpicker').selectpicker('refresh');
                $(document).on('click', '.add', function () {

                    count++;
                    $('#item_table').append(add_input_field(count));
                    $('.selectpicker').selectpicker('refresh');
                });

                $('#item_table').on("change", '.selectpicker', function () {
                    {
                        var $el = $(this).closest('tr');
                        var selectedValue = $el.find(this).val();
                        var itemid = $el.find("#itemid option:selected").text();
                        $(this).closest("tr").find('.price').val(selectedValue);
                        $(this).closest("tr").find('.itemid2').val(itemid);
                        $(this).closest("tr").find('.lineTotal').val(selectedValue);
                        $(this).closest("tr").find('.qty').val('1');

                        var sum = 0;
                        //iterate through each textboxes and add the values
                        $(".lineTotal").each(function () {

                            //add only if the value is number
                            if (!isNaN(this.value) && this.value.length != 0) {
                                sum += parseFloat(this.value);
                            }

                        });
                        //.toFixed() method will roundoff the final sum to 2 decimal places
                        $(".grandTotal").val(sum.toFixed(2));

                        (function () {
                            "use strict";

                            $("table").on("change", "input", function () {
                                var row = $(this).closest("tr");
                                var qty = parseFloat(row.find(".qty").val());
                                var price = parseFloat(row.find(".price").val());
                                var total = qty * price;
                                row.find(".lineTotal").val(isNaN(total) ? "" : total.toFixed(2));

                                var sum = 0;

                                $(".lineTotal").each(function () {

                                    if (!isNaN(this.value) && this.value.length != 0) {
                                        sum += parseFloat(this.value);
                                    }

                                });

                                $(".grandTotal").val(sum.toFixed(2));

                            });
                        })();
                    }
                });

                $(document).on('click', '.remove', function () {

                    $(this).closest('tr').remove();

                    var sum = 0;

                    $(".lineTotal").each(function () {

                        if (!isNaN(this.value) && this.value.length != 0) {
                            sum += parseFloat(this.value);
                        }

                    });

                    $(".grandTotal").val(sum.toFixed(2));
                });


                $('#insert_form').on('submit', function (event) {

                    event.preventDefault();

                    var error = '';

                    count = 1;

                    $("select[name='itemid[]']").each(function () {

                        if ($(this).val() == '')
                        {

                            error += "<li>Select Item ID at " + count + " Row</li>";

                        }

                        count = count + 1;

                    });

                    var grandTotal = $("#grandTotal").val();
                    var itemid2 = [];
                    $('input[name="itemid2[]"]').each(function () {
                        itemid2.push(this.value);
                    });
                    var lineTotal = [];
                    $('input[name="lineTotal[]"]').each(function () {
                        lineTotal.push(this.value);
                    });

                    if (error == '')
                    {
                        if (!confirm('Are you sure to submit this MR?'))
                        {
                            e.preventDefault();
                            return false;
                        }

                        $.ajax({
                            url: "InsertMR.php",
                            method: "POST",
                            data: $(this).serialize() + "&itemid2=" + itemid2 + '&lineTotal=' + lineTotal + '&grandTotal=' + grandTotal,

                            beforeSend: function ()
                            {

                                $('#submit_button').attr('disabled', 'disabled');
                                $('#add_button').attr('disabled', 'disabled');
                                $('#remove_button').attr('disabled', 'disabled');
                            },
                            success: function ()
                            {

//                                    $('#item_table').find('tr:gt(0)').remove();
                                $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
//                                    $('#item_table').append(add_input_field(0));
//                                    $('.selectpicker').selectpicker('refresh');
//                                    $('#submit_button').attr('disabled', false);
//                                    $('#grandTotal').val("");
//                                    $('#add_button').attr('disabled', false);
                                window.location.reload(true);
                                alert("Submit MR successfully!");

                            }
                        });
                    } else
                    {
                        $('#error').html('<div class="alert alert-danger"><ul>' + error + '</ul></div>');
                    }

                });
            });
        </script>
    </body>
</html>