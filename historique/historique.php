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
<!-- **********button to open modal of edit*********** -->
<button id="but" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1" hidden></button>
<!-- ************************************************** -->

    <?php include("../include/header.php")  ?>
    <?php title("Historique Des Livre Retourner","#") ?>





    <!-- *********Modal modifier livre************ -->
<div class="modal fade modal-lg" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Détails</h5>
        <a href="historique.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form class="row g-3" role="form" method="post" enctype="multipart/form-data">
<?php 
$id_res=$_GET['idres'];
$sql = "SELECT * from reservation join exemplaire on reservation.id_exp = exemplaire.id_ex join etudiant on reservation.CNE = etudiant.CNE join livre on livre.ISBN=exemplaire.ISBN where statue_res=1 and date_ret is not null and id_res=:id_res";
$query = $dbh -> prepare($sql);
$query->bindParam(':id_res',$id_res,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                   


<input type="hidden" name="bookid" value="<?php echo htmlentities($result->bid);?>">
<h4>Détails de l'étudiant</h4>
<hr />
<div class="col-md-6"> 
<label style="font-weight: bold;">CNE :</label>
<?php echo htmlentities($result->CNE);?>
</div>

<div class="col-md-6"> 
<label style="font-weight: bold;">Nom D'Etudiant :</label>
<?php echo htmlentities($result->nom);?>
</div>

<div class="col-md-6"> 
<label style="font-weight: bold;">Email D'Etudiant :</label>
<?php echo htmlentities($result->email);?>
</div>

<div class="col-md-6"> 
<label style="font-weight: bold;">Prenom D'Etudiant :</label>
<?php echo htmlentities($result->prenom);?>
</div>


<br>
<h4>Détails du livre</h4>
<hr />

<div class="col-md-6"> 
<label style="font-weight: bold;">Image Du Livre :</label>
<img style="border-radius : 15px" src="../bookimg/<?php echo htmlentities($result->image_livre); ?>" width="120">
</div>


<div class="col-md-6"> 
<label style="font-weight: bold;">Nom Du Livre :</label>
<?php echo htmlentities($result->nom_livre);?>
</div>
<div class="col-md-6"> 
<label style="font-weight: bold;">ID D'Exemplaire :</label>
<?php echo htmlentities($result->id_exp);?>
</div>

<div class="col-md-6"> 
<label style="font-weight: bold;">Date D'Emprunt De Livre :</label>
<?php echo htmlentities($result->date_res);?>
</div>

<div class="col-md-6"> 
<label style="font-weight: bold;">Date De Retour Du Livre:</label>
<?php if($result->date_ret=="")
                                            {
                                                echo htmlentities("Pas Encore Retourné");
                                            } else {


                                            echo htmlentities($result->date_ret);
}
                                            ?>

</div>



<?php }} ?>

<div class="modal-footer">
        <a href="historique.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></a>
      </div>
                                    </form>
   <!-- /body -->
      </div>
    </div>
  </div>
</div>
<!-- ***************************** -->








<div class="table-data">
<style>
                    #content main .table-data .order table tr td:first-child {
                        display: table-cell;}
                </style>
				<div class="order">
					<div class="head">
						<h3>Liste Des Historiques Des Livres</h3>
					</div>
					<!-- ***************** -->
                    <table id="example" class="table table-striped">
                    <thead>
                                        <tr>
                                            <th>Nom Du Livre</th>
                                            <th>ID D'Exemplaire</th>
                                            <th>Nom D'Étudiant</th>
                                            <th>Date D'Emprunt</th>
                                            <th>Date De Retour</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT * from reservation join exemplaire on reservation.id_exp = exemplaire.id_ex join etudiant on reservation.CNE = etudiant.CNE join livre on livre.ISBN=exemplaire.ISBN where statue_res=1 and date_ret is not null";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center" width="200">
                                                <img src="../bookimg/<?php echo htmlentities($result->image_livre);?>" width="100">
                                                <br /><b><?php echo htmlentities($result->nom_livre);?></b></td>
                                            <td class="center"><?php echo htmlentities($result->id_exp);?></td>
                                            <td class="center"><?php echo htmlentities($result->nom)." ".htmlentities($result->prenom);?></td>
                                            <td class="center"><?php echo htmlentities($result->date_res);?></td>
                                            <td class="center"><?php if($result->date_ret=="")
                                            {
                                                echo htmlentities("Not Return Yet");
                                            } else {


                                            echo htmlentities($result->date_ret);
}
                                            ?></td>
                                            <td class="center">

                                            <a href="historique.php?idres=<?php echo htmlentities($result->id_res);?>"><button class="btn btn-primary"><i class="fa fa-info-circle "></i> Details</button> 
                                         
                                            </td>
                                        </tr>
 <?php }} ?>                                      
                                    </tbody>
                                </table>
                                      <!-- ********************** -->
				</div>


                <?php include("../include/pied.php") ?>

                <?php
if(isset($_GET['idres'])){
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
                </body>

</html>
<?php } ?>

