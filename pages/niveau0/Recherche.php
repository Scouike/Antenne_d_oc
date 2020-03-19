<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Recherche</title>
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
			function affichagePodcast($date, $idemmision, $podcast, $texte){
				
			}
			
			

			
			
			
			
		?>
		
	<h1 class="text-uppercase m-4 text-center">Recherche de Podcast</h1>
	<div class="margin cadre2">
		<form action="Recherche.php" method="POST">
			<div class="form-row">
			    
				<div class="col">
				<!-- Les zones de textes pour le titre et le nom de l'auteur du podcast -->
					Texte :
					<input type="text" class="form-control" placeholder="Texte à rechercher dans un podcast"> 
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
				<!-- toutes les emmisions -->
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
			<button type="submit" class="btn-warning form-control ">Chercher	</button>
			<br/>
			<br/>		
		</form>
	</div>
	
	
	<div class="margin">
		<table class="table table-striped ">
		  <thead>
			<tr>
			  <th scope="col">Nom du podcast</th>
			  <th scope="col">Date</th>
			  <th scope="col">Emission</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th scope="row">Nom du podcast</th>
			  <td>Date</td>
			  <td>Emission</td>
			</tr>
			<tr>
			  <th scope="row">Nom du podcast</th>
			  <td>Date</td>
			  <td>Emission</td>
			</tr>
			<tr>
			  <th scope="row">Nom du podcast</th>
			  <td>Date</td>
			  <td>Emission</td>
			</tr>
		  </tbody>
		</table>
	</div>

	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>		
	</body>

	
</html>