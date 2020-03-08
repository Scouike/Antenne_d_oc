<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Rubriques</title>
		<!-- Lien vers boostrap -->
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../fontawesome/css/all.css" rel="stylesheet" >
		
		<!-- script boostrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>

	<body>

		 
		<!-- Barre de navigation --> 
		<?php   
			if (isset($_SESSION['level']) && $_SESSION['level']==1) {
				/* inclu une barre de navigation */
				include('bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				/* inclu une barre de navigation */
				include('bareNav/barreNavAdmin.html');
			}else{
				/* inclu une barre de navigation */
				include('bareNav/barreNav.html'); 
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
			if($_GET["son"]!=""){
				$sql="SELECT son,image,texte
							From Podcast
							Where son = ?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(array($_GET["son"]));
				$ligne = $stmt->fetch();
				if($ligne["image"]!="NULL"){
					echo'<div class=" cadre2 decalageGauche">
							 <div class="row">
								 <div class="col cadre_image">
									<img src="images/Logo.png" class="illustration" alt="Image Emission">
							 </div>';
				}else{
					
				}
				if($ligne["texte"]!="NULL"){
					echo'<div class="col">
							<div class="row">
								<div class="col description"><p>Texte descriptif du podcast</p></div>
								</div>';
				}else{
					
				}
			}
				
		?>
	<!-- Footer -->
	<?php   
		include('footeur/footeurs.html'); 
	?>
		
	</body>

	
</html>
