<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Connexion</title>
		<!-- Lien vers boostrap -->
		<link href="../../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../../css/styleLog.css" rel="stylesheet">
		
		<!-- recapcha -->
		<script src="https://www.google.com/recaptcha/api.js"></script>
		
		

	</head>

	<body>
		<?php
			//declaration des variables
			$reCapcha = true;
			$mdpSaisie = true;
			$mailSaisie = true;
			$champCorrecte = true;
			$conecte = false;
				
			//capcha
			require '../../../recapcha/recaptcha.php';
			$clef_publique = '6LfiFNUUAAAAAGR6dA-YZmCRvrn3UJJBZ44URp2O';
			$clef_secrete = '6LfiFNUUAAAAAFVym_YEI3RNt4bki45CzpE-nUYD';
			
			$reCaptcha = new ReCaptcha($clef_secrete);
			if(isset($_POST["g-recaptcha-response"])) {
				$resp = $reCaptcha->verifyResponse(
					$_SERVER["REMOTE_ADDR"],
					$_POST["g-recaptcha-response"]
					);
				if ($resp != null && $resp->success) {
					$reCapcha = true;
				}else {
					$reCapcha = false;
				}
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
			
			//verification mdp et mail
			if (isset($_POST["mail"]) && strlen($_POST["mail"])== 0){
				$mailSaisie = false;
			}
			
			if (isset($_POST["mdp"]) && strlen($_POST["mdp"])== 0){
				$mdpSaisie = false;
			}
			
			//connexion
			if ($reCapcha && $mailSaisie &&  $mdpSaisie && isset($_POST["mail"]) && isset($_POST["mdp"]) ){
				$champCorrecte = false;
				$sql = "SELECT * FROM utilisateur ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch())
				{
					
					if ($row['mail'] == $_POST["mail"] && $row['mdp'] == hash('sha256',$_POST["mdp"]) && $row['attente'] == 0){
						$champCorrecte = true;
						$conecte = true;
						$_SESSION['prenom'] = $row['prenom'];
						$_SESSION['level'] = $row['niveau'];
						$_SESSION['id'] = $row['id_utilisateur'];
					}

				}		
				
			}
		
		
		?>

		
		<div class="cadre ">
			<div id="formContent">
					
				<!-- titre -->
				<a class="active titre" href=""> Se connecter</a>
				<a class="inactive underlineHover titre" href="inscription.php">S'inscrire </a>
				


				<!-- formulaire-->
				<form action =  "connexion.php"  method="post">
				
					<?php
						if (!$conecte) {
					?>
							<input type="email" id="mail" <?php if (!$champCorrecte || !$mailSaisie ){ echo "<div class = \"formulaireERR\" ";}?> name="mail" placeholder="mail" <?php if (isset($_POST["mail"]) && $mailSaisie && $champCorrecte){echo "value = \"".$_POST["mail"]."\"";}?> required>
								<?php
									if (!$mailSaisie){
										echo " <div class=\" txtERR\">Veuillez saisir votre mail</div>";
									}

								?>
							<input type="password" id="mdp" <?php if (!$champCorrecte || !$mdpSaisie ){ echo "<div class = \"formulaireERR\" ";}?> name="mdp" placeholder="mot de passe" required>
								<?php
									if (!$mdpSaisie){
										echo " <div class=\" txtERR\">Veuillez saisir votre mot de passe</div>";
									}
									if (!$champCorrecte){
										echo " <div class=\" txtERR\">Le mot de passe ou le mail sont invalides, veuillez recommencer</div>";
									}
								
								?>
							<div class="centrer g-recaptcha" data-sitekey="<?php echo $clef_publique;?>"></div>
								<?php
									if(!$reCapcha){
										echo " <div class=\" txtERR\">Veuillez valider le reCapcha</div>";
									}
								?>
							<input type="submit" class="boutonVert" value="Connexion">
					<?php
						}else{
							echo "<div class=\" centrer\">Bravo ".$_SESSION['prenom']." vous etes bien connecté et vous avez un pass de niveau ".$_SESSION['level']." </div>";
						}
					?>
				</form>

				<!-- Mot de passe oublié -->
				<div id="formFooter">
				  <?php
					if (!$conecte) {
				   ?>
					<a class="underlineHover" href="mdpOubli.php">Mot de passe oublié?</a>
				  <?php
					}else{
						
				   ?>
				   <a class="underlineHover" href="../../../index.php">Accueil</a>
				  <?php
				  
				    }
					
				  ?>
				</div>

			</div>
		</div>
		
	  
	</body>
</html>