<?php include("../include/title.php");
include('../include/config.php');  ?>
<?php
session_start();
error_reporting(0);
if(strlen($_SESSION['alogin'])==0){   
header('location:../index.php');
}
else{ 
    if(isset($_POST['change']))
    {
  $password=md5($_POST['password']);
  $newpassword=md5($_POST['newpassword']);
  $email=$_SESSION['alogin'];
    $sql ="SELECT pass_admin FROM admin where email=:email and pass_admin=:password";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':email', $email, PDO::PARAM_STR);
  $query-> bindParam(':password', $password, PDO::PARAM_STR);
  $query-> execute();
  $results = $query -> fetchAll(PDO::FETCH_OBJ);
  if($query -> rowCount() > 0)
  {
  $con="update admin set pass_admin=:newpassword where email=:email";
  $chngpwd1 = $dbh->prepare($con);
  $chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
  $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
  $chngpwd1->execute();
  $msg=" Votre mot de passe a été modifié avec succès";
  }
  else {
  $error=" Votre mot de passe actuel est erroné";  
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
    <script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("Les champs Nouveau mot de passe et Confirmer le mot de passe ne correspondent pas  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>

</head>
<body>
<?php include("../include/header.php")  ?>
    <?php title("Changer le mot de passe","#") ?>
    <?php if($error){?><div class="alert alert-danger"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="alert alert-success"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>   
    <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Changer le mot de passe</h3>
					</div>

                    <div class="panel-body">
<form role="form" method="post" onSubmit="return valid();" name="chngpwd">

<div class="mb-3">
<label>Mot de passe actuel</label>
<input class="form-control" type="password" name="password" autocomplete="off" required  />
</div>

<div class="mb-3">
<label>Entrer le mot de passe</label>
<input class="form-control" type="password" name="newpassword" autocomplete="off" required  />
</div>

<div class="mb-3">
<label>Confirmez le mot de passe </label>
<input class="form-control"  type="password" name="confirmpassword" autocomplete="off" required  />
</div>

 <button style="background-color: #5b3487; color:#ffffff; border: none; " type="submit" name="change" class="btn btn-info">Modifier </button> 
</form></div>

                </div>
    </div>

    <?php include("../include/pied.php") ?>
    </body>

    </html>
<?php } ?>