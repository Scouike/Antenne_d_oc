<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajout Podcast</title>
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../../fontawesome/css/all.css" rel="stylesheet" >
</head>
<body>
	<!-- Barre de navigation --> 
		<?php   
			if (isset($_SESSION['level']) && $_SESSION['level']==1) {
				include('../bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				include('../bareNav/barreNavAdmin.html');
			}
		?>
	<h1 class="text-uppercase m-4 text-center">Ajout de Podcast</h1>
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
			<div class="form-group">
			<!-- zone de texte servant à la description du podcast -->
				<label for="TextDescription">Description du podcast</label>
				<textarea class="form-control" id="TextDescription" rows="3"></textarea>
			</div>
			<div class="row">
			<!-- Bouttons pour choisir les fichiers Image et Podcast -->
				<div class="col">
				<!-- Nom du boutton -->
					<label for="formImage">Image</label>
					<input type="file" class="form-control-file" id="formImage">
				</div>
				<div class="col">
				<!-- Nom du boutton -->
					<label for="formPodcast">Podcast</label>
					<input type="file" class="form-control-file" id="formPodcast">
				</div>
			</div>
			<br/>
			<!-- Liste déroulante avec les possibles émissions 	 -->
			<select class="custom-select">
				<option selected>Choisissez à quel émission appartient le podcast</option>
				<option value="1">Emission 1</option>
				<option value="2">Emission 2</option>
				<option value="3">Emission 3</option>
			</select>
			
			<button type="button" class="btn btn-success float-right btnpadding">Enregistrer	</button>
		</form>
	</div>


	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>
</body>
</html>