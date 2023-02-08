<?php
session_start();
include 'connection.php';
$result2 = $con->query("SELECT * FROM user where user_name='" . $_SESSION["username"] . "'")->fetch_array();
?>

<?php

//index.php
//include autoloader
include 'connection.php';
require_once '../dompdf/dompdf/autoload.inc.php';

// reference the Dompdf namespace

use Dompdf\Dompdf;

//initialize dompdf class

$document = new Dompdf();

$html = '';

//$document->loadHtml($html);
//$page = file_get_contents("$output");
//$document->loadHtml($page);
//$connect = mysqli_connect("localhost", "root", "", "testing1");
$mrid = $_POST['mr_id'];
$mrStatus = $_POST['mrStatus'];
$userid = $_POST['user_id'];
$user_name = $_POST['user_name'];
$department = $_POST['department'];
$user_email = $_POST['user_email'];
$branch = $_POST['branch'];
$user_contact = $_POST['user_contact'];
$address = $_POST['address'];
$date_request = $_POST['date_request'];
$mr_purpose = $_POST['mr_purpose'];
$deliver_address = $_POST['deliver_address'];
$mr_remark = $_POST['mr_remark'];
$new_date_deliver_by = $_POST['new_date_deliver_by'];
$mrStatus1 = $_POST['mrStatus'];


$query = "select * from mr_details WHERE mr_id = '" . $mrid . "'";
$query1 = "select * from material_requisition WHERE mr_id = '" . $mrid . "'";
$result = mysqli_query($con, $query);
$result1 = mysqli_query($con, $query1);

$output = "
 <style>
 h3 {
    text-align: center;
}

 p {
    text-align: right;
}

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid;
    text-align: left;
    padding: 8px;
  

</style>
<h3 class='mt-4'>Material Requisition Form</h3>
<table>
 <thead>
 <tr>
  <th col-md-3>MR ID</th>
  <th>$mrid</th>
  <th>Date Request</th>
  <th>$date_request</th>
 </tr>
 <tr>
  <th>User ID</th>
  <th>$userid</th>
  <th>Department</th>
  <th>$department</th>
 </tr>
  <tr>
  <th>Delivery Date</th>
  <th>$new_date_deliver_by</th>
  <th>Status</th>
  <th>$mrStatus1</th>
 </tr>
 <tr>
 <th>Delivery to</th>
  <th colspan=3>$deliver_address</th>
 </tr>
 <tr>
  <th col-md-2>Purpose</th>
  <th colspan=3>$mr_purpose</th>
 </tr>
 <tr>
  <th>Remark</th>
  <th colspan=3>$mr_remark</th>
 </tr>
 
 </thead>
 </table><br><br><br>
";

$output .= "
 <style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid;
    text-align: left;
    padding: 8px;
}
</style>
 <table>
 <tr>
  <th>Item ID</th>
  <th>Quantity</th>
  <th>Total</th>
 </tr>
";

while ($row = mysqli_fetch_array($result)) {
    $output .= '
  <tbody>
  <tr>
   <td>' . $row["item_id"] . '</td>
   <td>' . $row["qty_request"] . '</td>
   <td>' . $row["line_total"] . '</td>
  </tr>
  </tbody>
 ';
}

while ($row = mysqli_fetch_array($result1)) {
    $output .= '
    <tfoot>
    <tr>
    <th colspan=2 style="text-align: right">Total</th>
        <td>' . $row["mr_total_amount"] . '</td>
    </tr>
    </tfoot>';
}

$output .= '</table>';

$output .= '<br><br><p>Authorized By : <u>'.$result2["name"].'<u></p>';
$output .= '<p>Position : <u>'.$result2["job_position"].'<u></p>';

//echo $output;

$document->loadHtml($output);

//set page size and orientation

$document->setPaper('A4', 'landscape');

//Render the HTML as PDF

$document->render();

$output = $document->output();

// Save PDF Document
file_put_contents("$mrid.pdf", $output);

//Get output of generated pdf in Browser
//$document->stream("Webslesson", array("Attachment"=>0));
//1  = Download
//0 = Preview
?>

<?php

include 'connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

if (isset($_POST['update_button'])) {
    $mrid = $_POST['mr_id'];
    $mrStatus = $_POST['mrStatus'];
    $userid = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $date_request = $_POST['date_request'];
    $reason = $_POST['reason'];

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'liewsl-wm19@student.tarc.edu.my'; //gmail
    $mail->Password = 'lcnuddfiyglwzosy'; //gmail password
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('liewsl-wm19@student.tarc.edu.my');

    $mail->addAddress($_POST["user_email"]);
    $mail->isHTML(true);
    $mail->Subject = "MR " . $_POST['mrStatus'] . "";

    $message = "Hi, $user_name <br><br>";
    $message .= "User ID: $userid<br>";
    $message .= "MR ID: $mrid<br>";
    $message .= "Date Request: $date_request<br><br>";
    $message .= "This MR $mrid has been " . $_POST['mrStatus'] . "!<br>";
    $message .= "Reason Rejected: " . $_POST['reason'] . "<br><br><br>";

    $mail->addAttachment("$mrid.pdf");

    $message .= "Warm Regards,<br>";
    $message .= "".$result2["job_position"]."<br>";
    $message .= "".$result2["name"]."<br>";
    $mail->Body = $message;

    $mail->send();

    $sql = "UPDATE material_requisition SET mr_status='" . $_POST['mrStatus'] . "' , mr_reason='" . $_POST['reason'] . "' WHERE  mr_id='" . $_POST['mr_id'] . "'";
    mysqli_query($con, $sql);

    if (mysqli_query($con, $sql)) {
        echo '<script>alert("Successfully update MR status!")</script>';
    }
    echo
    "<script>document.location.href = 'approve_mr.php';</script> ";
}
?>
