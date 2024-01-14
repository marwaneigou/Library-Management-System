<?php 
include('../include/config.php');
// code user email availablity
if(!empty($_POST["email"])) {
	$email= $_POST["email"];
	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

		echo "erreur : Vous n'avez pas saisi d'email valide.";
	}
	else {
		$sql ="SELECT email FROM etudiant WHERE email=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> L'email existe déjà .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> E-mail disponible pour l'inscription.</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}


?>
