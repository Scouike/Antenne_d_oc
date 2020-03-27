<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajout Podcast</title>
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../css/style.css" rel="stylesheet">
		
		<link href="dropzone.css" rel="stylesheet" type="text/css">
		<!-- liens vers fontawesome -->
		<link href="../../fontawesome/css/all.css" rel="stylesheet" >
		
		<!-- script boostrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
	<?php   
		//redirection des utilisateurs qui ne devrais pas étre à cette endroits
		if (!isset($_SESSION['level']) || $_SESSION['level'] < 1){
			header('Location: http://localhost/ProjetRadioGit/ProjetRadioPhp/index.php');
			Exit();
		}
	
		//barre de navigation
		if (isset($_SESSION['level']) && $_SESSION['level']==1) {
			include('../bareNav/barreNavUtilisateur.html');
		}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
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
		//on determine le niveau de la session_cache_expire
		$attente = 1;
		if($_SESSION['level'] >= 2){
			$attente = 0;
		}
		
		
		//initialisation variable
		$uploaddir = '../../podcast/';
		$formatPodcast = array('audio/mp3','audio/ogg','audio/wav');
		$formatImage = array('image/jpg','image/png','image/jpeg','image/gif');
		$formatImageCorecte = true;
		$formatPodcastCorecte = false;
		$maxTaille = 1000000000; //1GB
		$tailleImageValid = true;
		$taillePodcastValid = false;
		$fichierSonVide = false;
		$podcastAjout = false;
		
		
		if(isset($_POST['submit'])){
			$datenonValide = true;
			//echo '<h1>formulaire detecté</h1>';
			$dateCrea = $_POST['dateCrea'];
			$dateArch = $_POST['dateArchiv'];
			//verif que la date d'archivage soit renseigné
			if ($dateArch==""){
				$dateArch = date("Y-m-d",strtotime("+10 year"));
				$datenonValide = false;
				
				//echo '<h1>date archivage null</h1>';
			}else if(strtotime($dateArch)>strtotime($dateCrea)){
				$datenonValide = false;
			}
			//echo '<h1>date archivage  detecté</h1>';
			
			//verif du text
			$text = $_POST['texte'];
			if($text==""){
				$text="NULL";
				//echo '<h1>texte null detecté</h1>';
			}
			//echo '<h1>texte</h1>';
			
			//si image alors il doit respecter des regles
			if (!empty($_FILES['image']['name'])){
				//echo '<h1>image detecté</h1>';
				$formatImageCorecte = false;
				$tailleImageValid = false;
				
				//on teste si le fichier est dans un bon format				
				if(in_array($_FILES['image']['type'], $formatImage)){
					$formatImageCorecte = true;
				}
				
				//on teste la taille
				if($maxTaille >= $_FILES['image']['size'] ){
					$tailleImageValid = true;
				}
				
				//on genere un nom valide à l'image du podcast
				do{
					$nomFichierInvalide = true;
					$clef = md5(microtime(TRUE)*100000);
					$cheminBDImage ="/ProjetRadioGit/ProjetRadioPhp/podcast/".$clef.$_FILES['image']['name'];
					$uploadfileImage = $uploaddir.$clef.$_FILES['image']['name'];
					$sql = "SELECT * FROM podcast";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					while ($row = $stmt->fetch()) {
						if ($cheminBDImage == $row['image'] || $cheminBDImage == $row['son']){
							$nomFichierInvalide = false;
							$cheminBDImage ="/ProjetRadioGit/ProjetRadioPhp/podcast/".$clef.$_FILES['image']['name'];
							$uploadfileImage = $uploaddir.$clef.$_FILES['image']['name'];
						}
					}
				}while(!$nomFichierInvalide);
					
			}else{
			//	echo '<h1>image non detecté</h1>';
				$cheminBDImage = "NULL";
			}
			
			//verif sur le son
			if (!empty($_FILES['podcast']['name'])){
				//echo '<h1>son detecté</h1>';
				
				//on teste si le fichier est dans un bon format
				if(in_array($_FILES['podcast']['type'], $formatPodcast)){
					$formatPodcastCorecte = true;
				}
				
				//on teste la taille
				if($maxTaille >= $_FILES['podcast']['size'] ){
					$taillePodcastValid = true;
				}
				
				//on genere un nom valide à l'image du podcast
				do{
					$nomFichierInvalide = true;
					$clef = md5(microtime(TRUE)*100000);
					$cheminBDPodcast ="/ProjetRadioGit/ProjetRadioPhp/podcast/".$clef.$_FILES['podcast']['name'];
					$uploadfilePodcast = $uploaddir.$clef.$_FILES['podcast']['name'];
					$sql = "SELECT * FROM podcast";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					while ($row = $stmt->fetch()) {
						if ($cheminBDPodcast == $row['image'] || $cheminBDImage == $row['son']){
							$nomFichierInvalide = false;
							$cheminBDPodcast ="/ProjetRadioGit/ProjetRadioPhp/podcast/".$clef.$_FILES['podcast']['name'];
							$uploadfilePodcast = $uploaddir.$clef.$_FILES['podcast']['name'];
						}
					}
				}while(!$nomFichierInvalide);
					
			}else{
				$fichierSonVide = true;	
				//echo '<h1>son non detecté</h1>';
			}
			//echo $_POST['emission'].'    '.$_SESSION['id'].'     '.$cheminBDImage.'    '.$cheminBDPodcast.'    '.$text.'    '.$attente.'    '.$dateArch.'     '.$dateCrea;
			if(!$fichierSonVide && $formatImageCorecte && $tailleImageValid && $taillePodcastValid && $formatPodcastCorecte && !$datenonValide){
				if($cheminBDImage=="NULL"){
					if(move_uploaded_file($_FILES['podcast']['tmp_name'], $uploadfilePodcast)){
							$sql = "INSERT INTO podcast(id_emission, id_utilisateur, image, son, texte, archive, attente, dateArchive, dateCreation) VALUES (?,?,?,?,?,0,?,?,?)";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$_POST['emission'],$_SESSION['id'],$cheminBDImage,$cheminBDPodcast,$text,$attente,$dateArch,$dateCrea]);
							$podcastAjout = true;
					}
					
				}else{
					if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfileImage)) {
						if(move_uploaded_file($_FILES['podcast']['tmp_name'], $uploadfilePodcast)){
							$sql = "INSERT INTO podcast(id_emission, id_utilisateur, image, son, texte, archive, attente, dateArchive, dateCreation) VALUES (?,?,?,?,?,0,?,?,?)";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$_POST['emission'],$_SESSION['id'],$cheminBDImage,$cheminBDPodcast,$text,$attente,$dateArch,$dateCrea]);
							$podcastAjout = true;
						}
					}
				}
			}
			
			
			
			
			
			
		}

	
			
		
		?>
		
		
	<h1 class="text-uppercase m-4 text-center">Ajout de Podcast</h1>
	
	<?php 
		if (isset($_SESSION['level']) && $_SESSION['level']>=2 ){
			
	?>
	
	<div class="cadre ">
		<div>
			<!-- titre -->
			<a class="a1 active titre" href="AjoutPodcast.php">Ajouter Podcast</a>
			<a class="a1 inactive underlineHover titre" href="../niveau2/AjoutTheme.php">Ajouter Theme</a>
			<a class="a1 inactive underlineHover titre" href="../niveau2/AjoutEmission.php">Ajouter Emission</a>
		</div>
	</div>
	</br>
	
		<?php } ?>
	
	
	<?php
		//message reussite ajout de Podcast
		if ($podcastAjout){
			?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">Le Podcast a bien été ajouté!</h4>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>			
			<?php
		}
		
	?>	
	
	<div class="alert alert-primary alert-dismissible fade show" role="alert">
		<strong>Attention!</strong> Si vous voulez que votre podcast ne soit pas archivé veuillez suprimer toutes valeur du champs d'archivage.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="margin cadre2">
		<form action="AjoutPodcast.php" method="POST" enctype="multipart/form-data">
		
			<!-- les date de mise en ligne et d'archivage -->
			<div class="form-row">
				<div class="col">
					<label >Date de mise en ligne:</label>
					<input type="date" name="dateCrea" class="form-control <?php if(isset($_POST['dateCrea']) && $datenonValide){ echo "is-invalid"; }?>" placeholder="Date du Podcast"
					value="<?php if(!isset($_POST['dateCrea']) || (isset($_POST['dateCrea']) && $datenonValide)){echo date("Y-m-d",time());}else if(!$podcastAjout){ echo $_POST['dateCrea'];}?>" min ="<?php echo date("Y-m-d",time()) ;?>"required>
				</div>
				<div class="col">
					<label >Date d'archivage	:</label>
					<input type="date" name="dateArchiv" class="form-control  <?php if(isset($_POST['dateArchiv']) && $datenonValide){ echo "is-invalid"; }?>" placeholder="Date du Podcast"
					value="<?php if(!isset($_POST['dateArchiv']) || (isset($_POST['dateArchiv']) && $datenonValide)){ echo date("Y-m-d",strtotime("+1 year")); }else if(!$podcastAjout){ echo $_POST['dateArchiv']; }?>"
					min ="<?php echo date("Y-m-d",strtotime("+1 day")) ;?>">
				</div>
			</div>
			<?php
				if(isset($_POST['submit']) && $datenonValide){
					echo '</br><div class="alert alert-danger" role="alert">Atention la date de mise en ligne ne peut pas être postérieur à la date d\'archivage</div>';
				}
			?>
			<br/>
			
			<!-- texte pour le podcast -->
			<div class="form-group">
				<label for="TextDescription">Texte pour le podcast :</label>
				<textarea class="form-control" id="TextDescription" name="texte" rows="3"><?php if(isset($_POST['texte']) && !$podcastAjout){echo $_POST['texte'];}?></textarea>
			</div>
			
			<br/><br/>
			
			<!-- les fichiers -->
			<div class="row">
				<!-- image -->
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="dropzone">
						<input type="file" name="image" id="image" class="form-control-file" >
					</div>
					<p id="textDropZoneImg"  class="textDropZone">Déposer les images de vos podcasts ici</p>
					<?php
						if(!$formatImageCorecte){
						echo '<div class="alert alert-danger" role="alert">Le format n\'est pas correct, les types de fichiers audio accéptés sont : jpg, png, jpeg, gif</div>';
						}
						if(!$tailleImageValid){
							echo '<div class="alert alert-danger" role="alert">Taille du fichier trop volumineuse, taille maximal = 1GB</div>';
						}

					?>
				</div>
				
						
				<!-- podcast -->
				<div class=" col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<div class="dropzone">
						<input required type="file" name="podcast" id="podcast" class="form-control-file" >
					</div>
					<p id="textDropZonePodcast" class="textDropZone" >Déposer vos fichiers audio ici</p>
					<?php
				
						if(isset($_POST['submit']) && !$formatPodcastCorecte){
							echo '<div class="alert alert-danger" role="alert">Le format n\'est pas correct, les types d\'images accéptés sont : mp3, ogg, wav</div>';
						}
						if(isset($_POST['submit']) && !$taillePodcastValid){
							echo '<div class="alert alert-danger" role="alert">Taille du fichier trop volumineuse, taille maximal = 1GB</div>';
						}
						if(isset($_POST['submit']) && $fichierSonVide){
							echo '<div class="alert alert-danger" role="alert">Aucun fichier detecté</div>';
						}
					
					?>
				</div>
				
			</div>
			

			
			<!-- Liste déroulante avec les possibles émissions 	 -->
			<label>Choix émission du podcast</label>
			<select name="emission" class="custom-select" required>
				<?php
				$sql="SELECT * FROM emission ORDER BY nom";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch()){
					if (isset($_POST['emission']) && $_POST['emission']==$row["id_emission"] && !$podcastAjout){		
						echo'<option value="'.$row["id_emission"].'" selected>'.$row["nom"].'</option>';
					}else{
						echo'<option value="'.$row["id_emission"].'">'.$row["nom"].'</option>';
					}
				}
				?>
			</select>
			<?php

			?>
			<input type="submit" name="submit" value="Ajouter Podcast" class="btn btn-success btn-block marge20Top">
		</form>
	</div>
	
	<!--script -->
	<script>
		$(document).ready(function(){
		  $('#image').change(function () {
			$('#textDropZoneImg').text(this.files.length + " fichier a été  ajouté");
		  });
		  $('#podcast').change(function () {
			$('#textDropZonePodcast').text(this.files.length + " fichier a été  ajouté");
		  });
		});
	</script>
	<script src="../../js/jquery.min.js" type="text/javascript"></script>

	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>
</body>
</html>
