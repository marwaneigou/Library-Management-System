<?php 

require_once("../include/config.php");

//code check email

if(!empty($_POST["ISBN"])) {
$ISBN=$_POST["ISBN"];
$sql ="SELECT ISBN FROM livre WHERE ISBN=:ISBN";
$query= $dbh -> prepare($sql);
$query-> bindParam(':ISBN', $ISBN, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0){

echo "<span style='color:red'> ISBN already exists with another book. .</span>"; 

echo "<script>$('#add').prop('disabled',true);</script>";

} else {
     echo "<script>$('#add').prop('disabled',false);</script>";
    }

}