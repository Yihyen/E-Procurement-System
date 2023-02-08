<?php
function dbcon(){
    $con = mysqli_connect("localhost","root","","procurementsystem");
    return $con;

}
?>