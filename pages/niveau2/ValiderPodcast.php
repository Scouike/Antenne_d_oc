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
			
			<!-- script boostrap -->
			<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		<?php 
			//redirection des utilisateurs qui ne devrais pas étre à cette endroits
			if (!isset($_SESSION['level']) || $_SESSION['level'] < 2){
				header('Location: http://localhost/ProjetRadioGit/ProjetRadioPhp/index.php');
				Exit();
			}
		
			//barre de navigation			
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
			
			//declaration des variables
			$action = 0; //0 si rien n'est fais 1 si on ajoute le podcast et 2 si on le supprime
			
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
			
			//fonction qui valide ou non un podcast
			if (isset($_POST['validation'])){
				//cas ou on autorise le podcast
				if($_POST['validation']==1){
					
					$sql = 'UPDATE podcast SET attente = 0 WHERE id_podcast = ?';
					$stmt = $pdo->prepare($sql);
					$stmt->execute([$_POST['id_podcast']]);
					$action = 1;
				}
				
				//cas ou on detruit le podcast
				if($_POST['validation']==2){
					$sql = 'DELETE FROM podcast WHERE id_podcast = ?';
					$stmt = $pdo->prepare($sql);
					$stmt->execute([$_POST['id_podcast']]);
					$action = 2;
				}
				
			}
			
			//fonction qui determine qui affiche un podcast
			function affichagePodcast($date, $idemission, $podcast, $texte, $image, $idPodcast){
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
												<form action="ValiderPodcast.php" method="POST">
													<input id="id_podcast" name="id_podcast" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-success" name="validation" value="1" >Valider</button>
													<button type="submit" class="btn btn-outline-danger" name="validation" value="2">Suprimer</button>
												</form>
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
												<form action="ValiderPodcast.php" method="POST">
													<input id="id_podcast" name="id_podcast" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-success" name="validation" value="1" >Valider</button>
													<button type="submit" class="btn btn-outline-danger" name="validation" value="2">Suprimer</button>
												</form>
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
												<form action="ValiderPodcast.php" method="POST">
													<input id="id_podcast" name="id_podcast" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-success" name="validation" value="1" >Valider</button>
													<button type="submit" class="btn btn-outline-danger" name="validation" value="2">Suprimer</button>
												</form>
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
												<form action="ValiderPodcast.php" method="POST">
													<input id="id_podcast" name="id_podcast" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-success" name="validation" value="1" >Valider</button>
													<button type="submit" class="btn btn-outline-danger" name="validation" value="2">Suprimer</button>
												</form>
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
			
			//fonction verifiant la rechercher par txt
			function trieParTxt($txtVerif,$txtARespecter){
				$txtCorrespondant = false;
				
				if( preg_match('#'.$txtARespecter.'#',$txtVerif)) {
					$txtCorrespondant = true;
				}

				
				return $txtCorrespondant;
			}
			
			//fonction verifiant la recherche par emissions
			function trieParEmission($id_emissionVerif,$nom_emissionARespecter){
				global $pdo;
				$emissionCorrespondant = false;
				
				//recuperation du nom de l'emission
				$sql = "SELECT nom FROM emission WHERE id_emission = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_emissionVerif]);	
				while ($row = $stmt->fetch()) {
					$nom_emission = $row['nom'];
				}
				
				if ($nom_emission == $nom_emissionARespecter){
					$emissionCorrespondant = true;
				}
				
				if ($nom_emissionARespecter == 'TOUS'){
					$emissionCorrespondant = true;
				}
				return $emissionCorrespondant;
			}
			
			//fonction verifiant la recherche par theme
			function trieParTheme($id_emissionVerif,$themeARespecter){
				global $pdo;
				$themeCorrespondant = false;
				
				//recuperation du theme de l'emission
				$sql = "SELECT titre FROM theme JOIN emission ON emission.id_theme = theme.id_theme WHERE id_emission = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_emissionVerif]);	
				while ($row = $stmt->fetch()) {
					$nom_theme = $row['titre'];
				}
				
				if ($nom_theme==$themeARespecter){
					$themeCorrespondant = true;
				}
				
				if ($themeARespecter=='TOUS'){
					$themeCorrespondant = true;
				}
				
				
				return $themeCorrespondant;
			}
			
			//foction verifiant qu'un podcast vérifie le trie selectionner
			function selection($txtVerif,$txtARespecter,$id_emissionVerif,$nom_emissionARespecter,$themeARespecter){
				$selectionOK = false;
				if (trieParTxt($txtVerif,$txtARespecter) && 
					trieParEmission($id_emissionVerif,$nom_emissionARespecter) && 
					trieParTheme($id_emissionVerif,$themeARespecter)){
						$selectionOK = true;
					}
				return $selectionOK;
			}
			
			

			
			
			
			
		?>
		
	<h1 class="text-uppercase m-4 text-center">Validation de Podcast</h1>
	
	<?php
		// si modification demandé et modification justifié 
		if ($action == 1){
			?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">Le podcast a bien été ajouté!</h4>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>			
			<?php
		}
		
		//si modification demandé mais pas de réel changement 
		if ($action == 2){
			?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">Le podcast a bien été supprimé!</h4>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>	
			
			<?php
		}
	
	?>	
	<div class="margin cadre2">
		<form action="ValiderPodcast.php" method="POST">
			<div class="form-row">
			    
				<div class="col">
				<!-- Les zones de textes pour le titre et le nom de l'auteur du podcast -->
					Texte :
					<input type="text" class="form-control" name = "texte" placeholder="Texte à rechercher dans un podcast" <?php if (isset($_POST['texte'])){echo 'value = "'.$_POST['texte'].'"';}?>> 
				</div>
				<div class="col">
					Theme :
					<select class="custom-select" name ="theme">
						<!-- tous les themes -->
						<?php
					
							if (isset($_POST['theme'])){
								echo "<option selected >".$_POST['theme']."</option>";
								if ($_POST['theme'] != 'TOUS'){
									echo "<option>TOUS</option>";
								}
							}else{
								echo "<option selected >TOUS</option>";
							}
							$sql = "SELECT DISTINCT titre FROM theme WHERE archive = 0 ORDER BY titre ";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
												 
							while ($row = $stmt->fetch()) {
								
								if (isset($_POST['theme']) && $_POST['theme'] != 'TOUS' ){
									if ($_POST['theme'] != $row['titre']){
										echo "<option >".$row['titre']."</option>";
									}
								}else{		
									echo "<option >".$row['titre']."</option>";
								}
							}
						?>
					
					</select>
				</div>
			</div>
			<br/>
			<br/>
			<!-- Liste déroulante avec les possibles émissions 	 -->
			Emission :
			<select class="custom-select" name ="emission">
				<!-- toutes les emissions -->
				<?php
					
					if (isset($_POST['emission'])){
						echo "<option selected >".$_POST['emission']."</option>";
						if ($_POST['emission'] != 'TOUS'){
							echo "<option>TOUS</option>";
						}
					}else{
						echo "<option selected >TOUS</option>";
					}
					$sql = "SELECT DISTINCT nom FROM emission WHERE archive = 0 ORDER BY nom ";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();
												 
					while ($row = $stmt->fetch()) {
						
						if (isset($_POST['emission']) && $_POST['emission'] != 'TOUS' ){
							if ($_POST['emission'] != $row['nom']){
								echo "<option >".$row['nom']."</option>";
							}
						}else{
							echo "<option >".$row['nom']."</option>";
						}
					
					}
				?>
			</select>
			<br/>
			<br/>			
			<button type="submit" class="btn-outline-success form-control ">Chercher	</button>
			<br/>
			<br/>		
		</form>
	</div>
	
	<!-- affichage des podcat -->
	<?php
		if (isset($_POST['emission']) || isset($_POST['theme']) || isset($_POST['texte'])){
			$sql = "SELECT * FROM podcast WHERE archive = 0 AND attente = 1 ORDER BY id_podcast ";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
												 
			while ($row = $stmt->fetch()) {
				if(selection($row['texte'],$_POST['texte'],$row['id_emission'],$_POST['emission'],$_POST['theme'])){
					affichagePodcast($row['dateCreation'], $row['id_emission'], $row['son'], $row['texte'], $row['image'],$row['id_podcast'] );
				}
			}
		}else{
			$sql = "SELECT * FROM podcast WHERE archive = 0 AND attente = 1 ORDER BY id_podcast ";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
												 
			while ($row = $stmt->fetch()) {	
				affichagePodcast($row['dateCreation'], $row['id_emission'], $row['son'], $row['texte'], $row['image'],$row['id_podcast'] );
			}
			
		}
	
		
	?>
	

	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>		
	</body>
</html>