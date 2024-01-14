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
        $sql = "delete from livre  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':id',$id, PDO::PARAM_STR);
        if($query -> execute()){
            $_SESSION['del']="Catégorie supprimée avec succès ";
            header('location:livre.php');
          }
          else{
            $_SESSION['err']="Un erreur s'est produit";
            header('location:livre.php');
          }
        }


    if(isset($_POST['edit'])){
        $bookname = $_POST["bookname"];
        $category = $_POST["category"];
        $author = $_POST["author"];
        $ISBN = $_POST["ISBN"];
        $price = $_POST["price"];
        $nbp = $_POST["nbp"];
        $descr = $_POST["descr"];
        $bookid = intval($_GET["bookid"]);
        $bookimg=$_FILES["bookpic"]["name"];
        if($bookimg !=""){
            $cimage=$_POST['curremtimage'];
            $cpath="../bookimg"."/".$cimage;
            $extension = pathinfo($bookimg,PATHINFO_EXTENSION);
            $imgnewname=md5($bookimg.time()).".".$extension;
            move_uploaded_file($_FILES["bookpic"]["tmp_name"],"../bookimg/".$imgnewname);
            $sql="update  livre set nom_livre=:bookname,id_cat=:category,id_aut=:author,num_page=:nbp,description=:descr,image_livre=:imgnewname where id=:bookid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
            $query->bindParam(":bookname", $bookname, PDO::PARAM_STR);
            $query->bindParam(":category", $category, PDO::PARAM_STR);
            $query->bindParam(":author", $author, PDO::PARAM_STR);
            $query->bindParam(":nbp", $nbp, PDO::PARAM_STR);
            $query->bindParam(":descr", $descr, PDO::PARAM_STR);
            $query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
            if($query->execute()){
              $_SESSION['edit']="livre Modifier avec succes ";
              unlink($cpath);
              header('location:livre.php');
             }
             else{
              $_SESSION['erro']="Un erreur s'est produit";
              header('location:livre.php');
             }

        }
        else{
            $sql ="update  livre set nom_livre=:bookname,id_cat=:category,id_aut=:author,num_page=:nbp,description=:descr where id=:bookid";
        $query = $dbh->prepare($sql);
        $query->bindParam(":bookname", $bookname, PDO::PARAM_STR);
        $query->bindParam(":category", $category, PDO::PARAM_STR);
        $query->bindParam(":author", $author, PDO::PARAM_STR);
        $query->bindParam(":nbp", $nbp, PDO::PARAM_STR);
        $query->bindParam(":descr", $descr, PDO::PARAM_STR);
        $query->bindParam(":bookid", $bookid, PDO::PARAM_STR);
        if($query->execute()){
          $_SESSION['edit']="livre Modifier avec succes ";
          header('location:livre.php');
         }
         else{
          $_SESSION['erro']="Un erreur s'est produit";
          header('location:livre.php');
         }
        
        }
    }



    if(isset($_POST['add'])){
        $bookname=$_POST['bookname'];
        $category=$_POST['category'];
        $author=$_POST['author'];
        $ISBN=$_POST['ISBN'];
        $bookimg=$_FILES["bookpic"]["name"];
        $nb=$_POST['nb'];
        $ISBN = $_POST['ISBN'];
        $qte=0;
        $desc=$_POST['desc'];
        $extension = pathinfo($bookimg,PATHINFO_EXTENSION);
        // allowed extensions
        $allowed_extensions = array("jpg","jpeg","png","gif");
        // Validation for allowed extensions .in_array() function searches an array for a specific value.
        //rename the image file
        $imgnewname=md5($bookimg.time()).".".$extension;
        // Code for move image into directory
        if(!in_array($extension,$allowed_extensions)){
            echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
        }
        else{
            move_uploaded_file($_FILES["bookpic"]["tmp_name"],"../bookimg/".$imgnewname);
            $sql="INSERT INTO  livre(ISBN,id_cat,image_livre,num_page,quant,description,id_aut,nom_livre,reserved) VALUES(:ISBN,:category,:imgnewname,:numb,:qte,:descr,:author,:bookname,0)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':bookname',$bookname,PDO::PARAM_STR);
            $query->bindParam(':numb',$nb,PDO::PARAM_STR);
            $query->bindParam(':qte',$qte,PDO::PARAM_STR);
            $query->bindParam(':descr',$desc,PDO::PARAM_STR);
            $query->bindParam(':category',$category,PDO::PARAM_STR);
            $query->bindParam(':author',$author,PDO::PARAM_STR);
            $query->bindParam(':ISBN',$ISBN,PDO::PARAM_STR);
            $query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if($lastInsertId){
                $_SESSION['succes']="livre listé avec success";
                header("Location: livre.php");
            }
            else{
                $_SESSION['danger']="un erreur s'est produit";
                header("Location: livre.php");
            }
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
<script>

function checkAvailability() {
jQuery.ajax({
url: "check_availability.php",
data:'ISBN='+$("#ISBN").val(),
type: "POST",
success:function(data){
$("#ISBN-availability-status").html(data);
},
error:function (){}
});
}
</script>    

	<title>AdminSite</title>
</head>
<body>

<!-- **********button to open modal of edit*********** -->
<button id="but" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1" hidden></button>
<!-- ************************************************** -->

    <?php include("../include/header.php")  ?>
    <?php title("Livres","#") ?>

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

<!-- ******message add succes******** -->
<?php if($_SESSION['edit']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['edit']);?>
 <?php if(!isset($_GET['bookid'])){ ?>
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
 <?php if(!isset($_GET['bookid'])){ ?>
<?php echo htmlentities($_SESSION['erro']="");?>
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
        <h5 class="modal-title" id="exampleModalLabel">Ajouter Un Livre</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form class="row g-3" role="form" method="post" enctype="multipart/form-data">

   <div class="col-md-6">   
<label>Nom Du livre<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="bookname" autocomplete="off"  required />
</div>

<div class="col-md-6">  
<label> Catégorie<span style="color:red;">*</span></label>
<select class="form-select" name="category" required="required">
<option value=""> Choisir une catégorie</option>
<?php 
$sql = "SELECT * from  categorie ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0){
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->id_cat);?>"><?php echo htmlentities($result->cat_nom);?></option>
 <?php }} ?> 
</select>
</div>


<div class="col-md-6">  
<label> Auteur<span style="color:red;">*</span></label>
<select class="form-select" name="author" required="required">
<option value=""> choisir un Auteur</option>
<?php 
$sql = "SELECT * from  auteur ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0){
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->id_auteur);?>"><?php echo htmlentities($result->nom_auteur)." ".htmlentities($result->prenom_auteur);?></option>
 <?php }} ?> 
</select>
</div>



<div class="col-md-6">  
<label>Numéro ISBN<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="ISBN" id="ISBN" required="required" autocomplete="off" onBlur="checkAvailability()"  />
<p class="help-block">Un ISBN est un numéro international normalisé du livre. L'ISBN doit être unique</p>
         <span id="ISBN-availability-status" style="font-size:12px;"></span>
</div>


<div class="col-md-6">  
 <label>Image Du Livre<span style="color:red;">*</span></label>
 <input class="form-control" type="file" name="bookpic" autocomplete="off"   required="required" />
 </div>
 

<div class="col-md-6">  
 <label>Nombre Des Pages<span style="color:red;">*</span></label>
 <input class="form-control" type="text" name="nb" autocomplete="off"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" required="required" />
 </div>




<div class="col-12">  
<label>Description<span style="color:red;">*</span></label>
<textarea  class="form-control" type="text" name="desc" autocomplete="off"   required="required" ></textarea >
</div>

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








<!-- *********Modal modifier livre************ -->
<div class="modal fade modal-lg" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier un livre</h5>
        <a href="livre.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form class="row g-3" role="form" method="post" enctype="multipart/form-data">
   <?php

$bookid = intval($_GET["bookid"]);
$sql ="SELECT livre.id,num_page,livre.nom_livre,categorie.cat_nom,categorie.id_cat as idcat,auteur.nom_auteur,auteur.id_auteur as idauteur,auteur.prenom_auteur,livre.ISBN,livre.quant,livre.id as bookid,livre.image_livre,livre.num_page,substr(livre.description,1,150) as descr , livre.description as descr from  livre join categorie on categorie.id_cat=livre.id_cat join auteur on auteur.id_auteur=livre.id_aut where livre.id=:bookid";
$query = $dbh->prepare($sql);
$query->bindParam(":bookid", $bookid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
    foreach ($results as $result) { ?>  
<div class="col-md-6">
<label>Image Du Livre</label>
<img src="../bookimg/<?php echo htmlentities($result->image_livre); ?>" width="100">
</div>

<div class="col-md-6"> 
 <label>Image Du Livre</label>
  <input class="form-control" type="file" name="bookpic" autocomplete="off"   />
  </div>

<div class="col-md-6">
<label>Nom Du Livre</label>
<input class="form-control" type="text" name="bookname" value="<?php echo htmlentities($result->nom_livre);?>" required />
</div>



<div class="col-md-6">
<label> Catégorie</label>
<select class="form-select" name="category" required="required">
<option value="<?php echo htmlentities($result->idcat); ?>"> <?php echo htmlentities($catname = $result->cat_nom); ?></option>
<?php
$sql1 = "SELECT * from  categorie ";
$query1 = $dbh->prepare($sql1);
$query1->execute();
$resultss = $query1->fetchAll(PDO::FETCH_OBJ);
if ($query1->rowCount() > 0) {
    foreach ($resultss as $row) {
        if ($catname == $row->cat_nom) {
            continue;
        } else {
             ?>  

<option value="<?php echo htmlentities($row->id_cat); ?>"><?php echo htmlentities($row->cat_nom); ?></option>
 <?php
        }}}
?> 
</select>
</div>



<div class="col-md-6">
<label> Auteur</label>
<select class="form-select" name="author" required="required">
<option value="<?php echo htmlentities($result->idauteur); ?>"> <?php echo htmlentities($nom_auteur = $result->nom_auteur)." ".htmlentities($prenom_auteur = $result->prenom_auteur); ?></option>
<?php
$sql2 = "SELECT * from  auteur ";
$query2 = $dbh->prepare($sql2);
$query2->execute();
$result2 = $query2->fetchAll(PDO::FETCH_OBJ);
if ($query2->rowCount() > 0) {
    foreach ($result2 as $ret) {
        if ($nom_auteur == $ret->nom_auteur && $prenom_auteur == $ret->prenom_auteur ) {
            continue;
        } else {
             ?>  
<option value="<?php echo htmlentities($ret->id_auteur); ?>"><?php echo htmlentities($ret->nom_auteur)." ".htmlentities($ret->prenom_auteur); ?></option>
 <?php
        }}}
?> 
</select>
</div>





<div class="col-md-6">
<label>Numéro ISBN</label>
<input class="form-control" type="text" name="ISBN" value="<?php echo htmlentities($result->ISBN); ?>"  readonly />
<p class="help-block">Un ISBN est un numéro international normalisé du livre. L'ISBN doit être unique</p>
</div>




 <div class="col-md-6">
<label>Nombre Des Pages</label>
<input class="form-control" type="text" name="nbp" value="<?php echo htmlentities($result->num_page); ?>"   required="required" />
</div>




<div class="col-md-12">
 <label>Description</label>
 <textarea class="form-control" type="text" name="descr" required="required" ><?php echo htmlentities($result->descr); ?></textarea>
</div>


 <?php }} ?>
<div class="modal-footer">
        <button type="submit" name="edit" class="btn btn-primary" id="submit">Save</button>
        <a href="livre.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></a>
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
						<h3>Liste Des Livres</h3>
                        <button id="butt" class="btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-add "></i> Nouveau Livre</button>
					</div>
					<!-- ***************** -->
                    <table id="example" class="table table-striped">
                    <thead>

<tr>
    <th>Nom Du Livre</th>

    <th>Catégorie</th>

    <th>Auteur</th>

    <th>ISBN</th>

    <th>Quantité</th>

    <th>Action</th>
</tr>

</thead>

<tbody>

<?php $sql = "SELECT livre.nom_livre,categorie.cat_nom,auteur.nom_auteur,auteur.prenom_auteur,livre.ISBN,livre.quant,livre.id as bookid,livre.image_livre,livre.num_page,substr(livre.description,1,150) as descr from  livre join categorie on categorie.id_cat=livre.id_cat join auteur on auteur.id_auteur=livre.id_aut";

$query = $dbh -> prepare($sql);

$query->execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)

{

foreach($results as $result)

{               ?>                                      

<tr class="odd gradeX">

    <td class="center" style="padding-left : 10px;" width="250">

<img src="../bookimg/<?php echo htmlentities($result->image_livre);?>" width="100">

        <br /><b><?php echo htmlentities($result->nom_livre);?></b></td>
        <input type="hidden" name="curremtimage" value="<?php echo htmlentities($result->image_livre);?>">

    <td class="center" width="120"><?php echo htmlentities($result->cat_nom);?></td>

    <td class="center" style="padding-left : 10px;"><?php echo htmlentities($result->nom_auteur)." ".htmlentities($result->prenom_auteur);?></td>

    <td class="center"><?php echo htmlentities($result->ISBN);?></td>

    <td class="center" style="text-align : center;"><?php echo htmlentities($result->quant);?></td>

    <td class="center">



    <a href="livre.php?bookid=<?php echo htmlentities($result->bookid);?>"><button class="btn-edit" ><i class="fa fa-edit "></i> Modifier</button>

  <a href="livre.php?del=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Are you sure you want to delete?');"" >  <button class="btn-del"><i class="fa fa-trash"></i> Supprimer</button>
<div style="padding : 7px;">

</div>
  <a href="exemplaire.php?ISBN=<?php echo htmlentities($result->ISBN);?>"><button class="btn-jaune" name="exemplaire"><i class="fa fa-book "></i> Exemplaire</button>

    </td>

</tr>

<?php }} ?>                                      

</tbody>

</table>
			
                    <!-- ********************** -->
				</div>





		<?php include("../include/pied.php") ?>

<script src="jquery-1.10.2.js"></script>

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
</body>

</html>
<?php } ?>
