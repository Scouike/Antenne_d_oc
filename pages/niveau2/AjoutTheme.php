<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Theme</title>
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
		

		
		<!-- Lien vers mon CSS -->
		<link href="../../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../../fontawesome/css/all.css" rel="stylesheet" >
		
		<!-- pour la drop zone -->
		<link href="../../DropZone/dropzone.css" rel="stylesheet" type="text/css">
        <link href="../../DropZone/style.css" rel="stylesheet" type="text/css">
		
		<!-- script boostrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
	<!-- Barre de navigation --> 
	<?php   
		if (isset($_SESSION['level']) && $_SESSION['level']==2) {
			include('../bareNav/barreNavAnimateur.html');
		}else if (isset($_SESSION['level']) && $_SESSION['level']==3) {
			/* inclu une barre de navigation */
			include('../bareNav/barreNavAdmin.html');
		}
		
		if(isset($_POST['nomTheme'])){
			echo '<h1>'.$_POST['nomTheme'].'</h1>';
		}
		
		
		if (!empty($_FILES)) {
			echo '<h1>'.$_POST["nomTheme"].'</h1>';
			$target_dir = "../../Theme/";

			// Upload file
			$target_file = $target_dir . basename($_FILES["file"]["name"]);

			$msg = "";
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			  $msg = "Successfully uploaded";
			}else{ 
			  $msg = "Error while uploading";
			}
				

		}
		
		
		
		
	?>
	
	<h1 class="text-uppercase m-4 text-center">Ajout de Theme</h1>
	
	<div class="cadre ">
		<div>
			<!-- titre -->
			<a class="a1 inactive underlineHover titre" href="../niveau1/AjoutPodcast.php">Ajouter Podcast</a>
			<a class="a1 active titre" href="AjoutTheme.php">Ajouter Theme</a>
			<a class="a1 inactive underlineHover titre" href="AjoutEmission.php">Ajouter Emission</a>
		</div>
	</div>
	</br>
	
	<div class="margin cadre2 ">

		<h2>Theme </h2>
		<!-- la drop zone -->
		<form  action="AjoutTheme.php" class="dropzone" id="laDropZone" method="POST">
            <!--nom -->
			<div class="form-group row" id="aDeplacer">
				<label for="nomTheme" class="col-sm-3 col-form-label">Nom Theme :</label>
				<div class="col-sm-9">
					<input type="text" class="form-control"  id="nom" name="nomTheme" placeholder="Nom du Theme" maxlength="25" required>
					
				</div>
			</div>
        </form>
        <input type="button" id='uploadfiles' value='Ajouter Theme' >
	</div>
	

	<!-- Script -->
	<script>
		$('#laDropZone').after($('#aDeplacer'));
	</script>
    <script src="../../DropZone/jquery.min.js" type="text/javascript"></script>
    <script src="../../DropZone/dropzone.js" type="text/javascript"></script>
	<script src="../../DropZone/configDropZoneTheme.js" type="text/javascript"></script>
	
	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>

</body>
</html>