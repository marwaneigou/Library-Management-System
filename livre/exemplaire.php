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
    $idexemplaire = $_GET['del'];
    $ISBN = $_GET['ISBN'];
    $sql = "delete from exemplaire WHERE id_ex=:idexemplaire; update livre set quant=quant-1 where ISBN=:ISBN";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':idexemplaire',$idexemplaire, PDO::PARAM_STR);
    $query -> bindParam(':ISBN',$ISBN, PDO::PARAM_STR);
    if($query -> execute()){
        $_SESSION['del']="Catégorie supprimée avec succès ";
        header('location:exemplaire.php?ISBN='.$ISBN);
    }
    else{
        $_SESSION['err']="Un erreur s'est produit";
        header('location:exemplaire.php?ISBN='.$ISBN);
    }
    }


    if(isset($_POST['add'])){
        $idexemplaire=$_POST['idexemplaire'];
        $ISBN=$_GET['ISBN'];
        $isissued = 0;
        $sql="INSERT INTO  exemplaire(id_ex,ISBN,isissued) VALUES(:idexemplaire,:ISBN,:isissued); update livre set quant=quant+1 where ISBN=:ISBN";
        $query = $dbh->prepare($sql);
        $query->bindParam(':idexemplaire',$idexemplaire,PDO::PARAM_STR);
        $query->bindParam(':ISBN',$ISBN,PDO::PARAM_STR);
        $query->bindParam(':isissued',$isissued,PDO::PARAM_STR);
        // $query->execute();
        // $lastInsertId = $dbh->lastInsertId();
        if($query->execute()){
        header('location:exemplaire.php?ISBN='.$ISBN);
        $_SESSION['succes']="exemplaire ajouté avec succes";
        }
        else { 
        header('location:exemplaire.php?ISBN='.$ISBN);
        $_SESSION['danger']="Un erreur s'est produit";
        }
    }   


    if(isset($_POST['update'])){
       $id_ex = $_GET['edit'];
       $ISBN = $_GET['ISBN'];
       $nv_id_ex=$_POST['nv_id_ex'];
       $sql="update exemplaire set id_ex=:nv_id_ex where id_ex=:id_ex and ISBN=:ISBN";
       $query = $dbh->prepare($sql);
       $query->bindParam(':nv_id_ex',$nv_id_ex,PDO::PARAM_STR);
       $query->bindParam(':id_ex',$id_ex,PDO::PARAM_STR);
       $query->bindParam(':ISBN',$ISBN,PDO::PARAM_STR);
       if($query->execute()){
        $_SESSION['modif']="exemplaire info modifier avec success";
        header('location:exemplaire.php?ISBN='.$ISBN);
       }
       else{
        $_SESSION['err']="un erreur s'est produit";
        header('location:exemplaire.php?ISBN='.$ISBN);       
       }
       

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
<?php include("../include/header.php")  ?>
    <?php title("Exemplaire","#") ?>





    <?php
$ISBN = $_GET["ISBN"];
$sql = "SELECT * from livre where livre.ISBN=:ISBN";
$query = $dbh -> prepare($sql);
$query->bindParam(":ISBN", $ISBN, PDO::PARAM_STR);
$query->execute();
$results1=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

if($query->rowCount() > 0){
foreach($results1 as $result1)

{               ?> 
<div class="col-md-12">
<td class="center" width="200">
<img src="../bookimg/<?php echo htmlentities($result1->image_livre);?>" width="120">
<b><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities($result1->nom_livre);?></b>
</div>
<br>
<form role="form" method="post">
<div class="col-md-6">
<label style="font-weight: bold;">ID d'exemplaire</label>
<input class="form-control" type="text" name="idexemplaire" value="" required />
</div>
<br>
<div class="col-md-12">
<button type="submit" name="add" class="btn btn-info">Ajouter </button></div>
</form>
</td>

<?php }}?>   



    <!-- **********button to open modal of edit*********** -->
<button id="but" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1" hidden></button>
<!-- ************************************************** -->

<!-- *********Modal modifier livre************ -->
<div class="modal fade modal-lg" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier un Exemplaire</h5>
        <a href="exemplaire.php?ISBN=<?php echo $_GET['ISBN'] ?>"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form class="row g-3" role="form" method="post" enctype="multipart/form-data">
   <div class="form-group">
<label>Ancien ID d'exemplaire</label>
<?php 

$id_ex = $_GET['edit'];
$ISBN = $_GET['ISBN'];
$sql = "SELECT * from exemplaire where id_ex=:id_ex and ISBN=:ISBN";
$query = $dbh -> prepare($sql);
$query->bindParam(':id_ex',$id_ex,PDO::PARAM_STR);
$query->bindParam(':ISBN',$ISBN,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>   
<input class="form-control" type="text" value="<?php echo htmlentities($result->id_ex);?>" disabled readonly/>
<label>Nouveau ID d'exemplaire</label>
<br>
<input class="form-control" type="text" name="nv_id_ex" value="" required />
<?php }} ?>
</div>

                             
<div class="modal-footer">
        <button type="submit" name="update" class="btn btn-primary" id="submit">Save</button>
        <a href="exemplaire.php?ISBN=<?php echo $_GET['ISBN'] ?>"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></a>
      </div>
                                    </form>
   <!-- /body -->
      </div>
    </div>
  </div>
</div>
<!-- ***************************** -->

<br>

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


<!-- ******message add succes******** -->
<?php if($_SESSION['modif']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['modif']);?>
 <?php if(!isset($_GET['edit'])){ ?>
<?php echo htmlentities($_SESSION['modif']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->

<!-- ******message erreur******** -->
<?php if($_SESSION['err']!="")
{?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Erreur :</strong> 
 <?php echo htmlentities($_SESSION['err']);?>
 <?php if(!isset($_GET['edit'])){ ?>
<?php echo htmlentities($_SESSION['err']="");?>
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



<div class="table-data">
<style>
                    #content main .table-data .order table tr td:first-child {
                        display: table-cell;}
                </style>
				<div class="order">
					<div class="head">
						<h3>Liste Des Exemplaires</h3>
					</div>
					<!-- ***************** -->
                    <table id="example" class="table table-striped">
                    <thead>

<tr>
    <th>id d'exemplaire</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php
$ISBN = $_GET["ISBN"];
$sql = "SELECT * from exemplaire join livre on exemplaire.ISBN = livre.ISBN where livre.ISBN=:ISBN";
$query = $dbh -> prepare($sql);
$query->bindParam(":ISBN", $ISBN, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0){
foreach($results as $result)
{               ?>                                      

<tr class="odd gradeX">
<td class="center"><?php echo htmlentities($result->id_ex);?></td>
<td class="center">
<a href="exemplaire.php?ISBN=<?php echo htmlentities($result->ISBN);?>&edit=<?php echo htmlentities($result->id_ex);?>"><button class="btn btn-primary" ><i class="fa fa-edit "></i> Modifier</button>
<a href="exemplaire.php?ISBN=<?php echo htmlentities($result->ISBN);?>&del=<?php echo htmlentities($result->id_ex);?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Supprimer</button>
</td>
</tr>
<?php }}?>                                      
</tbody>
</table>
</div>






<?php
if(isset($_GET['edit'])){
    ?>
<script>
    const button = document.getElementById("but");
    button.click();
</script>

<?php
  }
?>
 
    <?php include("../include/pied.php") ?>
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