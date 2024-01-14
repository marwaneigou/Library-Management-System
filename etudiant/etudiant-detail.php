<?php include("../include/title.php");
include('../include/config.php');  ?>
<?php
session_start();
error_reporting(0);
if(strlen($_SESSION['alogin'])==0){   
header('location:../index.php');
}
else{ 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
 <link rel="shortcut icon" type="image/x-icon" href="../assets/img/logo1.png" />
	<script src="https://kit.fontawesome.com/77f8f4dfd1.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../assets/css/style1.css">
	<link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/datatable.bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
       <style>
html{
    scrollbar-width: thin;
    
}
html::-webkit-scrollbar{
    width:10px;
}
html::-webkit-scrollbar-thumb{
    background-color: #2e2e46;
}
html::-webkit-scrollbar-track{
    background-color: #f9f9f9;
}
</style>
	<title>AdminSite</title>
</head>
<body>
<?php include("../include/header.php")  ?>
    <?php title("Historique d'etudiant","#") ?>

<div class="table-data">
<style>
                    #content main .table-data .order table tr td:first-child {
                        display: table-cell;}
                </style>
                  <?php $sid=$_GET['stdid']; ?>
				<div class="order">
					<div class="head">
						<h3>Historique d'etudiant</h3>
                    					</div>
					<!-- ***************** -->
                    <table id="example" class="table table-striped">
                    <thead>

<tr>

    <th>#</th>

    <th>CIN</th>

    <th>Nom</th>

    <th>Prenom</th>

    <th>Livre Emprunter</th>

    <th>ID Exemplaire</th>

    <th>Date D'Emprunt</th>

    <th>Date De Retour</th>



</tr>

</thead>

<tbody>

<?php 



$sql = "select * from reservation inner join exemplaire on exemplaire.id_ex=reservation.id_exp inner join etudiant on reservation.CNE=etudiant.CNE inner join livre on livre.ISBN=exemplaire.ISBN  where etudiant.id_etu='$sid';";

$query = $dbh -> prepare($sql);

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;

if($query->rowCount() > 0)

{

foreach($results as $result)

{               ?>                                      

<tr class="odd gradeX">

    <td class="center"><?php echo htmlentities($cnt);?></td>
    <td class="center"><?php echo htmlentities($result->CNE);?></td>
    <td class="center"><?php echo htmlentities($result->nom);?></td>
    <td class="center"><?php echo htmlentities($result->prenom);?></td>
    <td class="center"><?php echo htmlentities($result->nom_livre);?></td>
    <td class="center"><?php echo htmlentities($result->id_exp);?></td>
    <td class="center"><?php echo htmlentities($result->date_res);?></td>
    <td class="center"><?php if($result->date_ret==''): echo '<span class="status pending">Non Retourné</span>';
    else: echo htmlentities($result->date_ret); endif;?></td>
</tr>

<?php $cnt=$cnt+1;}} ?>                                      

</tbody>

</table>

</div>

<?php include("../include/pied.php") ?>

<script src="jquery-1.10.2.js"></script>
</body>

<?php
if(isset($_GET['bookid'])){
?>
<script>
const button = document.getElementById("but");
button.click();
</script>

<?php
}
?>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
$('#example').DataTable();
});
</script>
</html>
<?php } ?>
