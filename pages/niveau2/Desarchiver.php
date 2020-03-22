<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Modifier Site</title>
		<link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
			
		<!-- Lien vers mon CSS -->
		<link href="../../css/style.css" rel="stylesheet">
			
		<!-- liens vers fontawesome -->
		<link href="../../fontawesome/css/all.css" rel="stylesheet" >
			

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

			
		<h1 class="text-uppercase m-4 text-center">Desarchiver</h1>
		
		<div class="cadre ">
			<div>
				<!-- titre -->
				<a class="a1 inactive underlineHover titre" href="Archiver.php">Archiver</a>
				<a class="a1 active titre" href="Desarchiver.php">Desarchiver</a>
				<a class="a1 inactive underlineHover titre" href="Modifier.php">Modifier</a>
			</div>
		</div>
		</br>
		
		<!--recherche -->
		<div class="margin cadre2">
			<form action="Desarchiver.php" method="POST">
				<div class="form-row">
					
					<div class="col">
					<!-- Les zones de textes pour le titre et le nom de l'auteur du podcast -->
						Texte :
						<input type="text" class="form-control" name = "texte" placeholder="Texte à rechercher dans l'objet à trouver" > 
					</div>
					<div class="col">
						Type d'objet :
						<select class="custom-select" name ="objet">
						
							<!-- tous les objet -->
							<option>Theme</option>
							<option>Emission</option>
							<option>Podcast</option>
						
						</select>
					</div>
				</div>
				
				<br/>
				<br/>			
				<button type="submit" class="btn-outline-success form-control ">Chercher</button>
				<br/>	
			</form>		
		</div>		
			
			


		<!-- Footer -->
		<?php   
			include('../footeur/footeurs.html'); 
		?>
	</body>
</html>