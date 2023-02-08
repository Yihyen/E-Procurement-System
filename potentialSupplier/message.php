<?php
    if(isset($_SESSION['message'])) :
?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <span class="fas fa-check-circle" style="color:green"></span> 
        <strong><?= $_SESSION['message']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <style>
         .alert-warning{
            color:#006600;
            background-color:#99ff99;
            border-color:green;
            font-family: 'Poppins', sans-serif;
        }
    </style>

<?php 
    unset($_SESSION['message']);
    endif;
?>

<?php
    if(isset($_SESSION['message1'])) :
?>

    <div class="alert alert-warning1 alert-dismissible fade show" role="alert" color ="#ffb3b3">
        <span class="fas fa-exclamation-circle" style="color:red"></span> 
        <strong><?= $_SESSION['message1']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
    <style>
        .alert-warning1{
            color:#ff471a;
            background-color:#ffc2b3;
            border-color:red;
            font-family: 'Poppins', sans-serif;
        }
        
    </style>

<?php 
    unset($_SESSION['message1']);
    endif;
?>