<?php

session_start();

error_reporting(0);

include('include/config.php');

if($_SESSION['alogin']!=''){

$_SESSION['alogin']='';

}

if(isset($_POST['login']))

{

$username=$_POST['username'];

$password=md5($_POST['password']);

$sql ="SELECT email,Pass_admin FROM admin WHERE email=:username and Pass_admin=:password";

$query= $dbh -> prepare($sql);

$query-> bindParam(':username', $username, PDO::PARAM_STR);

$query-> bindParam(':password', $password, PDO::PARAM_STR);

$query-> execute();

$results=$query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0)

{

$_SESSION['alogin']=$_POST['username'];

echo "<script type='text/javascript'> document.location ='dashboard/dashboard'; </script>";

} else{

echo "<script>alert('Invalid Details');</script>";

}

}

?>





<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
     <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo1.png" />

    <title>Gestion de bibliothèque - login</title>

    <link href="assets/css/login.style.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/876d7409f1.js" crossorigin="anonymous"></script>

</head>

<body>

    <img class="logoestg" src="assets/img/estguelmim1.png" alt="logoestg">

    <img class="logo" src="assets/img/logo1.png" alt="Logo">

    <div class="container">

        <div class="form-box">  

            <h1>Login</h1>

            <form role="form" method="post">

                <div class="input-group">

                    <div class="input-field">

                       <i class="fa-solid fa-user"></i>

                        <input name="username" type="text" placeholder="Email" autocomplete="off" required>

                    </div>

                    <div class="input-field">

                        <i class="fa-solid fa-lock"></i>

                         <input type="password" name="password" placeholder="Mot de passe" autocomplete="off" required>

                     </div>

                </div>

                <div class="btn-field"> 

                    <button name="login" type="submit">Sign in</button>

                </div>

            </form>
               <br> <h6 style ="color: grey;"> IBN ZOHR © <?php echo date("Y"); ?> </h6>  
        </div>

    </div>

</body>

</html>