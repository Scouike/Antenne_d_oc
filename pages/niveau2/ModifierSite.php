<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Modifier Site</title>
		<!-- Lien vers boostrap -->
		<link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../../fontawesome/css/all.css" rel="stylesheet" >
		
		<!-- Lien vers mon CSS -->
		<link href="../../css/styleLog.css" rel="stylesheet">
		
		<!-- script boostrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>

	<body>

		<!-- barre navigation -->
		<?php   
			if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				include('../bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==3) {
				/* inclu une barre de navigation */
				include('../bareNav/barreNavAdmin.html');
			}
		?>
	  
		<h1 class="text-uppercase m-4 text-center">Ajout de Thème et Emission	</h1>
	<div class="cadre ">
		<div>
			<!-- titre -->
			<a class="active titre" href="ModifierSite.php"> Ajout</a>
			<a class="inactive underlineHover titre" href="Supprimer.php">Supprimer </a>
			<a class="inactive underlineHover titre" href="Restaurer.php">Restaurer </a>
		</div>
	</div>
		
	<div class="margin cadre2">
		<h2>Theme</h2>
		<form name="Thème">
			<div class="form-row">
				<div class="col">
				<!-- Nom du boutton -->
					<label for="formImage">Image</label>
					<input type="file" class="form-control-file" id="formImage">
				</div>
				<div class="col">
				<!-- Les zones de textes pour le titre et le nom de l'auteur du podcast -->
					<input type="text" class="form-control" placeholder="Nom du thème à ajouter"> 
				</div>
			</div>
			<br/>
			<!-- Liste déroulante avec les possibles émissions 	 -->
			
			
			<button type="button" class="btn btn-success float-right btnpadding">Ajouter	</button>
		</form>
	</div>
	<div class="margin cadre2">
		<h2>Emission</h2>
		<form name="Emission">
			<div class="form-row">
				<div class="col">
				<!-- Nom du boutton -->
					<label for="formImage">Image</label>
					<input type="file" class="form-control-file" id="formImage">
				</div>
				<div class="col">
				<!-- Les zones de textes pour le titre et le nom de l'auteur du podcast -->
					<input type="text" class="form-control" placeholder="Nom de l'émission à ajouter"> 
				</div>
			</div>
			<br/>
			<!-- Liste déroulante avec les possibles émissions 	 -->
			
			
			<button type="button" class="btn btn-success float-right btnpadding">Ajouter	</button>
		</form>
	</div>
		

	
	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>

	  
	</body>	
</html>