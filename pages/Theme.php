<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Rubriques</title>
		<!-- Lien vers boostrap -
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
		?>
		<!-- DIfférents thème d'émission -->
		<div class="container">
			<div class="row">
			<?php
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
			
				$sql="SELECT * FROM theme ORDER BY titre ASC"  ;
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				$titre="";
				$image="";
				$tabImage[0]="";
				$tabTitre[0]="";
				$increment=0;
				while( $ligne = $stmt->fetch() ) {
					$increment++;
					$tabTitre[$increment]=$ligne['titre'];
					$tabImage[$increment]=$ligne['image'];
					echo'<div class="col-md-4 col-sm-6">
					<div class="polaroid">
						<a href="Emission.php?titre='.$tabTitre[$increment].'">
						<div class="image" style="background-image:url('.$tabImage[$increment].')">
							<img src="'.$tabImage[$increment].'" class="center" alt="Image du thème : '.$tabImage[$increment].'"/>
						</div>
						<div class="polatxt">
							<p>'.$tabTitre[$increment].'</p>
						</div></a>
						</div>
					</div>';
				}
				?>
			</div>
		</div>
	<!-- Footer -->
	<?php   
		include('footeur/footeurs.html'); 
	?>
		
	</body>

	
</html>
