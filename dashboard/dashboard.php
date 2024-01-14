<?php
 include("../include/title.php");
 include('../include/config.php');  
session_start();
error_reporting(0);
if(strlen($_SESSION['alogin'])==0){   
header('location:../index.php');
}
else{ 

if(isset($_POST['return']))
{
$id_res=$_GET['idres'];
$id_exp=$_POST['id_exp'];
$ISBN=$_POST['ISBN'];
$sql="update reservation set date_ret=NOW() where id_res=:id_res;
update exemplaire set isissued=0 where id_ex=:id_ex and ISBN=:ISBN";
$query = $dbh->prepare($sql);
$query->bindParam(':id_res',$id_res,PDO::PARAM_STR);
$query->bindParam(':id_ex',$id_exp,PDO::PARAM_STR);
$query->bindParam(':ISBN',$ISBN,PDO::PARAM_STR);

if($query->execute()){
	$_SESSION['retour']="livre Retourner avec success";
	header('location:dashboard.php');
}
else{
	$_SESSION['err']="Un erreur s'est produit";
	header('location:dashboard.php');
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
	    <!-- **********button to open modal of edit*********** -->
<button id="but" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1" hidden></button>
<!-- ************************************************** -->
    <?php include("../include/header.php")  ?>
    <?php title("Dashboard","#") ?>







<!-- *********Modal Retourner livre************ -->
<div class="modal fade modal-lg" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Retourner un livre</h5>
        <a href="dashboard.php"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
   <!-- body -->
   <form class="row g-3" role="form" method="post" enctype="multipart/form-data">
   <?php 
$id_res=$_GET['idres'];
$sql = "SELECT * from reservation join exemplaire on reservation.id_exp = exemplaire.id_ex join etudiant on reservation.CNE = etudiant.CNE join livre on livre.ISBN=exemplaire.ISBN where statue_res=1 and date_ret is null and id_res=:id_res";
$query = $dbh -> prepare($sql);
$query->bindParam(':id_res',$id_res,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                   


<input type="hidden" name="ISBN" value="<?php echo htmlentities($result->ISBN);?>">
<input type="hidden" name="id_exp" value="<?php echo htmlentities($result->id_exp);?>">
<h4 style="font-weight: bold;">Student Details</h4>
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
<label style="font-weight: bold;">Prénom D'Etudiant :</label>
<?php echo htmlentities($result->prenom);?>
</div>



<h4 style="font-weight: bold;">Détails Du Livre</h4>
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
<label style="font-weight: bold;">Date D'Emprunt Du Livre :</label>
<?php echo htmlentities($result->date_res);?>
</div>

<div class="col-md-6"> 
<label style="font-weight: bold;">Date De Retour Du Livre :</label>
<?php if($result->date_ret=="")
                                            {
                                                echo htmlentities("Pas encore retourné");
                                            } else {


                                            echo htmlentities($result->date_ret);
}
                                            ?>
</div>




 <?php if($result->RetrunStatus==0){?>
    <div class="col-md-12"> 
    <hr />
    <button type="submit" name="return" class="btn btn-info">Retourner Le Livre </button>
 </div>
 </div>
<?php }}} ?>
 <div class="modal-footer">
        <a href="Dashboard.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></a>
      </div>


                                    </form>
   <!-- /body -->
      </div>
    </div>
  </div>
</div>
<!-- ***************************** -->









	<!-- count number of book -->
   <?php 
      $sql ="SELECT ISBN from livre ";
      $query = $dbh -> prepare($sql);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
      $listdbooks=$query->rowCount();
   ?>
<!-- ********** -->



			<ul class="box-info">
				<li>
					<i class="bx bxs-book-open"></i>
					<span class="text">
						<h3><?php echo htmlentities($listdbooks);?></h3>
						<a href="../livre/livre"><p>Livre Listé</p></a>
					</span>
				</li>
<!-- count number of student -->
	<?php 
       $sql1 ="SELECT CNE from etudiant ";
       $query1 = $dbh -> prepare($sql1);
       $query1->execute();
       $results1=$query1->fetchAll(PDO::FETCH_OBJ);
       $regstds=$query1->rowCount();
    ?>
	<!-- ********************* -->
				<li>
					<i class="bx bxs-group"></i>
					<span class="text">
						<h3><?php echo htmlentities($regstds);?></h3>
						<a href="../etudiant/etudiant"><p>Utilisateurs</p></a>
					</span>
				</li>
<!-- count number of books not returned  -->
     <?php 
       $sql2 ="SELECT id_res from reservation where (date_ret= 0 || date_ret is null) and statue_res = 1";
       $query2 = $dbh -> prepare($sql2);
       $query2->execute();
       $results2=$query2->fetchAll(PDO::FETCH_OBJ);
       $returnedbooks=$query2->rowCount();
     ?>
<!-- ************************* -->
				<li>
					<i class="bx bx-recycle"></i>
					<span class="text">
						<h3><?php echo htmlentities($returnedbooks);?></h3>
						<a href="../NonRetourner/NonRetourner"><p>Livres Non rendus</p></a>
					</span>
				</li>
			</ul>


<!-- ******message retourn succes******** -->
<?php if($_SESSION['retour']!="")
{?>
<div class="col-md-6">
<div class="alert alert-success" >
 <strong>Success :</strong> 
 <?php echo htmlentities($_SESSION['retour']);?>
 <?php if(!isset($_GET['idres'])){ ?>
<?php echo htmlentities($_SESSION['retour']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->


<!-- ******message retourn succes******** -->
<?php if($_SESSION['danger']!="")
{?>
<div class="col-md-6">
<div class="alert alert-danger" >
 <strong>Erreur :</strong> 
 <?php echo htmlentities($_SESSION['err']);?>
 <?php if(!isset($_GET['idres'])){ ?>
<?php echo htmlentities($_SESSION['err']="");?>
<?php } ?>
</div>
</div>
<?php } ?>
<!-- ****************************************** -->



			
			<div class="table-data">
				<div class="order">
					<div class="head">
					<h3>Livre Non Retourné</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table id="example" class="table table-striped">
						<thead>
							<tr>
                            <th>Image du livre</th>
							<th>Nom du livre</th>
                            <th>ID d'exemplaire</th>
                            <th>Nom d'étudiant</th>
                            <th>Date d'emprunt</th>
                            <th>Action</th>
							</tr>
						</thead>
						<tbody>
<?php $sql = "SELECT * from reservation join exemplaire on reservation.id_exp = exemplaire.id_ex join etudiant on reservation.CNE = etudiant.CNE join livre on livre.ISBN=exemplaire.ISBN where statue_res=1 and date_ret is null order by date_res";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>   
<tr class="odd gradeX">
                                            <td class="center" >
                                            <img src="../bookimg/<?php echo htmlentities($result->image_livre);?>" width="100"></td>
											<td class="center" width="300"><?php echo htmlentities($result->nom_livre);?></td>
                                            <td class="center" width="200"><?php echo htmlentities($result->id_exp);?></td>
                                            <td class="center"><?php echo htmlentities($result->nom)." ".htmlentities($result->prenom);?></td>
                                            <td class="center" width="195"><?php echo htmlentities($result->date_res);?></td>
                                            <td class="center">

                                            <a href="dashboard.php?idres=<?php echo htmlentities($result->id_res);?>"><button class="btn-return"><i class="fa fa-exchange"></i> Retourner</button> 
                                         
                                            </td>
                                        </tr>
 <?php }} ?>                    
						</tbody>
					</table>
							
				</div>



    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>

	<script>
		$(document).ready(function () {
    $('#example').DataTable();
       });
		</script>
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

</body>
</html>
<?php } ?>