<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Rubriques</title>
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
			
			//fonction qui determine qui affiche un podcast
			function affichagePodcast($date, $idemission, $podcast, $texte, $image){
				global $pdo;
				$date =  date("d-m-Y",strtotime($date));
				//recuperation du nom de l'emission
				$sql = "SELECT nom FROM emission WHERE id_emission = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$idemission]);	
				while ($row = $stmt->fetch()) {
					$nomemission = $row['nom'];
				}
				
			
				//dertermination du type de podcast
				if ($image != "NULL" && $texte != "NULL" ){
					
					//affichage d'un podcast avec une image et un texte
					echo	'<div class=" cadre3 decalageGauche">
							<div class="row">
								<div class="col cadre_image ">
									<img src="'.$image.'" class="illustration" alt="Image Emission">
								</div>
								<div class="col ">
									<div class="row">
										<div class="col description"><p>'.$texte.'</p></div>
									</div>	
									<div class="row">
										<div class="col"><figure>
											<figcaption>Ecouter le podcast :</figcaption><br/>
											<audio controls src="'.$podcast.'">Your browser does not support the<code>audio</code> element.</audio><br/><br/>
											<a href="'.$podcast.'"  class="btn btn-outline-success">Télécharger</a>
											</figure>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">date de mise en ligne : '.$date.' </div>
								<div class="col">Emission : '.$nomemission.'</div>
							</div>
						</div>';
					
				}else if($image == "NULL" && $texte == "NULL"){
					//affichage d'un podcast sans image et sans texte
					echo   '<div class=" cadre3 decalageGauche">
								<div class="row">
									<div class="col">				
										<div class="row">
											<div class="col"><figure>
												<figcaption>Ecouter le podcast :</figcaption><br/>
												<audio controls src="'.$podcast.'">Your browser does not support the<code>audio</code> element.</audio><br/><br/>
												<a href="'.$podcast.'"  class="btn btn-outline-success">Télécharger</a>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">date de mise en ligne : '.$date.' </div>
									<div class="col">Emission : '.$nomemission.'</div>
								</div>
							</div>';
					
				}else if($image != "NULL"){
					//affichage d'un podcast avec une image mais pas de texte
					echo	'<div class=" cadre3 decalageGauche">
								<div class="row">
									<div class="col cadre_image">
										<img src="'.$image.'" class="illustration" alt="Image Emission">
									</div>
									<div class="col">
										<div class="row">
											<div class="col"><figure>
												<figcaption>Ecouter le podcast :</figcaption><br/>
												<audio controls src="'.$podcast.'">Your browser does not support the<code>audio</code> element.</audio><br/><br/>
												<a href="'.$podcast.'"  class="btn btn-outline-success">Télécharger</a>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">date de mise en ligne : '.$date.' </div>
									<div class="col">Emission : '.$nomemission.'</div>
								</div>
							</div>';
					
				}else{
					//affichage d'un podcast avec un texte et pas d'image
					echo	'<div class=" cadre3 decalageGauche">
								<div class="row">
									<div class="col">
										<div class="row">
											<div class="col description"><p>'.$texte.'<p></div>
										</div>
										
										<div class="row">
											<div class="col"><figure>
												<figcaption>Ecouter le podcast :</figcaption><br/>
												<audio controls src="'.$podcast.'">Your browser does not support the<code>audio</code> element.</audio><br/><br/>
												<a href="'.$podcast.'"  class="btn btn-outline-success">Télécharger</a>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">date de mise en ligne : '.$date.' </div>
									<div class="col">Emission : '.$nomemission.'</div>
								</div>
							</div>';
				}
				
			}
			
			//declarationVariable
			$idEmissionPresentURL = false;
			$idEmissionValide = false;
			$nomEmission = "";
			
			//verif parametre
			if(isset($_GET['id_Emission'])){
				$idEmissionPresentURL = true;
			}
			
			//verif que le theme existe
			if($idEmissionPresentURL){
				$sql = "SELECT * FROM emission WHERE id_emission = ?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$_GET['id_Emission']]);
				while ($row = $stmt->fetch()) {	
					$idEmissionValide = true;
					$nomEmission = $row['nom'];
				}
			}
			
			if(!$idEmissionPresentURL){
				//message d'erreur on ne se balade pas dans le site en utilisant l'URL
				echo '<div class="alert alert-danger" role="alert">
					  <h4 class="alert-heading">Attention!</h4>
					  <p>Ne vous baladais pas sur le site en utilisant la barre de navigation cela peut vous empécher de profitter pleinement de l\'expérience que nous vous proposons</p>
					  <hr>
					  <p class="mb-0">Ce message s\'applique à tous le site </p>
					</div>';
				
			}else if (!$idEmissionValide){
				//message d'erreur ne Theme que vous cherchais n'est plus accessible
				echo '<div class="alert alert-warning" role="alert">
					  <h4 class="alert-heading">Attention!</h4>
					  <p>Atention le liens que vous utilisais n\'est plus valide</p>
					  <hr>
					  <p class="mb-0">Nous sommes désolé de la géne ocasionné</p>
					</div>';
			}else{

		?>
		
		<h1 class="text-uppercase m-4 text-center">Podcasts de l'Emission : <?php echo $nomEmission;?></h1>
		<!-- Differentes Emission Disponible -->
		<?php
				
			//affichage des podcast
			$sql = "SELECT * FROM podcast WHERE archive = 0 AND id_emission = ? AND attente = 0 AND dateCreation <= NOW()";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_GET['id_Emission']]);
			while ($row = $stmt->fetch()) {	
				affichagePodcast($row['dateCreation'], $row['id_emission'], $row['son'], $row['texte'], $row['image']);
			}			

		?>
		<!-- Footer -->
		<?php  
			}
			include('../footeur/footeurs.html'); 
		?>
		
	</body>

	
</html>
