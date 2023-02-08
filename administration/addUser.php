<!DOCTYPE html>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

session_start();
require '../connection/dbCon.php';
include '../administration/verifyUserType.php';

//generate user ID
$query = "SELECT * FROM user ORDER BY user_id DESC LIMIT 1";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
$lastid = $row['user_id'] ?? '';
if ($lastid == null or $lastid == '') {
    $uid = "SF0001";
} else {
    $get_numbers = str_replace("SF", "", $lastid);
    $id_increase = $get_numbers + 1;
    $get_string = str_pad($id_increase, 4, 0, STR_PAD_LEFT);
    $uid = "SF" . $get_string;
}

//insert user
if (isset($_POST["submit"])) {
    //generate username
    $IDcharacters = 'abcdefghijklmnopqrstuvwxyz';
    $IDcharactersLength = strlen($IDcharacters);
    $randomString = '';
    for ($i = 0; $i < 3; $i++) {
        $randomString .= $IDcharacters[rand(0, $IDcharactersLength - 1)];
    }

    $code = rand(1, 9999);
    $username = "UR_" . $randomString . $code;

    //generate password
    $upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $upperCaseLength = strlen($upperCase);
    $randomUpperCase = '';
    for ($i = 0; $i < 3; $i++) {
        $randomUpperCase .= $upperCase[rand(0, $upperCaseLength - 1)];
    }

    $lowerCase = 'abcdefghijklmnopqrstuvwxyz';
    $lowerCaseLength = strlen($lowerCase);
    $randomLowerCase = '';
    for ($i = 0; $i < 3; $i++) {
        $randomLowerCase .= $lowerCase[rand(0, $lowerCaseLength - 1)];
    }

    $code2 = rand(1, 9999);
    $pw = $randomUpperCase . $code2 . $randomLowerCase;

    $userid = $uid;
    $name = $_POST["name"];
    $useremail = $_POST["userEmail"];
    $userContact = $_POST["userContact"];
    $userGender = $_POST["userGender"];
    $userAddress = $_POST["userAddress"];
    $branch = $_POST["branch"];
    $department = $_POST["department"];
    $jobposition = $_POST["jobposition"];
    $userrole = $_POST["userrole"];
    $userstatus = "Available";

    $query = $con->prepare('INSERT INTO user (user_id, user_name, name, user_email, user_contact, user_gender, user_address, branch, department, job_position, user_role, user_password, user_status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)');
    $query->bind_param('sssssssssssss', $userid, $username, $name, $useremail, $userContact, $userGender, $userAddress, $branch, $department, $jobposition, $userrole, $pw, $userstatus);

    $query->execute();

    if ($query) {

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'fypprocurementsystem@gmail.com';
        $mail->Password = 'pdtvbvrqrkjlqvlm';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('fypprocurementsystem@gmail.com');
        $mail->addAddress($useremail);
        $mail->isHTML(true);
        
        $link = "http://localhost/ProcurementSystem/administration/verifyUserForChgPw.php";

        $mail->Subject = ("Username and Password");
        $mail->Body = "Dear user, your username and password are as follows: <br> Username: $username <br> Password : $pw <br> Please change your password for security purposes. Thank you. <br> Link to change password: <a href=$link>Change Password Here</a>";
        
        if ($mail->send()) {
            echo "<script>alert('Successfully added and the username and password will be send to the email!')</script>";
            echo("<script>location.href = '../administration/addUser.php';</script>");
        } else {
            echo "<script>alert('User failed to be added. Please try again.')</script>";
        }

    }
}

if (isset($_POST['cancel'])) {
    header("Location: ../administration/maintainUser.php");
}
?>

<html>
    <head>
        <title>Add User</title>

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
        <br>
        <br>
        <div class="addUser">
            <h2 style="font-size: 60px">User Details Form</h2> <br>

            <form action = "" method="post" id="addUser" class="center">

                <!--userid-->
                <label for="userID">User ID: </label>
                <input type="text" name="userID" id = "userID" value="<?php echo $uid; ?>" disabled> <br>

                <!--name-->
                <label for="name">Name: </label>
                <input type="text" name="name" id = "name" required value=""> <br>
                
                <!--user email-->
                <label for="userEmail">User Email: </label>
                <input type="text" name="userEmail" id = "userEmail" required value="" onkeydown="emailValidation()">
                <span id="text"></span> <br>

                <!--user contact-->
                <label for="userContact">User Contact: </label>
                <input type="text" name="userContact" id = "userContact" required value=""> <br>

                <!--user gender-->
                <label for="userGender">User Gender: </label>
                <select id="userGender" name="userGender" class="form-control" required value="">
                    <option value="M" selected="selected" >Male</option>
                    <option value="F">Female</option>
                </select> <br>

                <!--user address-->
                <label for="userAddress">User Address: </label>
                <textarea id="userAddress" name="userAddress" rows="4" cols="70" required></textarea> <br>

                <!--branch-->
                <label for="branch">Branch: </label>
                <input type="text" name="branch" id = "branch" required value=""> <br>

                <!--department-->
                <label for="department">Department: </label>
                <select id="department" name="department" class="form-control" required value="">
                    <option value="Marketing Department" selected="selected" >Marketing Department</option>
                    <option value="Operations Department">Operations Department</option>
                    <option value="Finance Department">Finance Department</option>
                    <option value="Sales Department">Sales Department</option>
                    <option value="Sales Department">Purchase Department</option>
                </select> <br>

                <!--job position-->
                <label for="jobposition">Job Position: </label>
                <input type="text" name="jobposition" id = "jobposition" required value=""> <br>

                <!--user role-->
                <label for="userrole">User Role: </label>
                <select id="userrole" name="userrole" class="form-control" required value="">
                    <option value="Administrator" selected="selected" >Administrator</option>
                    <option value="Branches">Branches</option>
                    <option value="Purchasing Manager">Purchasing Manager</option>
                    <option value="Purchasing Staff">Purchasing Staff</option>
                    <option value="Supplier">Supplier</option>
                    <option value="Outsourcer">Outsourcer</option>
                </select> <br>

                <input type='submit' name='submit' value="Submit" class="submit" onclick="return confirm('Are you sure you want to add this user?');"> <br>

                <a href="../administration/maintainUser.php">
                    <button type="button" class="btn btn-danger btn-block btnCancel">Cancel</button>
                </a>
            </form>
        </div>

        <script type ="text/javascript">
            function emailValidation() {
                var form = document.getElementById("addUser");
                var email = document.getElementById("userEmail").value;
                var text = document.getElementById("text");
//                var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                var pattern = /^[^@]{1,64}@[^@]{1,255}$/;
                
                if (email.match(pattern)) {
                    form.classList.add("valid");
                    form.classList.remove("invalid");
                    text.innerHTML = "Valid Email Address.";
                    text.style.color = "#00ff00";
                } else {
                    form.classList.remove("valid");
                    form.classList.add("invalid");
                    text.innerHTML = "Invalid Email Address.";
                    text.style.color = "#ff0000";
                }
                
                if(email == ""){
                    form.classList.remove("valid");
                    form.classList.remove("invalid");
                    text.innerHTML = "";
                    text.style.color = "#00ff00";
                }
            }
        </script>

    </body>
</html>
