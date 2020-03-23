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
		//variable
		$action = false;
		$BonneModif = false;
		
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
		//changement de droit 
		if (isset($_POST['id_utilisateur']) && $_POST['inputNiveau']){
			$action = true;
			$ModificationNonPersonel = true;
			//verification si le changement est reel 
			$sql = "SELECT * FROM utilisateur WHERE id_utilisateur = ? ";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_POST['id_utilisateur']]);
			while ($row = $stmt->fetch()) {
				if ($_POST['inputNiveau'] != $row['niveau']){
					$BonneModif = true;
				}
				if ($_SESSION['id'] == $row['id_utilisateur']){
					$ModificationNonPersonel = false;
				}
			}
			//modif du niveau dans la bd 
			if ($BonneModif && $ModificationNonPersonel){
				$sql = 'UPDATE utilisateur SET niveau = ? WHERE id_utilisateur = ?';
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$_POST['inputNiveau'],$_POST['id_utilisateur']]);
			}
			
			
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
	</br>
	
	<?php
		// si modification demandé et modification justifié 
		if ($action && $BonneModif && $ModificationNonPersonel){
			?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">Modification effectué!</h4>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>			
			<?php
		}
		//si modification demandé et tentative de changer ses propres droits
		if ($action && !$ModificationNonPersonel){
			?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">Modification non effectué!</h4>
					<p>Vous ne pouvez pas changer vos propres droits</p>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>	
			
			<?php
		}
		
		//si modification demandé mais pas de réel changement
		if ($action && !$BonneModif){
			?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<h4 class="alert-heading">Modification non effectué!</h4>
					<p>Vous ne pouvez pas changer un le droit d'accés d'une personne par son même droit</p>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>	
			
			<?php
		}
	
	?>

	
	
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
						<th scope="col">Modifier</th>
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
									<td>'.$row['mail'].'</td>';
							
							echo '<form action="ModifierDroits.php" method="POST">';
							if ($row['niveau'] == 1){
								echo '<td>
										<select id="inputNiveau" name="inputNiveau" class="form-control">
											<option selected value="1">Utilisateur</option>
											<option value="2">Animateur</option>
											<option value="3">Admin</option>
										</select>
									 </td>';
								
							}else if($row['niveau'] == 2){
								echo '<td>
										<select id="inputNiveau" name="inputNiveau" class="form-control">
											<option value="1">Utilisateur</option>
											<option selected value="2">Animateur</option>
											<option value="3">Admin</option>
										</select>
									 </td>';
								
							}else{
								echo '<td>
										<select id="inputNiveau" name="inputNiveau" class="form-control">
											<option value="1">Utilisateur</option>
											<option value="2">Animateur</option>
											<option selected value="3">Admin</option>
										</select>
									 </td>';
							}
					
							echo '<td><button type="submit" class="btn btn-primary">Modifier droit</button></td>
								      <input id="id_utilisateur" name="id_utilisateur" type="hidden" value="'.$row['id_utilisateur'].'"></form></tr>';

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