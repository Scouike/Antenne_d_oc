<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Emission</title>
		<!-- Lien vers boostrap -->
		<link href="../../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../../../fontawesome/css/all.css" rel="stylesheet" >
		
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
			if (isset($_SESSION['level']) && $_SESSION['level']==1) {
				include('../../bareNav/barreNavUtilisateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				/* inclu une barre de navigation */
				include('../../bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==3) {
				/* inclu une barre de navigation */
				include('../../bareNav/barreNavAdmin.html');
			}else{
				/* inclu une barre de navigation */
				include('../../bareNav/barreNav.html'); 
			}
			
			//initialisation des variables
			
			$mdpOK = true; //verif de la syntaxe du nouveau mdp
			$mdpVerif = true; //verif que le nouveau mdp à été tapé 2 fois
			$mdpChange = false; //verif que le mdp à été changé
			$mdpCorrecte = true; //verif que l'ancien mdp correspond
			
			
			$mail = $_SESSION['mail'];
			if ($_SESSION['level'] == 1){
				$status = 'Utilisateur';
			}else if ($_SESSION['level'] == 2){
				$status = 'Animateur';
			}else if ($_SESSION['level'] == 3){
				$status = 'Admin';
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
			
			
			//verif mdp
			if (isset($_POST["mdpHold"])){
				$mdpCorrecte = false;
				$sql = "SELECT * FROM utilisateur ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch())
				{
					
					if ($row['mail'] == $mail && $row['mdp'] == hash('sha256',$_POST["mdpHold"]) && $row['attente'] == 0){
						$mdpCorrecte = true;
					}
				}			
			}
			
			//verif des mdp et nouveau mdp 
			
			//verification des formats
			$regexMdp ="#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,30}$#";
			
			//verif mdp
			if (isset($_POST["mdp"]) && !preg_match($regexMdp, $_POST["mdp"])){
				$mdpOK = false;
			}
			
			//verification de la correspondance des mdp
			if (isset($_POST["mdp"]) && isset($_POST["mdpVerif"]) && $_POST["mdp"] != $_POST["mdpVerif"] ){
				$mdpVerif = false;
			}
			
			//changement de mdp 
			if (isset($_POST["mdp"]) && isset($_POST["mdpHold"]) && isset($_POST["mdpVerif"]) && $mdpOK && $mdpVerif && $mdpCorrecte){
				//modification bd
				$sql = 'UPDATE utilisateur SET mdp = ? WHERE mail = ?';
				$stmt = $pdo->prepare($sql);
				$stmt->execute([hash('sha256', $_POST["mdp"]),$mail]);
				$mdpChange = true;
				
				
			}
			
			
		?>
		
		
		<form class="cadre2 margin marge"  action="Profil.php" method="POST">
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-2 col-form-label">Email :</label>
				<div class="col-sm-10">
					<input type="mail" readonly class="form-control-plaintext" id="staticEmail" value=" <?php echo $mail ?> ">
				</div>
			</div>
						
			<div class="form-group row">
				<label for="staticEmail" class="col-sm-2 col-form-label">Status :</label>
				<div class="col-sm-10">
					<input type="text" readonly class="form-control-plaintext" id="staticEmail" value=" <?php echo $status ?> ">
				</div>
			</div>			
				
			<div class="alert alert-primary" role="alert">
			  Pour changer de mot de passe veuillez remplir ce formulaire
			</div>
				
				
			<!-- Mdp -->
			<div class="form-group row">
				<label for="inputPassword" class="col-sm-2 col-form-label">Ancien mot de passe :</label>
				<div class="col-sm-10">
					<input type="password" class="form-control <?php if (!$mdpCorrecte){ echo "is-invalid";}else if (isset($_POST['mdpHold']) && $mdpCorrecte){ echo "is-valid"; } ?>" id="mdpHold" name="mdpHold" placeholder="Ancien mot de passe">
						<?php 
						if (isset($_POST["mdpHold"]) && $mdpCorrecte ){
							echo '<div class="valid-feedback">Mot de passe Correcte</div>';
						}
						if (!$mdpCorrecte){
							echo '<div class="invalid-feedback">Le mot de passe est invalide</div>';
						}
					?>
				</div>
				
			</div>
						
			<div class="form-group row">
				<label for="inputPassword" class="col-sm-2 col-form-label">Nouveau mot de passe :</label>
				<div class="col-sm-10">
					<input type="password" class="form-control  <?php if (!$mdpOK){ echo "is-invalid";}else if (isset($_POST['mdp']) && $mdpOK){ echo "is-valid"; } ?>" id="mdp" name="mdp" placeholder="Nouveau mot de passe">
					<?php 
						if (isset($_POST["mdp"]) && $mdpOK ){
							echo '<div class="valid-feedback">Mot de passe Correcte</div>';
						}
						if (!$mdpOK){
							echo '<div class="invalid-feedback">Le mot de passe est invalide, il doit au minimum avoir une majuscule, une minuscule, un chiffre et 8 caractères en tout</div>';
						}
					?>
				</div>
			</div>
						
			<div class="form-group row">
				<label for="inputPassword" class="col-sm-2 col-form-label">Nouveau mot de passe Confirmation:</label>
				<div class="col-sm-10">
					<input type="password" class="form-control  <?php if (!$mdpVerif){ echo "is-invalid";}else if (isset($_POST['mdpVerif']) && $mdpVerif){ echo "is-valid"; } ?>" id="mdpVerif" name="mdpVerif" placeholder="Nouveau mot de passe Confirmation">
					<?php 
						if (isset($_POST["mdpVerif"]) && $mdpVerif ){
							echo '<div class="valid-feedback">Les mots de passe sont identique</div>';
						}
						if (!$mdpVerif){
							echo '<div class="invalid-feedback">Les mots de passe ne correspondent pas</div>';
						}
					?>
					
					
				</div>
			</div>

			<?php
				if ($mdpChange){
			?>
					<div class="alert alert-success" role="alert">
						<h4 class="alert-heading">Bravo!</h4>
						<p>Vous avez Bien changé votre mot de passe avec succés </p>
						<hr>
						<p class="mb-0">Vous pouvez maintenant vous connecter avec celui ci</p>
					</div>
			
			
			<?php 
				}
			?>			

			<!--bouton -->
			<div class="form-group row">
				<div class="col-sm-10">
					<button type="submit" class="btn btn-primary">Changer mot de passe</button>
				</div>
			</div>
		</form>
			
	<!-- Footer -->
	<?php   
			include('../../footeur/footeurs.html'); 
	?>
		
	</body>
	
</html>
