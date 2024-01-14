<?php include("../include/title.php");
include('../include/config.php');  ?>
<?php
session_start();
error_reporting(0);
if(strlen($_SESSION['alogin'])==0){   
header('location:../index.php');
}
else{ 
    if(isset($_GET['del'])){
    $id=$_GET['del'];
    $sql = "delete from auteur  WHERE id_auteur=:id";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id',$id, PDO::PARAM_STR);
    if($query -> execute()){
      $_SESSION['del']="Auteur supprimée avec succès ";
      header('location:auteur.php');
    }
    else{
      $_SESSION['err']="Un erreur s'est produit";
      header('location:auteur.php');
    }
    }

    if(isset($_POST['edit'])){
    $athrid=intval($_GET['athrid']);
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $sql="update auteur set nom_auteur=:nom_auteur,prenom_auteur=:prenom_auteur where id_auteur=:athrid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':nom_auteur',$nom,PDO::PARAM_STR);
    $query->bindParam(':prenom_auteur',$prenom,PDO::PARAM_STR);
    $query->bindParam(':athrid',$athrid,PDO::PARAM_STR);
    if($query->execute()){
      $_SESSION['edit']="Auteur Modifier avec succes ";
      header('location:auteur.php');
    }
    else{
      $_SESSION['erro']="Un erreur s'est produit";
      header('location:auteur.php');
     }

    }



    if(isset($_POST['add'])){
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $sql="INSERT INTO  auteur(nom_auteur,prenom_auteur) VALUES(:nom,:prenom)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':nom',$nom,PDO::PARAM_STR);
    $query->bindParam(':prenom',$prenom,PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId){
        $_SESSION['succes']="Auteur listé avec succès";
        header('location:auteur.php');
    }
    else {
        $_SESSION['danger']="Quelque chose s'est mal passé. Veuillez réessayer";
        header('location:auteur.php');
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/77f8f4dfd1.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="../assets/css/style1.css">
	<link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/datatable.bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/logo1.png" />
<title>AdminSite</title>
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
</head>
<body>
    

<?php include("../include/header.php")  ?>
    <?php title("Auteur","#") ?>

    

    <!-- ******message add succes******** -->
    <?php if($_SESSION['succes']!="")
    {?>
    <div class="col-md-6">
    <div class="alert alert-success" >
    <strong>Success :</strong> 
    <?php echo htmlentities($_SESSION['succes']);?>
    <?php if(!isset($_POST['add'])){ ?>
    <?php echo htmlentities($_SESSION['succes']="");?>
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
    <?php if(!isset($_POST['add'])){ ?>
    <?php echo htmlentities($_SESSION['danger']="");?>
    <?php } ?>
    </div>
    </div>
    <?php } ?>
    <!-- ****************************************** -->


    <!-- ******message add succes******** -->
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



<!-- ******message add succes******** -->
<?php if($_SESSION['edit']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['edit']);?>
 <?php if(!isset($_GET['athrid'])){ ?>
<?php echo htmlentities($_SESSION['edit']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->


<!-- ******message erreur******** -->
<?php if($_SESSION['erro']!="")
{?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Erreur :</strong> 
 <?php echo htmlentities($_SESSION['erro']);?>
 <?php if(!isset($_GET['athrid'])){ ?>
<?php echo htmlentities($_SESSION['erro']="");?>
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



<?php if($_SESSION['err']!="")
{?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Erreur :</strong> 
 <?php echo htmlentities($_SESSION['err']);?>
 <?php if(!isset($_GET['del'])){ ?>
<?php echo htmlentities($_SESSION['err']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->






    <!-- *********Modal add auteur************ -->
    <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ajouter Un Auteur</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
   <!-- body -->
   <form role="form" method="post" enctype="multipart/form-data">
     <div class="form-group">
       <label style="padding-right: 20px;padding-top: 8px;">Nom</label>
       <input class="form-control" type="text" name="nom" autocomplete="off"  required />
      </div>
  <br>
  <div class="form-group">
    <label style="padding-top: 8px;">Prénom</label>
    <input class="form-control" type="text" name="prenom" autocomplete="off"  required />
   </div>
   </div>
<div class="modal-footer">
        <button type="submit" name="add" class="btn btn-primary" id="submit">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
</form>
   <!-- /body -->
      </div>
    </div>
  </div>
</div>
<!-- ***************************** -->


<!-- *********Modal modifier auteur************ -->
<div class="modal fade modal-lg" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier Un Auteur</h5>
        <a href="auteur.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form role="form" method="post">
<div class="form-group">
<label style="padding-right: 20px;">nom d'auteur</label>
<?php 
$athrid=intval($_GET['athrid']);
$sql = "SELECT * from  auteur where id_auteur=:athrid";
$query = $dbh -> prepare($sql);
$query->bindParam(':athrid',$athrid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>   
<input class="form-control" type="text" name="nom" value="<?php echo htmlentities($result->nom_auteur);?>" required />
</div>
<br>
<div class="form-group">
<label>prenom d'auteur</label>
<input class="form-control" type="text" name="prenom" value="<?php echo htmlentities($result->prenom_auteur);?>" required />
</div>

<?php }} ?>
</div>
<div class="modal-footer">
        <button type="submit" name="edit" class="btn btn-primary" id="submit">Save</button>
        <a href="auteur.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></a>
      </div>
  </form>
 <!-- /body -->
      </div>
    </div>
  </div>
</div>
<!-- ***************************** -->


<!-- **********button to open modal of edit*********** -->
<button id="but" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1" hidden></button>
<!-- ************************************************** -->
<!-- ***************************** -->
<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Liste Des Auteurs</h3>
                        <button id="butt" class="btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-add "></i> Nouveau Auteur</button>
					</div>
					<!-- ***************** -->
                    <table id="example" class="table table-striped">
                    <thead>
                       <tr>
                        <th>nom d'auteur</th>
                        <th>prenom d'auteur</th>
                        <th>Action</th>
                       </tr>
                    </thead>
           <tbody>
            <?php $sql = "SELECT * from  auteur";
            $query = $dbh -> prepare($sql);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0){
                foreach($results as $result){               
                    ?>                                      
            <tr class="odd gradeX">
                <style>
                    #content main .table-data .order table tr td:first-child {
                        display: table-cell;}
                </style>
               <td class="center"><?php echo htmlentities($result->nom_auteur);?></td>
               <td class="center"><?php echo htmlentities($result->prenom_auteur);?></td>
               <td class="center"><a href="auteur.php?athrid=<?php echo htmlentities($result->id_auteur);?>"><button class="btn-edit"><i class="fa fa-edit "></i> Modifier</button> 
               <a href="auteur.php?del=<?php echo htmlentities($result->id_auteur);?>" onclick="return confirm('Etes-vous sûr que vous voulez supprimer?');" >  <button class="btn-del"><i class="fa fa-trash"></i> Supprimer</button>
               </td>
</tr>
<?php }} ?>                                      
</tbody>
</table>

<!-- ********************** -->
</div>



    <?php include("../include/pied.php") ?>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
$('#example').DataTable();
   });
    </script>

<?php
if(isset($_GET['athrid'])){
?>
<script>
const button = document.getElementById("but");
button.click();
</script>

<?php
}
?>

</body>


</html>
<?php } ?>