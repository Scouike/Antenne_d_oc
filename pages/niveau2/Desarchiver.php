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
			
			
			
			//desarchivage d'un Podcast dans la bd
			function desarchivagePodcast($id_podcast){
				global $pdo;
				
				$sql = "UPDATE podcast SET archive = 0 WHERE id_podcast = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_podcast]);					

				$sql = "SELECT id_emission FROM podcast WHERE id_podcast = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_podcast]);	
				while ($row = $stmt->fetch()) {
					desarchivageEmission($row['id_emission']);
				}				
			}
			
			//desarchivage d'une Emission dans la bd
			function desarchivageEmission($id_emission){
				global $pdo;
				
				$sql = "UPDATE emission SET archive = 0 WHERE id_emission = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_emission]);					
				
				$sql = "SELECT id_theme FROM emission WHERE id_emission = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_emission]);	
				while ($row = $stmt->fetch()) {
					desarchivageTheme($row['id_theme']);
				}
								
			}
			
			//desarchivage d'un Theme dans la bd
			function desarchivageTheme($id_theme){
				global $pdo;
				
				$sql = "UPDATE theme SET archive = 0 WHERE id_theme = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_theme]);					
				
			}
			
			//fonction verifiant la rechercher par txt
			function trieParTxt($txtVerif,$txtARespecter){
				$txtCorrespondant = false;
				
				if( preg_match('#'.$txtARespecter.'#',$txtVerif)) {
					$txtCorrespondant = true;
				}
				
				return $txtCorrespondant;
			}
			
			//fonction affichant les Theme
			function affichageTheme($image,$titre,$idTheme){
				echo'<div class="col-md-4 col-sm-6">
						<div class="polaroid">
							<a href="/ProjetRadioGit/ProjetRadioPhp/pages/niveau0/Emission.php?titre='.$titre.'">
								<div class="image" style="background-image:url('.$image.')">
									<img src="'.$image.'" class="center" alt="Image du thème : '.$image.'"/>
								</div>
								<div class="polatxt">
									<p>'.$titre.'</p>
								</div>
							</a>
							<form action="Desarchiver.php" method="POST">
								<input id="id_Theme" name="id_Theme" type="hidden" value="'.$idTheme.'">
								<input id="objet" name="objet" type="hidden" value="'.$_POST['objet'].'">
								<input id="texte" name="texte" type="hidden" value="'.$_POST['texte'].'">
								<button type="submit" class="btn btn-outline-success btn-block " name="Desarchiver" value="1" >Desarchiver</button>
							</form>
							</br>
						</div>
					</div>';				
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
							<td><a href="/ProjetRadioGit/ProjetRadioPhp/pages/niveau0/Podcast.php?id_Emission='.$id_emission.'&nom='.$nom.'">'.$texte.'</a></td>
							<td>
								<form action="Desarchiver.php" method="POST">
									<input id="objet" name="objet" type="hidden" value="'.$_POST['objet'].'">
									<input id="texte" name="texte" type="hidden" value="'.$_POST['texte'].'">
									<input id="id_Emission" name="id_Emission" type="hidden" value="'.$id_emission.'">
									<button type="submit" class="btn btn-outline-success" name="Desarchiver" value="1" >Desarchiver</button>
								</form>
							</td>
						</tr>';
			
						
						
						
							
			}
			
			//fonction affichant les podcast
			function affichagePodcast($date, $idemission, $podcast, $texte, $image, $idPodcast){
				global $pdo;
				
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
												<form action="Desarchiver.php" method="POST">
													<input id="objet" name="objet" type="hidden" value="'.$_POST['objet'].'">
													<input id="texte" name="texte" type="hidden" value="'.$_POST['texte'].'">
													<input id="id_podcast" name="id_podcast" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-success" name="Desarchiver" value="1" >Desarchiver</button>
												</form>
											</figure>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">date de mise en ligne : '.$date.' </div>
								<div class="col">Emmision : '.$nomemission.'</div>
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
												<form action="Desarchiver.php" method="POST">
													<input id="objet" name="objet" type="hidden" value="'.$_POST['objet'].'">
													<input id="texte" name="texte" type="hidden" value="'.$_POST['texte'].'">
													<input id="id_podcast" name="id_podcast" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-success" name="Desarchiver" value="1" >Desarchiver</button>
												</form>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">date de mise en ligne : '.$date.' </div>
									<div class="col">Emmision : '.$nomemission.'</div>
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
												<form action="Desarchiver.php" method="POST">
													<input id="objet" name="objet" type="hidden" value="'.$_POST['objet'].'">
													<input id="texte" name="texte" type="hidden" value="'.$_POST['texte'].'">
													<input id="id_podcast" name="id_podcast" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-success" name="Desarchiver" value="1" >Desarchiver</button>
												</form>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">date de mise en ligne : '.$date.' </div>
									<div class="col">Emmision : '.$nomemission.'</div>
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
												<form action="Desarchiver.php" method="POST">
													<input id="objet" name="objet" type="hidden" value="'.$_POST['objet'].'">
													<input id="texte" name="texte" type="hidden" value="'.$_POST['texte'].'">
													<input id="id_podcast" name="id_podcast" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-success" name="Desarchiver" value="1" >Desarchiver</button>
												</form>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">date de mise en ligne : '.$date.' </div>
									<div class="col">Emmision : '.$nomemission.'</div>
								</div>
							</div>';
				}
				
			}
			//Declaration des variables
			$desarchivage = 0; // 1 pour theme, 2 pour emissison, 3 pour theme 
			
			//traitement d'une demande de désarchivage de Theme
			if(isset($_POST['id_Theme'])){
				desarchivageTheme($_POST['id_Theme']);
				$desarchivage = 3;
			}
			
			//traitement d'une demande désarchivage d'Emission
			if(isset($_POST['id_Emission'])){
				desarchivageEmission($_POST['id_Emission']);
				$desarchivage = 2;
			}
			
			//traitement d'une demande désarchivage de podcast
			if(isset($_POST['id_podcast'])){
				desarchivagePodcast($_POST['id_podcast']);
				$desarchivage = 1 ;
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
						<input type="text" class="form-control" name = "texte" placeholder="Texte à rechercher dans l'objet à trouver" <?php if(isset($_POST['texte'])){ echo 'value = "'.$_POST['texte'].'"';} ?>> 
					</div>
					<div class="col">
						Type d'objet :
						<select class="custom-select" name ="objet">
						
							<!-- tous les objet -->
							<option value="1" <?php if(isset($_POST['objet']) && $_POST['objet'] == 1){ echo 'selected';}?>>Theme</option>
							<option value="2" <?php if(isset($_POST['objet']) && $_POST['objet'] == 2){ echo 'selected';}?>>Emission</option>
							<option value="3" <?php if(isset($_POST['objet']) && $_POST['objet'] == 3){ echo 'selected';}?>>Podcast</option>
						
						</select>
					</div>
				</div>
				
				<br/>
				<br/>			
				<button type="submit" class="btn-outline-success form-control ">Chercher</button>
				<br/>	
			</form>
		</div>
		</br></br>
		
		<?php
			//message reussite archivage podcast
			if ($desarchivage == 1){
				?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<h4 class="alert-heading">Le podcast à bien été desarchivé!</h4>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>			
				<?php
			}
			
			//message reussite archivage emission
			if ($desarchivage == 2){
				?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<h4 class="alert-heading">L'émission à bien été desarchivé!</h4>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>	
				
				<?php
			}
			
			//message reussite archivage theme
			if ($desarchivage == 3){
				?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">Le Théme à bien été desarchivé!</h4>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>	
				
				<?php
			}
		
		?>	
		
		<?php
			//on vérifie la recherche et on affiche en cosséquence
			if (isset($_POST['objet'])){
				if($_POST['objet']==1){
					//affichage des Themes
					echo '<div class="container">
							<div class="row">';						
								$sql = "SELECT * FROM theme WHERE archive = 1 ";
								$stmt = $pdo->prepare($sql);
								$stmt->execute();
								while ($row = $stmt->fetch()) {
									if (trieParTxt($row['titre'],$_POST['texte'])){
										affichageTheme($row['image'],$row['titre'],$row['id_theme']);
									}
								}
					echo 	'</div>
						</div>';
				}
				if($_POST['objet']==2){
					//affichage des Emissions
					$sql = "SELECT * FROM emission WHERE archive = 1 ";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
					echo	'<table class="table table-striped ">
							<thead>
								<tr>
									<th scope="col">Type</th>
									<th scope="col">Nom</th>
									<th scope="col">Descriptif</th>
									<th>Action</th>
								</tr>
							</thead>';				
					while ($row = $stmt->fetch()) {
						if (trieParTxt($row['nom'],$_POST['texte']) || trieParTxt($row['texte'],$_POST['texte'])){
							affichageEmission($row['id_emission'],$row['interview'],$row['nom'],$row['texte']);
						}
					}
					echo '</table>';
				}
				if($_POST['objet']==3){
					//affichage des Podcast
					$sql = "SELECT * FROM podcast WHERE archive = 1 and attente = 0";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();	
					while ($row = $stmt->fetch()) {
						if (trieParTxt($row['texte'],$_POST['texte'])){
							affichagePodcast($row['dateCreation'], $row['id_emission'], $row['son'], $row['texte'], $row['image'],$row['id_podcast'] );							
						}	
					}
				}
			}

		?>
			
			


		<!-- Footer -->
		<?php   
			include('../footeur/footeurs.html'); 
		?>
	</body>
</html>