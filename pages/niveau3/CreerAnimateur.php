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
		

		//Declaration des variables
		$nomOK = true;
		$prenomOK = true;
		$ageOK = true;
		$mailOK = true;
		$mdpOK = true;
		$mdpVerif = true;
		$mailUnique = true;
		$inscriptionValide = false;
			
			
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
			
		//verification des formats
		$regexNomPrenom = "/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ[:blank:]-]{1,25})$/";
		$regexMail ="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
		$regexMdp ="#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,30}$#";
		 
		// verif nom
		if (isset($_POST["nom"]) && !preg_match($regexNomPrenom, $_POST["nom"])){
			$nomOK =false;
		}
			
		//verif prenom
		if (isset($_POST["prenom"]) && !preg_match($regexNomPrenom, $_POST["prenom"])){
			$prenomOK =false;
		}
			
		//verif mail
		if (isset($_POST["mail"]) && !preg_match($regexMail, $_POST["mail"])){
			$mailOK =false;
		}
			
		//verif mdp
		if (isset($_POST["mdp"]) && !preg_match($regexMdp, $_POST["mdp"])){
			$mdpOK =false;
		}
		//verification de la correspondance des mdp
		if (isset($_POST["mdp"]) && isset($_POST["mdpVerif"]) && $_POST["mdp"] != $_POST["mdpVerif"] ){
			$mdpVerif = false;
		}			
			
		// verification que le mail est unique
		if (isset($_POST["mail"]) ){
			$sql = "SELECT * FROM utilisateur";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch())
			{
				if (isset($_POST["mail"]) && $row['mail'] == $_POST["mail"] ){
					$mailUnique = false;
				}
				
			}							
		}
			 
		//verification de l'age 
		function age($date) { 
			$age = date('Y') - $date; 
			if (date('md') < date('md', strtotime($date))) { 
				return $age - 1; 
			} 
			return $age; 
		}
		if (isset($_POST["dateNaiss"]) && (age($_POST["dateNaiss"]) <= 15 || age($_POST["dateNaiss"])) >= 100 ){
			$ageOK = false;
		}
			

		//requete
		if (isset($_POST["prenom"]) && 
			isset($_POST["nom"]) &&
			isset($_POST["dateNaiss"]) &&
			isset($_POST["mail"]) &&
			isset($_POST["mdp"]) && 
			isset($_POST["mdpVerif"]) && 
			$prenomOK &&
			$nomOK &&
			$ageOK &&
			$mailOK &&
			$mdpOK &&
			$mdpVerif &&
			$mailUnique ){
				
			$mail = $_POST["mail"];
			$mdp = hash('sha256', $_POST["mdp"]);
			$prenom = $_POST["prenom"];
			$nom = $_POST["nom"];
			$dateNaiss = $_POST["dateNaiss"];
			$niveau = $_POST["gridRadios"];
			//generation aleatoire d'une clef
			$clef = md5(microtime(TRUE)*100000);
				
			//modification bd
			$sql = 'INSERT INTO utilisateur (attente,mail,mdp,niveau,prenom,nom,dateNaiss,clefActivation) VALUES (false,?,?,?,?,?,?,?)';
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$mail,$mdp,$niveau,$prenom,$nom,$dateNaiss,$clef]);
			
			$inscriptionValide = true;
			
				
				
			
		}	
		
		
		
		
		
	?>
		
	<!-- creer un nouvelle utilisateur -->
	<form class="cadre2 margin marge"  action="CreerAnimateur.php" method="POST">
		<!-- email -->
		<div class="form-group row">
			<label for="mail" class="col-sm-2 col-form-label">Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control <?php if(!$mailOK || !$mailUnique){ echo "is-invalid";}else if(isset($_POST["mail"]) && $mailOK){echo "is-valid";} ?>" id="mail" name="mail" placeholder="Email" <?php if (isset($_POST["mail"]) && $mailOK){echo "value = \"".$_POST["mail"]."\"";}?> required>
				<?php 
					if (isset($_POST["mail"]) && $mailOK ){
						echo '<div class="valid-feedback">Mail Correcte</div>';
					}
					if (!$mailOK){
						echo '<div class="invalid-feedback">Le mail est invalide, veuillez remplir un mail valide</div>';
					}
					if (!$mailUnique){
						echo '<div class="invalid-feedback">Un compte est déjà associé à ce mail</div>';
					}

				?>
			</div>
		</div>
		
		<!--mdp-->
		<div class="form-group row">
			<label for="mdp" class="col-sm-2 col-form-label">Mot de passe</label>
			<div class="col-sm-10">
				<input type="password" class="form-control <?php if (!$mdpOK){ echo "is-invalid";}else if (isset($_POST['mdp']) && $mdpOK){ echo "is-valid"; } ?>" id="mdp" name="mdp" placeholder="Mot de passe" required>
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
		
		<!--confirmation mdp -->
		<div class="form-group row">
			<label for="mdpVerif" class="col-sm-2 col-form-label">Confirmation Mot de passe</label>
			<div class="col-sm-10">
				<input type="password" class="form-control <?php if (!$mdpVerif){ echo "is-invalid";}else if (isset($_POST['mdpVerif']) && $mdpVerif){ echo "is-valid"; } ?>" id="mdpVerif" name="mdpVerif" placeholder="Confirmation Mot de passe" required>
						
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
		
		<!--nom -->
		<div class="form-group row">
			<label for="nom" class="col-sm-2 col-form-label">Nom</label>
			<div class="col-sm-10">
				<input type="text" class="form-control  <?php if(!$nomOK){ echo "is-invalid";}else if(isset($_POST["nom"]) && $nomOK){echo "is-valid";} ?>" id="nom" name="nom" placeholder="Nom"  <?php if(isset($_POST["nom"]) && $nomOK){echo "value = \"".$_POST["nom"]."\"";}?> required>
			
				<?php 
					if (isset($_POST["nom"]) && $nomOK ){
						echo '<div class="valid-feedback">Nom accepté</div>';
					}
					if (!$nomOK){
						echo '<div class="invalid-feedback">Nom non pris en charge</div>';
					}
				?>	
			</div>
		</div>
		
		<!--prenom-->
		<div class="form-group row">
			<label for="prenom" class="col-sm-2 col-form-label">Prenom</label>
			<div class="col-sm-10">
				<input type="text" class="form-control  <?php if(!$prenomOK){ echo "is-invalid";}else if(isset($_POST["prenom"]) && $prenomOK){echo "is-valid";} ?>" id="prenom" name="prenom" placeholder="Prenom" <?php if(isset($_POST["prenom"]) && $prenomOK){echo "value = \"".$_POST["prenom"]."\"";}?> required>
			
				<?php 
					if (isset($_POST["prenom"]) && $prenomOK ){
						echo '<div class="valid-feedback">Prenom accepté</div>';
					}
					if (!$prenomOK){
						echo '<div class="invalid-feedback">Prenom non pris en charge</div>';
					}
				?>		
			</div>
		</div>
		
		<!-- datte naiss -->
		<div class="form-group row">
			<label for="dateNaiss" class="col-sm-2 col-form-label">Date</label>
			<div class="col-sm-10">
				<input type="date" class="form-control <?php if(!$ageOK){ echo "is-invalid";}else if(isset($_POST["dateNaiss"]) && $ageOK){echo "is-valid";} ?>" id="dateNaiss" name="dateNaiss" <?php if(isset($_POST["dateNaiss"]) && $ageOK){echo "value = \"".$_POST["dateNaiss"]."\"";}?> required>
			
			
				<?php
					if (isset($_POST["dateNaiss"]) && $ageOK ){
						echo '<div class="valid-feedback">Date de daissance accepté</div>';
					}
					if (!$ageOK){
						echo '<div class="invalid-feedback">Le site est réservé au personnes de plus de 15 ans</div>';
					}
						
				?>
			</div>
		</div>
		
		<!-- admin ou animateur -->
		<fieldset class="form-group">
			<div class="row">
				<legend class="col-form-label col-sm-2 pt-0">Accreditation</legend>
				<div class="col-sm-10">
					<div class="form-check">
						<input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="2" <?php if(isset($_POST['gridRadios']) && $_POST['gridRadios'] == 3){}else{ echo 'checked';} ?> >
						<label class="form-check-label" for="gridRadios1">
							Animateur
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="3" <?php if(isset($_POST['gridRadios']) && $_POST['gridRadios'] == 3){ echo 'checked'; } ?>>
						<label class="form-check-label" for="gridRadios2">
							Admin
						</label>
					</div>
			
				</div>
			</div>
		</fieldset>
		
		<!--bouton -->
		<div class="form-group row">
			<div class="col-sm-10">
				<button type="submit" class="btn btn-primary">Ajouter</button>
			</div>
		</div>
		
		<?php
			if ($inscriptionValide){
		?>
				<div class="alert alert-success" role="alert">
					<h4 class="alert-heading">Bravo!</h4>
					<p>Vous avez crée un nouveau compte avec succés </p>
					<hr>
					<p class="mb-0">Vous pouvez maintenant vous connecter avec celui ci ou en creer un autre</p>
				</div>
		
		
		<?php 
			}
		?>
		
		
	</form>	
	
	
	


	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>
</body>
</html>