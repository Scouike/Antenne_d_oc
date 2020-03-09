<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Recherche</title>
		<!-- Lien vers boostrap -->
		<link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../../fontawesome/css/all.css" rel="stylesheet" >
		
		<!-- script boostrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>

	<body>
		<!-- Barre de navigation --> 
		<?php   
			if (isset($_SESSION['level']) && $_SESSION['level']==1) {
				include('../bareNav/barreNavUtilisateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				/* inclu une barre de navigation */
				include('../bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==3) {
				/* inclu une barre de navigation */
				include('../bareNav/barreNavAdmin.html');
			}else{
				/* inclu une barre de navigation */
				include('../bareNav/barreNav.html'); 
			}
		?>
		
				<h1 class="text-uppercase m-4 text-center">Recherche de Podcast</h1>
	<div class="margin cadre2">
		<form>
			<div class="form-row">
				<div class="col">
				<!-- Les zones de textes pour le titre et le nom de l'auteur du podcast -->
					<input type="text" class="form-control" placeholder="Titre du podcast"> 
				</div>
				<div class="col">
					<input type="text" class="form-control" placeholder="Nom de l'auteur du Podcast">
				</div>
			</div>
			<br/>
			<br/>
			<!-- Liste déroulante avec les possibles émissions 	 -->
			<select class="custom-select">
				<option selected>Choisissez à quel émission appartient le podcast</option>
				<option value="1">Emission 1</option>
				<option value="2">Emission 2</option>
				<option value="3">Emission 3</option>
			</select>
			
			<button type="button" class="btn btn-warning float-right btnpadding">Chercher	</button>
		</form>
	</div>
	<div class="margin">
		<table class="table table-striped ">
		  <thead>
			<tr>
			  <th scope="col">Nom du podcast</th>
			  <th scope="col">Date</th>
			  <th scope="col">Emission</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th scope="row">Nom du podcast</th>
			  <td>Date</td>
			  <td>Emission</td>
			</tr>
			<tr>
			  <th scope="row">Nom du podcast</th>
			  <td>Date</td>
			  <td>Emission</td>
			</tr>
			<tr>
			  <th scope="row">Nom du podcast</th>
			  <td>Date</td>
			  <td>Emission</td>
			</tr>
		  </tbody>
		</table>
	</div>

	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>		
	</body>

	
</html>