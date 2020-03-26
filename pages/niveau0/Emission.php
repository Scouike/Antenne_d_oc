<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Emission</title>
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

		 
		<?php  
		
			//Barre de navigation 
			if (isset($_SESSION['level']) && $_SESSION['level']==1) {
				include('../bareNav/barreNavUtilisateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				/* inclu une barre de navigation */
				include('../bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==3) {
				/* inclu une barre de navigation */
				include('../bareNav/barreNavAdmin.html');
			}else{
				/* inclu une barre de navigation */
				include('../bareNav/barreNav.html'); 
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
			
			//fonction affichant les emissions
			function affichageEmission($id_emission,$interview,$nom,$texte){
				$type = 'Emission';
				if($interview == 1){
					$type = 'Interview';
				}
				echo	'<tr>
							<th scope="row">'.$type.'</th>
							<td>'.$nom.'</td>
							<td><a href="/ProjetRadioGit/ProjetRadioPhp/pages/niveau0/Podcast.php?id_Emission='.$id_emission.'">'.$texte.'</a></td>
						</tr>';
		
			}
			
			//declarationVariable
			$idThemePresentURL = false;
			$idThemeValide = false;
			$nomTheme = "";
			
			//verif parametre
			if(isset($_GET['id_theme'])){
				$idThemePresentURL = true;
			}
			
			//verif que le theme existe
			if($idThemePresentURL){
				$sql = "SELECT * FROM theme WHERE id_theme = ?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$_GET['id_theme']]);
				while ($row = $stmt->fetch()) {	
					$idThemeValide = true;
					$nomTheme = $row['titre'];
				}
			}
			
			if(!$idThemePresentURL){
				//message d'erreur on ne se balade pas dans le site en utilisant l'URL
				echo '<div class="alert alert-danger" role="alert">
					  <h4 class="alert-heading">Attention!</h4>
					  <p>Ne vous baladais pas sur le site en utilisant la barre de navigation cela peut vous empécher de profitter pleinement de l\'expérience que nous vous proposons</p>
					  <hr>
					  <p class="mb-0">Ce message s\'applique à tous le site </p>
					</div>';
				
			}else if (!$idThemeValide){
				//message d'erreur ne Theme que vous cherchais n'est plus accessible
				echo '<div class="alert alert-warning" role="alert">
					  <h4 class="alert-heading">Attention!</h4>
					  <p>Atention le liens que vous utilisais n\'est plus valide</p>
					  <hr>
					  <p class="mb-0">Nous sommes désolé de la géne ocasionné</p>
					</div>';
			}else{

		?>
		
		<h1 class="text-uppercase m-4 text-center">Emissions du Theme : <?php echo $nomTheme;?></h1>
		<!-- Differentes Emission Disponible -->
		<?php
			echo	'<div class="cadre2">
						<table class="table table-striped ">
							<thead>
								<tr>
									<th scope="col">Type</th>
									<th scope="col">Nom</th>
									<th scope="col">Descriptif</th>
								</tr>
							</thead>';
					//affichage des Emissions
					$sql = "SELECT * FROM emission WHERE archive = 0 AND id_theme = ?";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([$_GET['id_theme']]);
					while ($row = $stmt->fetch()) {
						
						affichageEmission($row['id_emission'],$row['interview'],$row['nom'],$row['texte']);
						
					}
					echo '		</table>
							</div>';			
		
		?>
		<!-- Footer -->
		<?php  
			}
			include('../footeur/footeurs.html'); 
		?>
		
	</body>
	
</html>
