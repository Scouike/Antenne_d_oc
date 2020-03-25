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
		
		//connexion à la bd
		$host = 'localhost';
		$db   = 'bdradio';
		$user = 'root';
		$pass = 'root';
		$charset = 'utf8mb4';
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		try {
			 $pdo = new PDO($dsn, $user, $pass, $options);
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
		//declaration des variable
		$maxTaille = 5000000; //5mb
		$nomThemeDisponible = true;
		$fichierPresent = true;
		$formatBon = true;
		$tailleCorrecte =true;
		$nomFichierInvalide = false;
		$themeAjouter = false;
		
		//verification du nom de theme si il est déjà pris
		if(isset($_POST['nomTheme'])){	
			$fichierPresent = false;
			//on verifie dans la table que le nom n'est déja pas pris
			$sql = "SELECT * FROM theme";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch()) {
				if ($_POST['nomTheme'] == $row['titre']){
					$nomThemeDisponible = false;
				}
			}	
		}
		
		
		if (!empty($_FILES['imageTheme']['name']) && $nomThemeDisponible) {
			$fichierPresent = true;
			$formatBon =false;
			$tailleCorrecte = false;
			//Destination du fichier
			$uploaddir = '../../Theme/';
			
			//on teste si le fichier est dans un bon format
			$formatImage = array('image/jpg','image/png','image/jpeg','image/gif'); //format autorisé
			if(in_array($_FILES['imageTheme']['type'], $formatImage)){
				$formatBon = true;
			}
			
			//on teste la taille
			if($maxTaille >= $_FILES['imageTheme']['size'] ){
				$tailleCorrecte = true;
			}
			
			//on genere un nom valide à l'image du podcast
			do{
				$nomFichierInvalide = true;
				$clef = md5(microtime(TRUE)*100000);
				$cheminBD ="/ProjetRadioGit/ProjetRadioPhp/Theme/".$clef;
				$uploadfile = $uploaddir.$clef;
				$sql = "SELECT * FROM theme";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch()) {
					if ($cheminBD == $row['image']){
						$nomFichierInvalide = false;
						$cheminBD ="/ProjetRadioGit/ProjetRadioPhp/Theme/".$clef;
						$uploadfile = $uploaddir.$clef;
					}
				}
			}while(!$nomFichierInvalide);
			
			if($tailleCorrecte && $formatBon){
				if (move_uploaded_file($_FILES['imageTheme']['tmp_name'], $uploadfile)) {
					$sql = "INSERT INTO theme ( image, titre, archive) VALUES (?,?,0)";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([$cheminBD,$_POST['nomTheme']]);
					$themeAjouter = true;
				}
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
	
	<?php
		//message reussite ajout de theme
		if ($themeAjouter){
			?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">Le Théme à bien été ajouter!</h4>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>			
			<?php
		}
		
	?>	
	
	<div class="margin cadre2 ">

		<h2>Theme </h2>
		<!-- la drop zone -->
		<form  action="AjoutTheme.php"  method="POST"  enctype="multipart/form-data">
			<!-- la zone de drop -->
			<div class="dropzone">
				<input type="file"  name="imageTheme" >
			</div>
			<p id="textDropZone">Déposer vos fichier ou cliquer ici</p>
			<?php
				
				if(!$formatBon){
					echo '<div class="alert alert-danger" role="alert">Le format n\'est pas corecte les type d\'image accépté sont : jpg, png, jpeg, gif</div>';
				}
				if(!$tailleCorrecte){
					echo '<div class="alert alert-danger" role="alert">Taille du fichier trop volumineuse, taille maximum = 5mb</div>';
				}
				if(!$fichierPresent){
					echo '<div class="alert alert-danger" role="alert">Aucun fichier detecté</div>';
				}
			
			?>
            <!--nom -->
			<div class="form-group row" id="aDeplacer">
				<label for="nomTheme" class="col-sm-3 col-form-label">Nom Theme :</label>
				<div class="col-sm-9">
					<input type="text" class="form-control <?php if(isset($_POST['nomTheme']) && !$nomThemeDisponible){ echo "is-invalid";} ?>"  id="nom" name="nomTheme" placeholder="Nom du Theme" maxlength="25" required>
					<?php	
						if (isset($_POST['nomTheme']) && !$nomThemeDisponible ){
							echo '<div class="invalid-feedback">Le Nom du théme que vous voulez ajouter est déjà pris</div>';
						}
					?>
				</div>
			</div>
			
			<button type="submit" class="btn btn-primary">Ajouter Theme</button>
        </form>
        
	</div>
	

	<!-- Script -->
	<script>
		$(document).ready(function(){
		  $('form input').change(function () {
			$('#textDropZone').text(this.files.length + " fichier à été  ajouté");
		  });
		});
	</script>
    <script src="../../js/jquery.min.js" type="text/javascript"></script>
    <script src="../../DropZone/dropzone.js" type="text/javascript"></script>
	<script src="../../DropZone/configDropZoneTheme.js" type="text/javascript"></script>
	
	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>

</body>
</html>