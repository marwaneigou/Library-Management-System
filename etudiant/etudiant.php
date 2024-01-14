<?php include("../include/title.php");
include('../include/config.php');  ?>
<?php
session_start();
error_reporting(0);
if(strlen($_SESSION['alogin'])==0){   
header('location:../index.php');
}
else{ 

// code for block student    
if(isset($_GET['inid']))
{
$id=$_GET['inid'];
$status=0;
$sql = "update etudiant set status_cmpt=:status  WHERE id_etu=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:etudiant.php');
}

if(isset($_POST['signup']))
{
  
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$CNE=$_POST['CNE'];
$email=$_POST['email']; 
$filiere=$_POST['filiere']; 
$pass=md5($_POST['CNE']); 
$status_cmpt = 1;
$sql="INSERT INTO etudiant(CNE,nom,prenom,email,pass,status_cmpt,id_fil) VALUES(:CNE,:nom,:prenom,:email,:pass,:status_cmpt,:filiere)";
$query = $dbh->prepare($sql);
$query->bindParam(':nom',$nom,PDO::PARAM_STR);
$query->bindParam(':prenom',$prenom,PDO::PARAM_STR);
$query->bindParam(':CNE',$CNE,PDO::PARAM_STR);
$query->bindParam(':filiere',$filiere,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':pass',$pass,PDO::PARAM_STR);
$query->bindParam(':status_cmpt',$status_cmpt,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
  $_SESSION['succes']="etudiant ajouter avec succes ";
  header('location:etudiant.php');
}
else 
{
  $_SESSION['danger']="un erreur s'est produit";}
  header('location:etudiant.php');
}

//code for active students
if(isset($_GET['id']))
{
$id=$_GET['id'];
$status=1;
$sql = "update etudiant set status_cmpt=:status  WHERE id_etu=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query -> execute();
header('location:etudiant.php');
}


if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from etudiant WHERE id_etu=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$_SESSION['del']="etudiant supprimé";
header('location:etudiant.php'); 
}


if(isset($_POST["update"])) {
  if (isset($_POST["pass"]) && !empty($_POST["pass"])) { 
     $pass = md5($_POST["pass"]);
     $id_etu = $_GET["id_etu"];
     $sql1 ="update etudiant set pass=:pass where id_etu=:id_etu";
     $query = $dbh->prepare($sql1);
     $query->bindParam(":pass", $pass, PDO::PARAM_STR);
     $query->bindParam(":id_etu", $id_etu, PDO::PARAM_STR);
     $query->execute();
  }
         $nom = $_POST["nom"];
         $prenom = $_POST["prenom"];
         $CNE = $_POST["CNE"];
         $email = $_POST["email"];
         $filiere = $_POST["filiere"];
         $id_etu = $_GET["id_etu"]; 
         $sql ="update etudiant set nom=:nom,prenom=:prenom,CNE=:CNE,email=:email,id_fil=:filiere where id_etu=:id_etu";
         $query = $dbh->prepare($sql); 
         $query->bindParam(":nom", $nom, PDO::PARAM_STR);
         $query->bindParam(":prenom", $prenom, PDO::PARAM_STR); 
         $query->bindParam(":CNE", $CNE, PDO::PARAM_STR); 
         $query->bindParam(":email", $email, PDO::PARAM_STR);
         $query->bindParam(":filiere", $filiere, PDO::PARAM_STR);
         $query->bindParam(":id_etu", $id_etu, PDO::PARAM_STR);
         $query->execute();
         $_SESSION['modif']="etudiant modifier avec success";
         echo "<script>window.location.href='etudiant.php'</script>";
     }



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


<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability1.php",
data:'email='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>  

<script>
function checkAvailability1() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability2.php",
data:'CNE='+$("#CNE").val(),
type: "POST",
success:function(data){
$("#CNE-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script> 
<!-- **********button to open modal of edit*********** -->
<button id="but" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1" hidden></button>
<!-- ************************************************** -->

    <?php include("../include/header.php")  ?>
    <?php title("Étudiant","#") ?>

    <!-- ******message add succes******** -->
    <?php if($_SESSION['succes']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['succes']);?>
 <?php if(!isset($_POST['signup'])){ ?>
<?php echo htmlentities($_SESSION['succes']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->



    <!-- ******message add succes******** -->
    <?php if($_SESSION['modif']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['modif']);?>
 <?php if(!isset($_GET['id_etu'])){ ?>
<?php echo htmlentities($_SESSION['modif']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->



<!-- ******message erreur******** -->
<?php if($_SESSION['danger']!="")
{?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Erreur :</strong> 
 <?php echo htmlentities($_SESSION['danger']);?>
 <?php if(!isset($_POST['signup'])){ ?>
<?php echo htmlentities($_SESSION['danger']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->


<!-- ******message del succes******** -->
<?php if($_SESSION['del']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['del']);?>
 <?php if(!isset($_GET['del'])){ ?>
<?php echo htmlentities($_SESSION['del']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->



<!-- *********Modal add etudiant************ -->
<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter Un Étudiant</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form class="row g-3" role="form" method="post" enctype="multipart/form-data">
   <script>
		function updateTextbox() {
			var textbox1Value = document.getElementById("CNE").value;
			document.getElementById("password").value = textbox1Value;
		}
	</script>

   <div class="col-md-6">  
<label>Nom</label>
<input class="form-control" type="text" name="nom" autocomplete="off" required />
 </div>

 <div class="col-md-6">  
<label>prenom</label>
<input class="form-control" type="text" name="prenom" autocomplete="off" required />
 </div>

 <div class="col-md-6">  
<label>CNE</label>
<input class="form-control" type="text" name="CNE" id="CNE" onkeyup="updateTextbox()" onBlur="checkAvailability1()"  maxlength="10" autocomplete="off"  required />
<span id="CNE-availability-status" style="font-size:12px;"></span> 
 </div>  

 <div class="col-md-6">  
<label>Email</label>
<input class="form-control" type="email" name="email" id="email" onBlur="checkAvailability()"  autocomplete="off" required  />
   <span id="user-availability-status" style="font-size:12px;"></span>
 </div>

 <div class="col-md-6">  
<label>Filière</label>
<select class="form-select" name="filiere" required="required" id="searchstudent">
<option value=""> Sélectionnez une Fillière</option>
<?php 
$sql = "SELECT * from  filiere order by nom_fil asc ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->id_fil);?>"><?php echo htmlentities($result->nom_fil);?></option>
 <?php }} ?> 
</select>
</div>

<div class="col-md-6">  
<label>Mot de Passe</label>
<input class="form-control" type="" name="password" id="password" autocomplete="off" required  disabled>
</div>

<div class="modal-footer">
        <button type="submit" name="signup" class="btn btn-primary" id="submit">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
</form>
   <!-- /body -->
      </div>
    </div>
  </div>
</div>
<!-- ***************************** -->




<!-- *********Modal modifier etudiant************ -->
<div class="modal fade modal-lg" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier Un Étudiant</h5>
        <a href="etudiant.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form class="row g-3" role="form" method="post" enctype="multipart/form-data">
   <?php

$id_etu = $_GET["id_etu"];
$sql ="SELECT * from etudiant join filiere on etudiant.id_fil = filiere.id_fil where id_etu=:id_etu";
$query = $dbh->prepare($sql);
$query->bindParam(":id_etu", $id_etu, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);


if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>  

<div class="col-md-6">
<label>Nom d'etudiant</label>
<input class="form-control" type="text" name="nom" value="<?php echo htmlentities($result->nom);?>"  />
</div>


<div class="col-md-6">
<label>Prenom d'etudiant</label>
<input class="form-control" type="text" name="prenom" value="<?php echo htmlentities($result->prenom);?>"  />
</div>


<div class="col-md-6">
<label>CNE</label>
<input class="form-control" type="text" name="CNE" value="<?php echo htmlentities($result->CNE);?>"  />
</div>


<div class="col-md-6">
<label>Email</label>
<input class="form-control" type="text" name="email" value="<?php echo htmlentities($result->email);?>"  />
</div>


<div class="col-md-6">
<label> Filiere</label>
<select class="form-control" name="filiere" >
<option value="<?php echo htmlentities($result->id_fil); ?>"> <?php echo htmlentities($filname = $result->nom_fil); ?></option>
<?php
$sql1 = "SELECT * from  filiere ";
$query1 = $dbh->prepare($sql1);
$query1->execute();
$resultss = $query1->fetchAll(PDO::FETCH_OBJ);

if ($query1->rowCount() > 0) {
    foreach ($resultss as $row) {
        if ($filname == $row->nom_fil) {
            continue;
        } else {
             ?>  
<option value="<?php echo htmlentities($row->id_fil); ?>"><?php echo htmlentities($row->nom_fil); ?></option>
 <?php
        }
    }
}
?> 
</select>
</div>

<div class="col-md-7">
<label>Modifier Mot de passe<span style="color:red; font-size:11px"> (optionele)</span></label>
<input class="form-control" type="text" name="pass" value=""/>
</div>



 <?php }
}
?>

<div class="modal-footer">
        <button type="submit" name="update" class="btn btn-primary" id="submit">Save</button>
        <a href="etudiant.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></a>
      </div>
                                    </form>
   <!-- /body -->
      </div>
    </div>
  </div>
</div>
<!-- ***************************** -->




<!-- ***************************** -->
<div class="table-data">
<style>
                    #content main .table-data .order table tr td:first-child {
                        display: table-cell;}
                </style>
				<div class="order">
					<div class="head">
						<h3>Liste Des Étudiants</h3>
                        <button id="butt" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-add "></i> Nouvel Étudiant</button>
					</div>
					<!-- ***************** -->
                    <table id="example" class="table table-striped">
                    <thead>
                    <tr>
                                            <th>Cne</th>
                                            <th>Nom</th>
                                            <th>Prenom</th>
                                            <th>Email</th>
                                            <th>Filiere</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT * from etudiant join filiere where etudiant.id_fil=filiere.id_fil";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo htmlentities($result->CNE);?></td>
                                            <td class="center"><?php echo htmlentities($result->nom);?></td>
                                            <td class="center"><?php echo htmlentities($result->prenom);?></td>
                                            <td class="center"><?php echo htmlentities($result->email);?></td>
                                            <td class="center"><?php echo htmlentities($result->nom_fil);?></td>
                                            <td class="center"><?php if($result->status_cmpt==1)
                                            {
                                                echo '<span class="status completed">Active</span>';
                                            } else {


                                            echo '<span class="status pending">Bloqué</span>';
}
                                            ?></td>
                                            <td class="center">
<?php if($result->status_cmpt==1)
 {?>
<a href="etudiant.php?inid=<?php echo htmlentities($result->id_etu);?>" onclick="return confirm('Voulez-vous vraiment bloquer cet étudiant ?');" >  <button class="btn btn-danger"><i class="fa-solid fa-circle-xmark"></i> Inactive</button>
<?php } else {?>

<a href="etudiant.php?id=<?php echo htmlentities($result->id_etu);?>" onclick="return confirm('Voulez-vous vraiment activer cet étudiant ?');"><button class="btn btn-primary"><i class="fa-solid fa-circle-check"></i> Active</button> 
                                            <?php } ?>
<a href="etudiant-detail.php?stdid=<?php echo htmlentities($result->id_etu);?>"><button class="btn btn-success"><i class="fa-solid fa-circle-info"></i> Details</button> 
<div style="padding:3px">

</div>
<a href="etudiant.php?id_etu=<?php echo htmlentities($result->id_etu);?>"><button class="btn btn-warning"><i class="fa fa-edit "></i> Modifier</button> 
<a href="etudiant.php?del=<?php echo htmlentities($result->id_etu);?>" onclick="return confirm('Etes-vous sûr que vous voulez supprimer?');"" >  <button class="btn btn-danger"><i class="fa fa-trash"></i> Supprimer</button>

                                          
                                            </td>
                                        </tr>
 <?php }} ?>                                      
                                    </tbody>
                                </table>

                                <!-- ********************** -->
				</div>





<?php include("../include/pied.php") ?>

<?php
if(isset($_GET['id_etu'])){
?>
<script>
const button = document.getElementById("but");
button.click();
</script>

<?php
}
?>
<script src="jquery-1.10.2.js"></script>

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
