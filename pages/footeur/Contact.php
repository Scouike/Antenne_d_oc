<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">	
	<head>
		<meta charset="utf-8">
		<title>Contact</title>
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
			if (isset($_SESSION['type']) && $_SESSION['type']=="animateur") {
				include('../bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['type']) && $_SESSION['type']=="admin") {
				include('../bareNav/barreNavAdmin.html');
			}else{
				include('../bareNav/barreNav.html'); 
			}
		?>
		
		<div class="container ">
			<div class="row">
				<div class="col-md-12 cadreAvecBordure">
					<h1> Présentation des contacts généraux</h1>
				</div>
				<div class="col-md-12 cadreAvecBordure">
					<h2> Contacts et précisions pour les inscriptions</h2>
				</div>
			</div>
		</div>
		

	<?php   
			include('footeurs.html'); 
	?>	  
	</body>
</html>