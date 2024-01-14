<?php
session_start();
error_reporting(0);
if(strlen($_SESSION['alogin'])==0){   
header('location:../index.php');
}
else{ 
  include("../include/title.php");
include('../include/config.php');
  if(isset($_GET['del'])){
  $id=$_GET['del'];
  $sql = "delete from categorie  WHERE id_cat=:id";
  $query = $dbh->prepare($sql);
  $query -> bindParam(':id',$id, PDO::PARAM_STR);
  if($query -> execute()){
    $_SESSION['del']="Catégorie supprimée avec succès ";
    header('location:categorie.php');
  }
  else{
    $_SESSION['err']="Un erreur s'est produit";
    header('location:categorie.php');
  }
  }

if(isset($_POST['edit'])){
  $catid=intval($_GET['catid']);
  $category = $_POST["category"];
  $catimg=$_FILES["catpic"]["name"];
    if($catimg !=""){
      $cimage=$_POST['curremtimage'];
      $cpath="catimg"."/".$cimage;
      $extension = pathinfo($catimg,PATHINFO_EXTENSION);
     $imgnewname=md5($catimg.time()).".".$extension;
     move_uploaded_file($_FILES["catpic"]["tmp_name"],"catimg/".$imgnewname);
     $sql="update categorie set cat_nom=:category,image_cat=:imgnewname where id_cat=:catid";
     $query = $dbh->prepare($sql);
     $query->bindParam(":category", $category, PDO::PARAM_STR);
     $query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
     $query->bindParam(':catid',$catid,PDO::PARAM_STR);
     if($query->execute()){
      $_SESSION['edit']="Categorie Modifier avec succes ";
      header('location:categorie.php');
      unlink($cpath);
     }
     else{
      $_SESSION['erro']="Un erreur s'est produit";
      header('location:categorie.php');
     }

   }
else{
  $sql ="update categorie set cat_nom=:category where id_cat=:catid";
$query = $dbh->prepare($sql);
$query->bindParam(":category", $category, PDO::PARAM_STR);
$query->bindParam(":catid", $catid, PDO::PARAM_STR);
if($query->execute()){
  $_SESSION['edit']="Categorie Modifier avec succes ";
  header('location:categorie.php');
 }
 else{
  $_SESSION['erro']="Un erreur s'est produit";
  header('location:categorie.php');
 }

}

}


if(isset($_POST['add'])){
$category=$_POST['category'];
$catimg=$_FILES["catpic"]["name"];
// get the image extension
$extension = pathinfo($catimg,PATHINFO_EXTENSION);
// allowed extensions
$allowed_extensions = array("jpg","jpeg","png","gif");
//rename the image file
$imgnewname=md5($catimg.time()).".".$extension;
if(!in_array($extension,$allowed_extensions)){
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else{
// Code for move image into directory
move_uploaded_file($_FILES["catpic"]["tmp_name"],"catimg/".$imgnewname);
$sql="INSERT INTO categorie(cat_nom,image_cat) VALUES(:category,:imgnewname)";
$query = $dbh->prepare($sql);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();

if($lastInsertId){
$_SESSION['succes']="catégorie listé avec success";
header("Location: categorie.php");
}
else {
$_SESSION['danger']="un erreur s'est produit";
header("Location: categorie.php");
}}
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
 <link rel="shortcut icon" type="image/x-icon" href="../assets/img/logo1.png" />
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/datatable.bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
       
<script>

function checkAvailability() {
jQuery.ajax({
url: "check_availability.php",
data:'category='+$("#category").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
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
    <?php title("Catégorie","#") ?>

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
<?php if($_SESSION['edit']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['edit']);?>
 <?php if(!isset($_GET['catid'])){ ?>
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
 <?php if(!isset($_GET['catid'])){ ?>
<?php echo htmlentities($_SESSION['erro']="");?>
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










<!-- *********Modal add categorie************ -->
<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter Une Catégorie</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form role="form" method="post" enctype="multipart/form-data">
   <label>Nom De Catégorie<span style="color:red;">*</span></label>
   <input class="form-control" type="text" name="category" id="category" onBlur="checkAvailability()" autocomplete="off" required />
  <span id="user-availability-status" style=" font-size:12px;"></span> 
  <br>
  <label>Image Du Catégorie<span style="color:red;">*</span></label>
  <input class="form-control" type="file" name="catpic" autocomplete="off"   required="required" />
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




<!-- *********Modal modifier categorie************ -->
<div class="modal fade modal-lg" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier une catégorie</h5>
        <a href="categorie.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form role="form" method="post" enctype="multipart/form-data">
<?php 
$catid=intval($_GET['catid']);
$sql = "SELECT * from categorie where id_cat=:catid";
$query = $dbh -> prepare($sql);
$query->bindParam(':catid',$catid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0){
foreach($results as $result)
{               ?>  
<input type="hidden" name="curremtimage" value="<?php echo htmlentities($result->image_cat);?>">
   <div class="form-group">
     <label>Image de catégorie</label>
     <img style="border-radius: 8%;" src="catimg/<?php echo htmlentities($result->image_cat);?>" width="100">
   </div>
<br>
<div class="form-group">
<label style="padding-right:8px;">Nom de catégorie<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="category" value="<?php echo htmlentities($result->cat_nom);?>" />
</div>
<br>
 <div class="form-group">
 <label>Image De catégorie<span style="color:red;">*</span></label>
 <input class="form-control" type="file" name="catpic" autocomplete="off"/>
 </div>
    <br>
 <?php }} ?>
 <div class="modal-footer">
        <button type="submit" name="edit" class="btn btn-primary" id="submit">Save</button>
        <a href="categorie.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></a>
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
				<div class="order">
					<div class="head">
						<h3>Liste Des Catégories</h3>
                        <button id="butt" class="btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-add "></i> Nouveau Catégorie</button>
					</div>
					<!-- ***************** -->
                    <table id="example" class="table table-striped">
						<thead>
							<tr>
                            <th>Image de catégorie</th>
                            <th>Nom de Categorie</th>
                            <th>Action</th>
							</tr>
						</thead>
						<tbody>
                        <?php $sql = "SELECT * from  categorie";

$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
    <tr class="odd gradeX">
       <td class="center">
            <img src="catimg/<?php echo htmlentities($result->image_cat);?>" >
       </td>
       <td class="center" width="350"><?php echo htmlentities($result->cat_nom);?></td>
       <td class="center" width="350">
       <a href="categorie.php?catid=<?php echo htmlentities($result->id_cat);?>"><button class="btn-edit" ><i class="fa fa-edit "></i> Modifier</button> 
       <a href="categorie.php?del=<?php echo htmlentities($result->id_cat);?>" onclick="return confirm('Etes-vous sûr que vous voulez supprimer?');" >  <button class="btn-del"><i class="fa fa-trash"></i> Supprimer</button>
       </td>
    </tr>
 <?php }} ?>                                      

                                    </tbody>

                                </table>
			
                    <!-- ********************** -->
				</div>



<script src="jquery-1.10.2.js"></script>


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
if(isset($_GET['catid'])){
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