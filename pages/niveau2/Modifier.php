<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Modifier Site</title>
		<link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
			
		<!-- Lien vers mon CSS -->
		<link href="../../css/style.css" rel="stylesheet">
			
		<!-- liens vers fontawesome -->
		<link href="../../fontawesome/css/all.css" rel="stylesheet" >
		
		
		
		<!-- script boostrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="../../js/jquery.min.js" type="text/javascript"></script>	

	</head>
	<body>
		<?php
			//redirection des utilisateurs qui ne devrais pas étre à cette endroits
			if (!isset($_SESSION['level']) || $_SESSION['level'] < 2){
				header('Location: http://localhost/ProjetRadioGit/ProjetRadioPhp/index.php');
				Exit();
			}
		
			//barre de navigation		
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
			$modification = 0;
			
			
			
			
			
			
			
			
			
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
				echo'<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
						<div class="polaroid">
							<a href="/ProjetRadioGit/ProjetRadioPhp/pages/niveau0/Emission.php?id_theme='.$idTheme.'">
								<div class="image" style="background-image:url('.$image.')">
									<img src="'.$image.'" class="center" alt="Image du thème : '.$image.'"/>
								</div>
								<div class="polatxt">
									<p>'.$titre.'</p>
								</div>
							</a>
							<form action="Modifier.php" method="POST">
								<input id="id_Theme" name="id_Objet" type="hidden" value="'.$idTheme.'">
								<input id="objet" name="objetModif" type="hidden" value="'.$_POST['objet'].'">
								<button type="submit" class="btn btn-outline-warning btn-block " name="Modifier" value="1" >Modifier</button>
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
							<td><a href="/ProjetRadioGit/ProjetRadioPhp/pages/niveau0/Podcast.php?id_Emission='.$id_emission.'">'.$texte.'</a></td>
							<td>
								<form action="Modifier.php" method="POST">
									<input id="objet" name="objetModif" type="hidden" value="'.$_POST['objet'].'">
									<input id="id_Emission" name="id_Objet" type="hidden" value="'.$id_emission.'">
									<button type="submit" class="btn btn-outline-warning" name="Modifier" value="1" >Modifier</button>
								</form>
							</td>
						</tr>';
		
			}
			
			//fonction affichant les podcast
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
												<form action="Modifier.php" method="POST">
													<input id="objet" name="objetModif" type="hidden" value="'.$_POST['objet'].'">
													<input id="id_podcast" name="id_Objet" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-warning" name="Modifier" value="1" >Modifier</button>
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
												<form action="Modifier.php" method="POST">
													<input id="objet" name="objetModif" type="hidden" value="'.$_POST['objet'].'">
													<input id="id_podcast" name="id_Objet" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-warning" name="Modifier" value="1" >Modifier</button>
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
												<form action="Modifier.php" method="POST">
													<input id="objet" name="objetModif" type="hidden" value="'.$_POST['objet'].'">
													<input id="id_podcast" name="id_Objet" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-warning" name="Modifier" value="1" >Modifier</button>
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
												<form action="Modifier.php" method="POST">
													<input id="objet" name="objetModif" type="hidden" value="'.$_POST['objet'].'">
													<input id="id_podcast" name="id_Objet" type="hidden" value="'.$idPodcast.'">
													<button type="submit" class="btn btn-outline-warning" name="Modifier" value="1" >Modifier</button>
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
			
			
			function AffichageObjetModif($id_Objet,$typeObjet){
				if($typeObjet == 1){
					//affichage theme
					AffichageThemeModif($id_Objet);
				}else if($typeObjet == 2){
					//affichage emission
					AffichageEmissionModif($id_Objet);
					
				}else if($typeObjet == 3){
					//affichage podcast
					AffichagePodcastModif($id_Objet);
				}
			}
			
			function AffichageThemeModif($id_theme){
				global $pdo;
				$sql = "SELECT * FROM theme WHERE id_theme = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_theme]);
				while ($row = $stmt->fetch()) {
					
					?>
					<div class="margin cadre2 ">
								<h2>Theme </h2>
								<!-- la drop zone -->
								<form  action="Modifier.php"  method="POST"  enctype="multipart/form-data" id="formTheme">
									<div class="alert alert-primary" role="alert">
									  Attention vous pouvez modifier l'image si vous le souhaitez mais si vous ne voulez pas la changer n'interagissez pas avec la zone de dépôt de l'image.
									</div>
									<!-- la zone de drop -->
									<div class="dropzone">
										<input type="file"  name="imageTheme" id="themeDepoImg" >
									</div>
									<p id="textDropZoneImg" class="textDropZone">Déposer vos fichiers ou cliquer ici</p>
									

									<!--nom -->
									<div class="form-group row" id="aDeplacer">
										<label for="nomTheme" class="col-sm-3 col-form-label">Nom Theme :</label>
										<div class="col-sm-9">
											<input type="text" class="form-control"  id="nom" name="nomTheme" placeholder="Nom du Theme" value="<?php echo $row['titre']?>" maxlength="25" required>
											
										</div>
									</div>
									<input id="id_Theme" name="id_theme" type="hidden" value="<?php echo $id_theme;?>">
									<button type="submit" class="btn btn-primary" name="modifTheme">Modifier Theme</button>
								</form>
								
							</div>;

					<?php

				}
				
			}
			
			//verification si Theme en modification
			if(isset($_POST['modifTheme'])){
				
				
				//on initialise des variables
				$nomThemeDisponible = true;
				$presencefichier = false;
				$maxTaille = 5000000; //5mb
				
				//on traite la demande de modification 
				$id_theme = $_POST['id_theme'];
				// debug echo '<h1> id theme : '.$_POST['id_theme'].'</h1>';
				//on recupere les info du theme
				$sql = "SELECT * FROM theme WHERE id_theme = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_theme]);
				while ($row = $stmt->fetch()) {
					$nomTheme = $row['titre'];
				}	
				
				
				//on verifie dans la table que le nom n'est déja pas pris
				$sql = "SELECT * FROM theme";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch()) {
					if ($_POST['nomTheme'] == $row['titre'] && $row['titre']!=$nomTheme){
						$nomThemeDisponible = false;
					}
				}	
				
				//on verifie si il y a un fichier 
				if (!empty($_FILES['imageTheme']['name']) && $nomThemeDisponible) {
					$presencefichier = true;
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
						$cheminBD ="/ProjetRadioGit/ProjetRadioPhp/Theme/".$clef.$_FILES['imageTheme']['name'];
						$uploadfile = $uploaddir.$clef.$_FILES['imageTheme']['name'];
						$sql = "SELECT * FROM theme";
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
						while ($row = $stmt->fetch()) {
							if ($cheminBD == $row['image']){
								$nomFichierInvalide = false;
								$cheminBD ="/ProjetRadioGit/ProjetRadioPhp/Theme/".$clef.$_FILES['imageTheme']['name'];
								$uploadfile = $uploaddir.$clef.$_FILES['imageTheme']['name'];
							}
						}
					}while(!$nomFichierInvalide);
				}
				if($nomThemeDisponible && $presencefichier && $tailleCorrecte && $formatBon){
					if (move_uploaded_file($_FILES['imageTheme']['tmp_name'], $uploadfile)) {
						$sql ='UPDATE theme SET image = ?,titre = ? WHERE id_theme = ?';
						$stmt = $pdo->prepare($sql);
						$stmt->execute([$cheminBD,$_POST['nomTheme'],$id_theme]);
						$modification =3;
					}
				}else if($nomThemeDisponible && !$presencefichier){
					$sql ='UPDATE theme SET titre = ? WHERE id_theme = ?';
					$stmt = $pdo->prepare($sql);
					$stmt->execute([$_POST['nomTheme'],$id_theme]);
					$modification =3;
				}				
					
			}
			
			function AffichageEmissionModif($id_Emission){
				global $pdo;
				$interview ="";
				$sql = "SELECT * FROM emission WHERE id_emission = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_Emission]);
				while ($row = $stmt->fetch()) {
						if($row['interview']==1){
							$interview ="checked";
						}
						echo '<div class="margin cadre2">
						<h2>Emission</h2>
						<form action="	Modifier.php" method="POST">
							
							<!--nom -->
							<div class="form-group row">
								<label for="nomEmission" class="col-sm-2 col-form-label">Nom Emission :</label>
								<div class="col-sm-10">
									<input type="text" class="form-control  "  id="nomEmission" name="nomEmission" placeholder="Nom de l\'emission" value ="'.$row['nom'].'" maxlength="25" required>

								</div>
							</div>
							
							<!--texte -->
							<div class="form-group row">
								<label for="text" class="col-sm-2 col-form-label">Texte :</label>
								<div class="col-sm-10">
									<input type="text" class="form-control "  id="text" name="text" placeholder="Texte descriptif de l\'emission" maxlength="100" value="'.$row['texte'].'"required>
								
								</div>
							</div>


							<!--Theme -->
							<div class="form-group row">
								<label for="theme" class="col-sm-2 col-form-label">Theme :</label>
								<div class="col-sm-10">
									<select class="custom-select" name ="theme" required>
										<!-- tous les themes -->
										
									
											';
											
											$sql = "SELECT DISTINCT titre, id_theme FROM theme WHERE archive = 0 ORDER BY titre ";
											$stmt = $pdo->prepare($sql);
											$stmt->execute();
																 
											while ($row2 = $stmt->fetch()) {
												if($row2['id_theme'] == $row['id_theme']){
													echo '<option value="'.$row2['id_theme'].'" selected>'.$row2['titre'].'</option>';
												}else{
													echo '<option value="'.$row2['id_theme'].'" >'.$row2['titre'].'</option>';
												}
											}
										echo '
									</select>
								</div>
							</div>
							
							<!-- interview -->
							<div class="form-group row">
								<div class="col-sm-2">Interview</div>
								<div class="col-sm-10">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" id="interview" name="interview" value="1" '.$interview.' >
										<label class="form-check-label" for="interview">
											Cocher la case si vous voulez que l\'emission soit une interview
										</label>
									</div>
								</div>
							</div>
							
							
							<input id="id_Emission" name="id_Emission" type="hidden" value="'.$id_Emission.'">
							<button type="submit" id="modifEmission" name="modifEmission" class="btn btn-primary">Modifier Emission</button>
						</form>	
					</div>';
					
				}			
			}
			
			//vérification Emission si modif
			if(isset($_POST['modifEmission'])){
				//declaration variable
				$emissionAjout = false;
				$nomPris = false;
				
				
				//on vérifie que le nom n'est pas pris mais si il est similaire à l'ancien on le change
				$sql = "SELECT nom FROM emission WHERE nom = ? AND id_emission != ?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$_POST['nomEmission'],$_POST['id_Emission']]);										 
				while ($row = $stmt->fetch()) {
					$nomPris = true;						
				}
				
				
				
				if (!$nomPris){
					
					$interview = 0;
					if(isset($_POST['interview'])){
						$interview = 1;
					}
					//requéte
					$sql="UPDATE emission SET id_theme= ?, nom=?, texte=?, interview=? WHERE id_emission = ?";
					$stmt = $pdo->prepare($sql);
					$stmt->execute([$_POST['theme'],$_POST['nomEmission'],$_POST['text'],$interview,$_POST['id_Emission']]);
					
					$modification = 2;
				}
				
			}
			
			
			function AffichagePodcastModif($id_Podcast){
				global $pdo;
				$sql = "SELECT * FROM podcast WHERE id_podcast = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$id_Podcast]);
				while ($row = $stmt->fetch()) {
					$dateCrea = $row['dateCreation'];
					$dateArchi = $row['dateArchive'];
					?>
						<div class="margin cadre2">
							<form action="Modifier.php" method="POST" enctype="multipart/form-data">
							
								<!-- les date de mise en ligne et d\'archivage -->
								<div class="form-row">
									<div class="col">
										<label >Date de mise en ligne:</label>
										<input type="date" name="dateCrea" class="form-control" placeholder="Date du Podcast"
										value="<?php echo $dateCrea; ?>"  required>
									</div>
									<div class="col">
										<label >Date d'archivage	:</label>
										<input type="date" name="dateArchiv" class="form-control" placeholder="Date du Podcast"
										value="<?php echo $dateArchi; ?>"
										min ="<?php echo $dateCrea; ?>">
									</div>
								</div>
									
								<br/>
								
								<!-- texte pour le podcast -->
								<div class="form-group">
									<label for="TextDescription">Texte pour le podcast :</label>
									<textarea class="form-control" id="TextDescription" name="textePodcast" rows="3" ><?php if($row['texte'] != "NULL") {echo $row['texte'];}?></textarea>
								</div>
								
								<br/><br/>
								
								<div class="alert alert-primary" role="alert">
									  Attention vous pouvez modifier l'image et le son si vous le souhaitez mais si vous ne voulez pas les changer n'interagissez pas avec la zone de dépôt de l'image et du son.
								</div>
								</br>
								
								<!-- les fichiers -->
								<div class="row">
									<!-- image -->
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<div class="dropzone">
											<input type="file" name="image" id="image" class="form-control-file" >
										</div>
										<p id="textDropZoneImg"  class="textDropZone">Déposer les images de vos podcasts ici</p>
										
									</div>
									
											
									<!-- podcast -->
									<div class=" col-xs-12 col-sm-12 col-md-6 col-lg-6">
										<div class="dropzone">
											<input type="file" name="podcast" id="podcast" class="form-control-file" >
										</div>
										<p id="textDropZonePodcast" class="textDropZone" >Déposer vos fichiers audio ici</p>
										
									</div>
									
								</div>
								

								
								<!-- Liste déroulante avec les possibles émissions 	 -->
								<label>Choix émission du podcast</label>
								<select name="emission" class="custom-select" required>';
								<?php
									$sql="SELECT * FROM emission ORDER BY nom";
									$stmt = $pdo->prepare($sql);
									$stmt->execute();
									while ($row2 = $stmt->fetch()){
										if($row2["id_emission"] == $row["id_emission"]){
											echo'<option value="'.$row2["id_emission"].'" selected>'.$row2["nom"].'</option>';
										}else{
											echo'<option value="'.$row2["id_emission"].'">'.$row2["nom"].'</option>';
										}
									}
								?>	
								</select>
								
								<input id="id_Podcast" name="id_Podcast" type="hidden" value="<?php echo $id_Podcast;?>">
								<input type="submit" name="modifPodcast" value="Modifier Podcast" class="btn btn-success btn-block marge20Top">
							</form>
						</div>
					<?php
				}
						
			}
			
			//si modif de podcast en cours
			if(isset($_POST['modifPodcast'])){
				
				//initialisation variable
				$uploaddir = '../../podcast/';
				$formatPodcast = array('audio/mp3','audio/ogg','audio/wav');
				$formatImage = array('image/jpg','image/png','image/jpeg','image/gif');
				$formatImageCorecte = true;
				$formatPodcastCorecte = true;
				$maxTaille = 1000000000;; //1GB
				$tailleImageValid = true;
				$taillePodcastValid = true;
				$fichierSonVide = false;
	
				
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
				$text = $_POST['textePodcast'];
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
					$formatPodcastCorecte = false;
					$taillePodcastValid = false;
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
						//modif du son mais pas de l'image
						if(move_uploaded_file($_FILES['podcast']['tmp_name'], $uploadfilePodcast)){
							$sql = "UPDATE podcast SET id_emission = ?, son = ?, texte = ?, dateArchive = ?, dateCreation = ? WHERE id_podcast = ?";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$_POST['emission'],$cheminBDPodcast,$text,$dateArch,$dateCrea,$_POST['id_Podcast']]);
							$modification = 1;
						}
						
					}else{
						//modif du son et l'image
						if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfileImage)) {
							if(move_uploaded_file($_FILES['podcast']['tmp_name'], $uploadfilePodcast)){
								$sql = "UPDATE podcast SET id_emission = ?, image = ?, son = ?, texte = ?, dateArchive = ?, dateCreation = ? WHERE id_podcast = ?";
								$stmt = $pdo->prepare($sql);
								$stmt->execute([$_POST['emission'],$cheminBDImage,$cheminBDPodcast,$text,$dateArch,$dateCrea,$_POST['id_Podcast']]);
								$modification = 1;
							}
						}
					}
				}else if($fichierSonVide && $formatImageCorecte && $tailleImageValid && $taillePodcastValid && $formatPodcastCorecte && !$datenonValide){
					if($cheminBDImage=="NULL"){
						//modif ni du son ni de l'image
						$sql = "UPDATE podcast SET id_emission = ?, texte = ?, dateArchive = ?, dateCreation = ? WHERE id_podcast = ?";
						$stmt = $pdo->prepare($sql);
						$stmt->execute([$_POST['emission'],$text,$dateArch,$dateCrea,$_POST['id_Podcast']]);
						$modification = 1;
					}else{
						//modif de l'image mais pas du son
						if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfileImage)) {
							$sql = "UPDATE podcast SET id_emission = ?, image = ?, texte = ?, dateArchive = ?, dateCreation = ? WHERE id_podcast = ?";
							$stmt = $pdo->prepare($sql);
							$stmt->execute([$_POST['emission'],$cheminBDImage,$text,$dateArch,$dateCrea,$_POST['id_Podcast']]);
							$modification = 1;
						}
					}
				}
			}
			
			
			
			
			
			
			
		?>
			
			
		<h1 class="text-uppercase m-4 text-center">Modifier</h1>
		
		<div class="cadre ">
			<div>
				<!-- titre -->
				<a class="a1 inactive underlineHover titre" href="Archiver.php">Archiver</a>
				<a class="a1 inactive underlineHover titre" href="Desarchiver.php">Desarchiver</a>
				<a class="a1 active titre" href="Modifier.php">Modifier</a>
			</div>
		</div>
		</br>
		<?php
			//message reussite modification podcast
			if ($modification == 1){
				?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<h4 class="alert-heading">Le podcast a bien été modifié!</h4>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>			
				<?php
			}
			
			//message reussite modification emission
			if ($modification == 2){
				?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<h4 class="alert-heading">L'émission a bien été modifié!</h4>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>	
				
				<?php
			}
			
			//message reussite modification theme
			if ($modification == 3){
				?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">Le thème a bien été modifié!</h4>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>	
				
				<?php
			}
		
		?>	
		
		<!--recherche -->
		<div class="margin cadre2">
			<form action="Modifier.php" method="POST">
				<div class="form-row">
					
					<div class="col">
					<!-- Les zones de textes pour le titre et le nom de l'auteur du podcast -->
						Texte :
						<input type="text" class="form-control" name = "texte" placeholder="Texte à rechercher dans l'objet à trouver" <?php if(isset($_POST['texte'])){ echo 'value = "'.$_POST['texte'].'"';} ?>> 
						</br>
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
			//on vérifie la recherche et on affiche en cosséquence
			if (isset($_POST['objet'])){
				if($_POST['objet']==1){
					//affichage des Themes
					echo '<div class="container">
							<div class="row">';						
								$sql = "SELECT * FROM theme WHERE archive = 0 ";
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
					$sql = "SELECT * FROM emission WHERE archive = 0 ";
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
					$sql = "SELECT * FROM podcast WHERE archive = 0 and attente = 0";
					$stmt = $pdo->prepare($sql);
					$stmt->execute();	
					while ($row = $stmt->fetch()) {
						if (trieParTxt($row['texte'],$_POST['texte'])){
							affichagePodcast($row['dateCreation'], $row['id_emission'], $row['son'], $row['texte'], $row['image'],$row['id_podcast'] );							
						}	
					}
				}
			}
			
			//on vérifi si une modification est demandé
			if (isset($_POST['objetModif']) && $modification==0){
				
				AffichageObjetModif($_POST['id_Objet'],$_POST['objetModif']);
			}
			
			//on reaffiche la modif de theme mais avec des erreurs
			if(isset($_POST['modifTheme']) &&  $modification==0){
				
				?>
				<div class="margin cadre2 ">

					<h2>Theme </h2>
					<!-- la drop zone -->
					<form  action="Modifier.php"  method="POST"  enctype="multipart/form-data" id="formTheme">
						<!-- la zone de drop -->
						<div class="dropzone">
							<input type="file"  name="imageTheme" id="themeDepoImg">
						</div>
						<p id="textDropZoneImg" class="textDropZone">Déposer vos fichiers ou cliquer ici</p>
						<?php
							
							if($presencefichier && !$formatBon){
								echo '<div class="alert alert-danger" role="alert">Le format n\'est pas correct, les types d\'image accéptés sont : jpg, png, jpeg, gif</div>';
							}
							if($presencefichier && !$tailleCorrecte){
								echo '<div class="alert alert-danger" role="alert">Taille du fichier trop volumineuse, taille maximal = 5mb</div>';
							}
						
						?>
						<!--nom -->
						<div class="form-group row" id="aDeplacer">
							<label for="nomTheme" class="col-sm-3 col-form-label">Nom Theme :</label>
							<div class="col-sm-9">
								<input type="text" class="form-control <?php if(isset($_POST['nomTheme']) && !$nomThemeDisponible){ echo "is-invalid";} ?>"  id="nom" name="nomTheme" placeholder="Nom du Theme" maxlength="25" required>
								<?php	
									if (isset($_POST['nomTheme']) && !$nomThemeDisponible ){
										echo '<div class="invalid-feedback">Le nom du thème que vous voulez ajouter est déjà pris</div>';
									}
								?>
							</div>
						</div>
						<input id="id_Theme" name="id_theme" type="hidden" value="<?php echo $id_theme; ?>">
						<button type="submit" class="btn btn-primary" name="modifTheme">Modifier Theme</button>
					</form>
					
				</div>
				
				<?php
				
			}
			
			//reaffichage d'emission mais avec des erreurs
			if(isset($_POST['modifEmission']) &&  $modification==0){
				?>
				<div class="margin cadre2">
					<h2>Emission</h2>
					<form action="Modifier.php" method="POST">
						
						<!--nom -->
						<div class="form-group row">
							<label for="nomEmission" class="col-sm-2 col-form-label">Nom Emission :</label>
							<div class="col-sm-10">
								<input type="text" class="form-control  <?php if(isset($_POST['modifEmission']) && $nomPris){ echo "is-invalid";} ?>"  id="nomEmission" name="nomEmission" placeholder="Nom de l'emission" maxlength="25" required>
								<?php
									if(isset($_POST['modifEmission']) && $nomPris){
										echo '<div class="invalid-feedback">Le nom de ce thème est déjà pris</div>';
									}
								
								
								?>
							</div>
						</div>
						
						<!--texte -->
						<div class="form-group row">
							<label for="text" class="col-sm-2 col-form-label">Texte :</label>
							<div class="col-sm-10">
								<input type="text" class="form-control <?php if(isset($_POST['modifEmission']) && $nomPris){ echo "is-valid";}?>"  id="text" name="text" placeholder="Texte descriptif de l'emission" maxlength="100" <?php if(isset($_POST['modifEmission']) && $nomPris){ echo 'value="'.$_POST['text'].'"';}?>required>
							
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
											if(isset($_POST['modifEmission']) && $row['id_theme'] == $_POST['theme']){
												echo '<option value="'.$row['id_theme'].'" selected >'.$row['titre'].'</option>';
											}else{
												echo '<option value="'.$row['id_theme'].'" >'.$row['titre'].'</option>';
											}
											
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
						
						
						
						<input id="id_Emission" name="id_Emission" type="hidden" value="<?php echo $_POST['id_Emission']; ?>">
						<button type="submit" id="modifEmission" name="modifEmission" class="btn btn-primary">Modifier Emission</button>
					</form>	
				</div>
				
				<?php
			}
			
			
			//reaffichage de theme mais avec des erreurs
			if(isset($_POST['modifPodcast']) && $modification==0){
				?>
				
					<div class="margin cadre2">
						<form action="AjoutPodcast.php" method="POST" enctype="multipart/form-data">
						
							<!-- les date de mise en ligne et d'archivage -->
							<div class="form-row">
								<div class="col">
									<label >Date de mise en ligne:</label>
									<input type="date" name="dateCrea" class="form-control <?php if(isset($_POST['dateCrea']) && $datenonValide){ echo "is-invalid"; }?>" placeholder="Date du Podcast"
									value="<?php if(!isset($_POST['dateCrea']) || (isset($_POST['dateCrea']) && $datenonValide)){echo date("Y-m-d",time());}else { echo $_POST['dateCrea'];}?>" required>
								</div>
								<div class="col">
									<label >Date d'archivage	:</label>
									<input type="date" name="dateArchiv" class="form-control  <?php if(isset($_POST['dateArchiv']) && $datenonValide){ echo "is-invalid"; }?>" placeholder="Date du Podcast"
									value="<?php if(!isset($_POST['dateArchiv']) || (isset($_POST['dateArchiv']) && $datenonValide)){ echo date("Y-m-d",strtotime("+1 year")); }else { echo $_POST['dateArchiv']; }?>"
									min ="<?php echo date("Y-m-d",strtotime("+1 day")) ;?>">
								</div>
							</div>
							<?php
								if($datenonValide){
									echo '</br><div class="alert alert-danger" role="alert">Attention la date de mise en ligne ne peut pas être postérieur à la date d\'archivage</div>';
								}
							?>
							<br/>
							
							<!-- texte pour le podcast -->
							<div class="form-group">
								<label for="TextDescription">Texte pour le podcast :</label>
								<textarea class="form-control" id="TextDescription" name="textePodcast" rows="3"><?php if(isset($_POST['textePodcast'])){echo $_POST['textePodcast'];}?></textarea>
							</div>
							
							<br/><br/>
							
							<!-- les fichiers -->
							<div class="row">
								<!-- image -->
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="dropzone">
										<input type="file" name="image" id="image" class="form-control-file" >
									</div>
									<p id="textDropZoneImg"  class="textDropZone">Déposer les images de vos podcast ici</p>
									<?php
										if(!$formatImageCorecte){
										echo '<div class="alert alert-danger" role="alert">Le format n\'est pas correct, les types de fichiers audios accéptés sont : jpg, png, jpeg, gif</div>';
										}
										if(!$tailleImageValid){
											echo '<div class="alert alert-danger" role="alert">Taille du fichier trop volumineuse, taille maximal = 5mb</div>';
										}

									?>
								</div>
								
										
								<!-- podcast -->
								<div class=" col-xs-12 col-sm-12 col-md-6 col-lg-6">
									<div class="dropzone">
										<input  type="file" name="podcast" id="podcast" class="form-control-file" >
									</div>
									<p id="textDropZonePodcast" class="textDropZone" >Déposer vos fichiers audio ici</p>
									<?php
								
										if(!$formatPodcastCorecte){
											echo '<div class="alert alert-danger" role="alert">Le format n\'est pas correct, les types d\'images accéptés sont : mp3, ogg, wav</div>';
										}
										if(!$taillePodcastValid){
											echo '<div class="alert alert-danger" role="alert">Taille du fichier trop volumineuse, taille maximal = 1GB</div>';
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
									if (isset($_POST['emission']) && $_POST['emission']==$row["id_emission"] ){		
										echo'<option value="'.$row["id_emission"].'" selected>'.$row["nom"].'</option>';
									}else{
										echo'<option value="'.$row["id_emission"].'">'.$row["nom"].'</option>';
									}
								}
								?>
							</select>
							
							<input id="id_Podcast" name="id_Podcast" type="hidden" value="<?php echo $_POST['id_Podcast'];?>">
							<input type="submit" name="modifPodcast" value="Modifier Podcast" class="btn btn-success btn-block marge20Top">
						</form>
					</div>
				
				
				
				<?php
			}	
				
		
		?>
		
		

		<script>
			$(document).ready(function(){
				$('#themeDepoImg').change(function () {
					$('#textDropZoneImg').text(this.files.length + " fichier a été  ajouté");
				});
				$('#image').change(function () {
					$('#textDropZoneImg').text(this.files.length + " fichier a été  ajouté");
				});
				$('#podcast').change(function () {
					$('#textDropZonePodcast').text(this.files.length + " fichier a été  ajouté");
				});
			});
		</script>
	

		<!-- Footer -->
		<?php   
			include('../footeur/footeurs.html'); 
		?>
	</body>
</html>