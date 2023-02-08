<?php
    session_start();
    require '../connection/dbCon.php';
    include '../administration/verifyUserType.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Outsourcing Approve</title>
    
</head>
<body>
    <div class="container mt-4">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="fo">Outsourcing Approve</h4>
                    </div>
                    <div class="card-body">
                        <p>We are from xxx company, our company is engaged in Electrical Appliance business.</p>
                        <p>Honesty would like to invite you to be our outsources.</p>
                        <p>Do you approve the request to become our outsources?</p>
                        <?php
                            if(isset($_GET['id'])){
                               $outsourcer_id = mysqli_real_escape_string($con, $_GET['id']);
                               $query = "SELECT * FROM outsourcerList WHERE id='$outsourcer_id' ";
                               $query_run = mysqli_query($con, $query);

                               if(mysqli_num_rows($query_run) > 0){
                                    $outsourcer = mysqli_fetch_array($query_run);
                                    ?> 
                                        <form action="codeDatabase.php?id=<?php echo $outsourcer['id']; ?>" method="POST" onsubmit="return checkReasonEmpty(this)">                                                <input type="hidden" name="appid" value="<?php echo $outsourcer['id']; ?>">
                                            <div class="button1">
                                                <input type="submit" class="btn btn-sm btn-success" onclick="setReject('false')" name="approve" value="Accept">
                                                <input type="button" class="btn btn-sm btn-danger" name="reject" value="Reject" onclick="enableRejectReason()">
                                            </div>

                                            <div class="mb-3">
                                                <label>Reject Reason (Reject only):</label>
                                                <input type="text" name="reason" class="form-control" id="reason" readonly>
                                                <input type="submit" name="rejectBtn" onclick="setReject('true')" class="form-control" id="rejectBtn" disabled>
                                            </div>
                                        </form>               
                        <?php
                                }else{
                                    echo "<h4>No Such Outsources ID Found </h4>";
                                }
                            }
                        ?>                
                    </div>
                </div><br>
            </div>
        </div>
    </div>
    
    <script>
        let reject = "";

        function enableRejectReason(){
            document.getElementById('reason').removeAttribute('readonly');
            document.getElementById('rejectBtn').removeAttribute('style');
            document.getElementById('rejectBtn').removeAttribute('disabled');
            document.getElementById('rejectBtn').style.backgroundColor = '#3333ff';
            document.getElementById('rejectBtn').style.color = 'white';
        }

        function checkReasonEmpty(form){
            if(reject === 'true'){
                let rejectReason = document.getElementById('reason').value;
                if(rejectReason == ''){
                    alert('Please Enter A Reject Reason');
                    return false;
                }
            }
            return true;
        }

        function setReject(control){
            reject = control;
        }
    </script>
    
    <style>     
        .container{
            width: 1000px;
            font-family: 'Poppins', sans-serif;
        }
        
        .card-header{
            color:#17a2b8;
        }
        
        .fo{
            text-align: center;
            font-size:2.0rem;
        }
        
        p, .button1, h4{
            text-align: center;
        }

        #rejectBtn{
            background-color: lightgray;
            margin-top: 10px;
            width: fit-content;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</body>
</html>


