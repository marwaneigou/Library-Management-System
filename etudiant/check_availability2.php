<?php 
include('../include/config.php');
// code user email availablity
if(!empty($_POST["CNE"])) {
	$CNE= $_POST["CNE"];

		$sql ="SELECT CNE FROM etudiant WHERE CNE=:CNE";
$query= $dbh -> prepare($sql);
$query-> bindParam(':CNE', $CNE, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Le CNE existe déjà .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> CNE disponible pour l'enregistrement.</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}



?>
