<?php
session_start();
error_reporting(0);
include("../include/title.php");
include('../include/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 
    if(isset($_GET['accepte'])){
    $id_res = $_GET['accepte'];
    $ISBN = $_GET['ISBN'];
    $accepte = 1;
    $sql = "update reservation set statue_res=:accepte,date_res=NOW() where id_res=:id_res;
    update livre set reserved=reserved+1 where ISBN=:ISBN";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id_res',$id_res, PDO::PARAM_STR);
    $query -> bindParam(':accepte',$accepte, PDO::PARAM_STR);
    $query -> bindParam(':ISBN',$ISBN, PDO::PARAM_STR);
    $query -> execute();
    header('location:demande.php');
    $_SESSION['accep']="livre accepter avec success";
    }
    if(isset($_GET['refuse'])){
    $id_res = $_GET['refuse'];
    $refuse = 0;
    $sql = "update reservation set statue_res=:refuse where id_res=:id_res";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':id_res',$id_res, PDO::PARAM_STR);
    $query -> bindParam(':refuse',$refuse, PDO::PARAM_STR);
    $query -> execute();
    header('location:demande.php');
    $_SESSION['ref']="livre refuser avec success";
    }

    if(isset($_POST['add'])){

$student=strtoupper($_POST['student']);
$exemplaire=$_POST['exemplaire'];
$statue_res=1;

$sql="INSERT INTO  reservation(CNE,id_exp,statue_res,date_res) VALUES(:student,:exemplaire,:statue_res,NOW());
update livre set reserved=reserved+1 where ISBN=(select ISBN from exemplaire where id_ex=:exemplaire) ;
update exemplaire set isissued=:statue_res where id_ex=:exemplaire ;";

$query = $dbh->prepare($sql);
$query->bindParam(':student',$student,PDO::PARAM_STR);
$query->bindParam(':exemplaire',$exemplaire,PDO::PARAM_STR);
$query->bindParam(':statue_res',$statue_res,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();

if($lastInsertId){
    $_SESSION['succes']="livre emprunter avec success";
    header('location:demande.php');
}

else {
    $_SESSION['danger']="un erreur s'est produit";
    header('location:demande.php');
}
}


if(isset($_GET['refuse']))
{
$id_res = $_GET['refuse'];
$refuse = 0;
$sql = "update reservation set statue_res=:refuse where id_res=:id_res";

$query = $dbh->prepare($sql);
$query -> bindParam(':id_res',$id_res, PDO::PARAM_STR);
$query -> bindParam(':refuse',$refuse, PDO::PARAM_STR);
$query -> execute();
header('location:demande.php');
}

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/77f8f4dfd1.js" crossorigin="anonymous"></script>
 <link rel="shortcut icon" type="image/x-icon" href="../assets/img/logo1.png" />
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
    <?php title("Demandes D'emprunt","#") ?>

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
    <?php if($_SESSION['accep']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['accep']);?>
 <?php if(!isset($_GET['accepte'])){ ?>
<?php echo htmlentities($_SESSION['accep']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->


    <!-- ******message add succes******** -->
    <?php if($_SESSION['ref']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['ref']);?>
 <?php if(!isset($_GET['refuse'])){ ?>
<?php echo htmlentities($_SESSION['ref']="");?>
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



<!-- *********Modal add livre************ -->
<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Emprunter Un Livre</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form class="row g-3" role="form" method="post" enctype="multipart/form-data">
<label>ID D'étudiant<span style="color:red;">*</span></label>
<select class="form-select" name="student" required="required" id="searchstudent">
<option value=""> Sélectionnez un étudiant</option>
<?php 
$sql = "SELECT CNE,nom,prenom from  etudiant order by nom asc ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

if($query->rowCount() > 0){
foreach($results as $result){               ?> 
<option value="<?php echo htmlentities($result->CNE);?>"><?php echo htmlentities($result->nom)." ".htmlentities($result->prenom);?></option>
 <?php }} ?> 
</select>


<label>Titre de livre<span style="color:red;">*</span></label>
<!-- <input class="form-control" type="text" name="booikid" id="bookid" onBlur="getbook()"  required="required" /> -->
<select class="form-select" name="exemplaire" required="required" id="searchstudent">
<option value=""> Sélectionnez le nom de livre</option>
<?php 
$sql = "SELECT livre.id,livre.ISBN,livre.nom_livre,id_ex from  livre join exemplaire on livre.ISBN=exemplaire.ISBN where isissued=0 group by ISBN  ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

if($query->rowCount() > 0){
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->id_ex);?>"><?php echo htmlentities($result->nom_livre)." // exemplaire id : ".htmlentities($result->id_ex);?></option>
 <?php }} ?> 
</select>

<div class="modal-footer">
        <button type="submit" name="add" class="btn btn-primary" id="add">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
						<h3>Liste Des Demandes</h3>
                        <button id="butt" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-add "></i> Emprunter Un Livre</button>
					</div>
					<!-- ***************** -->
                    <table id="example" class="table table-striped">
                    <thead>
                                        <tr>
                                            <th>Nom Du Livre</th>
                                            <th>Id D'Exemplaire</th>
                                            <th>Nom D'étudiant</th>
                                            <th>CNE</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $sql = "SELECT * from reservation join exemplaire on reservation.id_exp = exemplaire.id_ex join etudiant on reservation.CNE = etudiant.CNE join livre on livre.ISBN=exemplaire.ISBN where statue_res is NULL";
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
                                            <td class="center"><?php echo htmlentities($result->CNE);?></td>
                                         
                                            
                                            <td class="center">

                                            <a href="demande.php?ISBN=<?php echo htmlentities($result->ISBN);?>&accepte=<?php echo htmlentities($result->id_res);?>"><button class="btn btn-success"><i class="fa fa-check "> </i> Accepter</button> 
                                            <a href="demande.php?refuse=<?php echo htmlentities($result->id_res);?>"><button class="btn btn-danger"><i class="fa fa-ban "> </i> Refuser</button> 
                                            </td>
                                        </tr>
 <?php }} ?>                                      
                                    </tbody>


                                    </table>
			
            <!-- ********************** -->
        </div>





<?php include("../include/pied.php") ?>

</body>


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
