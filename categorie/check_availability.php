<?php 
require_once("../include/config.php");
// code user email availablity
if(!empty($_POST["category"])) {
	$category= $_POST["category"];
		$sql ="SELECT cat_nom FROM categorie WHERE cat_nom=:category";
$query= $dbh -> prepare($sql);
$query-> bindParam(':category', $category, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Catégorie Déja Existe .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}



?>
