<!-- SIDEBAR -->
<style>
		  a {
	text-decoration: none;
  }
	</style>

<section id="sidebar">
		<!-- <a href="#" class="brand"><i class='bx bxs-smile icon'></i> AdminSite</a> -->
		<a href="../dashboard/dashboard" class="logo">
      <img style="padding-left:4px; padding-top:7px;" src="../assets/img/logo2.png" alt="">
    </a>
		<ul class="side-menu">
			<li><a href="../dashboard/dashboard" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
			<li><a href="../categorie/categorie"><i class='bx bxs-category-alt icon' ></i> Catégorie </a></li>
			<li><a href="../auteur/auteur"><i class='fa fa-pen-nib icon' ></i> Auteurs </a></li>
			<li><a href="../livre/livre"><i class='fa fa-book icon' ></i> Livres </a></li>
			<li>
				<a href="#"><i class='fa-solid fa-book-medical icon' ></i> Livres emprunté <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
				<li><a href="../demande/demande">Les demandes d'emprunt</a></li>
					<li><a href="../historique/historique">Historique des livres retourner</a></li>
					<li><a href="../NonRetourner/NonRetourner">Les livres pas encore retourner</a></li>
				</ul>
			</li>
			<li>
				<a href="../etudiant/etudiant"><i class='fa fa-graduation-cap icon' ></i> Étudiants inscrits </a>
			</li>
		</ul>
		<h6> IBN ZOHR © <?php echo date("Y"); ?> </h6> 
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu toggle-sidebar' ></i>
			<form>
				<div class="form-group">
				</div>
			</form>
			<span class="divider"></span>
			<div class="profile">
			<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/92/Cog_font_awesome.svg/512px-Cog_font_awesome.svg.png" alt="">
<style>
nav .profile img {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  object-fit: cover;
  cursor: pointer;
}
h6{
color: grey;
text-align : center;
padding-top : 300px;
font-size : .7em;
}
</style>

			<ul class="profile-link">
					<li><a href="../changepwd"><i class='bx bxs-key' ></i> changer le mot de passe</a></li>
					<li><a href="../logout.php"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->
        <main>
