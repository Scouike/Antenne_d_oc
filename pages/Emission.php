<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Emission</title>
		<!-- Lien vers boostrap -->
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../fontawesome/css/all.css" rel="stylesheet" >
		
		<!-- script boostrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>

	<body>

		<!-- Barre de navigation --> 
		<?php   
			if (isset($_SESSION['level']) && $_SESSION['level']==1) {
				/* inclu une barre de navigation */
				include('bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				/* inclu une barre de navigation */
				include('bareNav/barreNavAdmin.html');
			}else{
				/* inclu une barre de navigation */
				include('bareNav/barreNav.html'); 
			}
		?>
		<h1 class="text-uppercase m-4 text-center">Emission</h1>	
	<div class="margin">
		<table class="table table-striped ">
			<tr>
			  <td>Nom du podcast</td>
			  <td>Date</td>
			  <td>Auteur</td>
			</tr>
			<tr>
			  <td>Nom du podcast</td>
			  <td>Date</td>
			  <td>Auteur</td>
			</tr>
			<tr>
			  <td>Nom du podcast</td>
			  <td>Date</td>
			  <td>Auteur</td>
			</tr>
		</table>
	</div>

	<!-- Footer -->
	<?php   
			include('footeur/footeurs.html'); 
	?>
		
	</body>
	
</html>