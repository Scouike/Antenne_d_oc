<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Emission</title>
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
		//declaration variable
		$emissionAjout = false;
		$nomPris = false;
		
		if (isset($_POST['uploadfiles'])){
			
			$sql = "SELECT nom FROM emission WHERE nom = ? ";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_POST['nomEmission']]);										 
			while ($row = $stmt->fetch()) {
				$nomPris = true;						
			}
		}
		
		
		if (isset($_POST['uploadfiles']) && !$nomPris){
			
			$interview = 0;
			$emissionInserer = true;
			if(isset($_POST['interview'])){
				$interview = 1;
			}
			//requéte
			$sql="INSERT INTO emission(id_theme, nom, texte, interview, archive) VALUES (?,?,?,?,0)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_POST['theme'],$_POST['nomEmission'],$_POST['text'],$interview]);
			
			$emissionAjout = true;
		}
	?>
	
	<h1 class="text-uppercase m-4 text-center">Ajout d'Emission</h1>
	
	<?php
		// si emission ajouté
		if ($emissionAjout){
			?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">L'ajout de l'émission a bien été effectuée !</h4>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>			
			<?php
		}
		
		
	?>
	
	<div class="cadre ">
		<div>
			<!-- titre -->
			<a class="a1 inactive underlineHover titre" href="../niveau1/AjoutPodcast.php">Ajouter Podcast</a>
			<a class="a1 inactive underlineHover titre" href="AjoutTheme.php">Ajouter Theme</a>
			<a class="a1 active titre" href="AjoutEmission.php">Ajouter Emission</a>
		</div>
	</div>
	</br>
	
	<div class="margin cadre2">
		<h2>Emission</h2>
		<form action="AjoutEmission.php" method="POST">
			
			<!--nom -->
			<div class="form-group row">
				<label for="nomEmission" class="col-sm-2 col-form-label">Nom Emission :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control  <?php if(isset($_POST['uploadfiles']) && $nomPris){ echo "is-invalid";} ?>"  id="nomEmission" name="nomEmission" placeholder="Nom de l'emission" maxlength="25" required>
					<?php
						if(isset($_POST['uploadfiles']) && $nomPris){
							echo '<div class="invalid-feedback">Le nom de ce théme est déjà pris</div>';
						}
					
					
					?>
				</div>
			</div>
			
			<!--texte -->
			<div class="form-group row">
				<label for="text" class="col-sm-2 col-form-label">Texte :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control <?php if(isset($_POST['uploadfiles']) && $nomPris){ echo "is-valid";}?>"  id="text" name="text" placeholder="Texte descriptif de l'emission" maxlength="100" <?php if(isset($_POST['uploadfiles']) && $nomPris){ echo 'value="'.$_POST['text'].'"';}?>required>
				
				</div>
			</div>


			<!--Theme -->
			<div class="form-group row">
				<label for="theme" class="col-sm-2 col-form-label">Theme :</label>
				<div class="col-sm-10">
					<select class="custom-select" name ="theme" required>
						<!-- tous les themes -->
						<?php
					

							$sql = "SELECT DISTINCT titre, id_theme FROM theme WHERE archive = 0 ORDER BY titre ";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
												 
							while ($row = $stmt->fetch()) {
								echo '<option value="'.$row['id_theme'].'" >'.$row['titre'].'</option>';
								
							}
						?>
					</select>
				</div>
			</div>
			
			<!-- interview -->
			<div class="form-group row">
				<div class="col-sm-2">Interview</div>
				<div class="col-sm-10">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="interview" name="interview" value="1">
						<label class="form-check-label" for="interview">
							Cocher la case si vous voulez que l'emission soit une interview
						</label>
					</div>
				</div>
			</div>
			
			
			
			<button type="submit" id="uploadfiles" name="uploadfiles" class="btn btn-primary">Ajouter Emission</button>
		</form>	
	</div>
	
	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>
</body>
</html>