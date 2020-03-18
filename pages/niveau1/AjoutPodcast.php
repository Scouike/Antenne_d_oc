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
	<!-- Barre de navigation --> 
	<?php   
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
		
		//Declaration des chemin pour les fichier 
		if(!empty($_FILES['Podcast']['name'])){
			$targetDir = "../../podcast/";
			$PodcastName = basename($_FILES['Podcast']['name']);
			$ImageName = basename($_FILES['Image']['name']);
			$targetPodcastPath = $targetDir . $PodcastName;
			$targetImagePath = $targetDir . $ImageName;
			$PodcastType = pathinfo($targetPodcastPath,PATHINFO_EXTENSION);
			$ImageType = pathinfo($targetImagePath,PATHINFO_EXTENSION);
		}
		
		//initialisation fariable
		$son="NULL";
		$id_emission="NULL";
		$image="NULL";
		$texte="NULL";
		$attente = 1;
		$ajoutValide=false;
		
		
		if(isset($_POST["submit"])&&!empty($_FILES['Podcast']['name'])){
			//format Accepté
			$formatPodcast = array('mp3','ogg','wav');
			$formatImage = array('jpg','png','jpeg','gif','pdf');
			
			if(in_array($PodcastType, $formatPodcast)){
				if(!move_uploaded_file($_FILES['Podcast']['tmp_name'], $targetPodcastPath)){
					echo '<H2> Il y a eu un soucis lors de l\'upload';
				}else{
					$son=$targetPodcastPath;
					$sql = 'INSERT INTO podcast (son, id_emission, image,attente,  texte,dateArchive, dateCreation) 
					VALUES (?,?,?,?,?,?,?)';
				}
			}else{
				echo '<H2>Seuls les format mp3,ogg,wav sont acceptés, le fichier n\' a pas été upload</H2>';
			}
			
			//on determine l'id de l'emmision choisit
			if ($_POST["emission"]!=""){
				$idemission =  "SELECT id_emission FROM emission WHERE nom=?";
				$requete= $pdo->prepare($idemission);
				$requete->execute(array($_POST["emission"]));
				$id_emission= implode("|",$requete->fetch());
			}
			
			
			//on vérifie que le typed e l'image soit le bon 
			if(in_array($ImageType, $formatImage)||$ImageType==""){
				if(move_uploaded_file($_FILES['Image']['tmp_name'], $targetPodcastPath)){
					$image=$targetImagePath;
				}
			}else{
				echo '<H2>Seuls les formats jpg,png,jpeg,gif,pdf sont acceptés, le fichier n\' a pas été upload</H2>';
			}
			
			//on initialise le texte
			if ($_POST["Texte"]!=""){
				$texte=$_POST["Texte"];
			}
			
			//on determine si le podcat sera mis en attente ou pas
			if ($_SESSION == 2 || $_SESSION ==3){
				$attente = 0;
			}
			
			
			$dateArchive = date("Y-m-d", strtotime($_POST["dateArchiv"]));
			$dateCrea = date("Y-m-d", strtotime($_POST["dateCréa"]));	
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$son,$id_emission,$image,$texte,$attente,$dateArchive,$dateCrea]);
			
			$ajoutValide=true;
		}else{
			echo'<H2>Veuillez sélectionner un podcast.</H2>';
		}
		?>
	<h1 class="text-uppercase m-4 text-center">Ajout de Podcast</h1>
	<div class="margin cadre2">
		<form action="AjoutPodcast.php"method="POST" enctype="multipart/form-data">
			<div class="form-row">
				<div class="col">
					<label >Date de création:</label>
					<input type="date" name="dateCréa" class="form-control" placeholder="Date du Podcast"
					value="<?php echo date("Y-m-d",time()) ;?>">
				</div>
				<div class="col">
					<label >Date d'archivage	:</label>
					<input type="date" name="dateArchiv" class="form-control" placeholder="Date du Podcast"
					value="<?php echo date("Y-m-d",strtotime("+1 year")) ;?>"
					min ="<?php echo date("Y-m-d",strtotime("+1 year")) ;?>">
				</div>
			</div>
			<br/>
			<div class="form-group">
			<!-- zone de texte servant à la description du podcast -->
				<label for="TextDescription">Texte pour le podcast</label>
				<textarea class="form-control" id="TextDescription" name="Texte" rows="3"></textarea>
			</div>
			<div class="row">
			<!-- Bouttons pour choisir les fichiers Image et Podcast -->
				<div class="col">
				<!-- Nom du boutton -->
					<label for="formImage">Image</label>
					<input type="file" name ="Image" class="form-control-file" id="formImage">
				</div>
				<div class="col">
				<!-- Nom du boutton -->
					<label for="formPodcast">Podcast</label>
					<input required type="file" name="Podcast" class="form-control-file" id="formPodcast">
				</div>
			</div>
			<br/>
			<!-- Liste déroulante avec les possibles émissions 	 -->
			<label>Choix émission du podcast</label>
			<select name="emission" class="custom-select" autocomplete="on" required>
				<?php
				$sql="SELECT DISTINCT nom FROM emission";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch()){
					echo'<option value="'.$row["nom"].'">'.$row["nom"].'</option>';
				}
				?>
			</select>
			<?php
					if ($ajoutValide){
						
						echo "Le Podcast a été upload correctement";
					}
			?>
			<input type="submit" name="submit" value="Envoyer" class="btn btn-success float-right btnpadding">
		</form>
	</div>
	<script src="jquery.min.js" type="text/javascript"></script>
    <script src="dropzone.js" type="text/javascript"></script>
	<script src="configDropZone.js" type="text/javascript"></script>

	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>
</body>
</html>
