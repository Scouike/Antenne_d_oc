<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Activation</title>
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
			$mail;
			$clef;
			$recuperationOK = false;
			$compteDejaActive = false;
			$compteExistant = false;
			$compteActif =false;
			
	
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
			
			//recuperation des variables pour l'activations
			if (isset($_GET['cle']) && isset($_GET['log'])){
				$mail = $_GET['log'];
				$clef = $_GET['cle'];
				$recuperationOK = true;
			}
			
			//comparaison des param avec la bd
			if ($recuperationOK){
				$sql = "SELECT * FROM utilisateur ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch())
				{
					if ($row['mail'] == $mail && $row['clefActivation'] == $clef){
						$compteExistant = true;
						if ($row['attente'] != 1){
							$compteDejaActive = true;
						}
							
					}

				}
				
			}
			
			//activation du compte dans la bd
			if ($compteExistant){
				$sql = "UPDATE utilisateur SET attente = 0 WHERE mail like ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$mail]);
				$compteActif = true;
				
			}
		
		
		?>

		
		<div class="cadre ">
			<div id="formContent">
					
				<!-- titre -->
				<a class="active titre" href=""> Validation de compte</a>
				<a class="inactive underlineHover titre" href="connexion.php">Se connecter </a>
				


				<!-- formulaire-->
				<form action =  "activation.php"  method="post">
				
				<?php 			
					if(!$recuperationOK){
						echo "<div class=\" centrer\">Il y a eu une erreur lors de la recuperation des données veuillez recommencer </div>";
					}else if(!$compteExistant){
						echo "<div class=\" centrer\">Le compte à valider n'existe pas </div>";
					}else if($compteDejaActive){
						echo "<div class=\" centrer\">Votre compte est déjà actif vous pouvez vous connecter </div>";
					}else if($compteActif){
						echo "<div class=\" centrer\">Bravo vous avez reussi à valider votre compte vous pouvez maintenant vous connecter ou revenir à l'accueil </div>";
					}
					
				?>
				</form>

				<!-- Mot de passe oublié -->
				<div id="formFooter">
				   <a class="underlineHover" href="../../../index.php">Accueil</a>
				</div>

			</div>
		</div>
		
	  
	</body>
</html>