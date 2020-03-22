<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creer Animateur</title>
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
		if (isset($_SESSION['level']) && $_SESSION['level']==3) {
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
		

	?>
		
		
	<h1 class="text-uppercase m-4 text-center">Modifier Droits</h1>
	<div class="cadre ">
		<div>
			<!-- titre -->
			<a class="a1 inactive underlineHover titre" href="CreerAnimateur.php">Creer Animateur</a>
			<a class="a1 active titre" href="ModifierDroits.php">Modifier Droits </a>
		</div>
	</div>
	
	<div class="cadre2 margin marge" >
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Prenom</th>
						<th scope="col">Nom</th>
						<th scope="col">Mail</th>
						<th scope="col">Niveau</th>
					</tr>
				</thead>
				<tbody>
				
					<?php
						$sql = "SELECT * FROM utilisateur WHERE attente = 0 ORDER BY id_utilisateur";
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
											 
						while ($row = $stmt->fetch()) {
							echo '<tr>
									<th scope="row">'.$row['id_utilisateur'].'</th>
									<td>'.$row['prenom'].'</td>
									<td>'.$row['nom'].'</td>
									<td>'.$row['mail'].'</td>
									<td>'.$row['niveau'].'</td>
								</tr>';

						}
					
					?>
				</tbody>
			</table>
		</div>
	</div>

	
	
	


	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>
</body>
</html>