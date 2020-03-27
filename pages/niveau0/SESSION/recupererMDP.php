<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Recuperation de mot de passe</title>
		<!-- Lien vers boostrap -->
		<link href="../../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../../css/styleLog.css" rel="stylesheet">
		
		<!-- recapcha -->
		<script src="https://www.google.com/recaptcha/api.js"></script>
		
		

	</head>

	<body>

		<?php
			//declaration variable
			$mdpOK = true;
			$mdpVerif = true;
			$recuperationOK = false;
			$mdpChange = false;
			$clefCorrecte = false;
			
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
			
			//regex mdp
			$regexMdp ="#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,30}$#";
			
			//verif mdp
			if (isset($_POST["mdp"]) && !preg_match($regexMdp, $_POST["mdp"])){
				$mdpOK =false;
			}
			//verification de la correspondance des mdp
			if (isset($_POST["mdp"]) && isset($_POST["mdpVerif"]) && $_POST["mdp"] != $_POST["mdpVerif"] ){
				$mdpVerif = false;
			}
			//recuperation des variables Get
			if (isset($_GET['cle']) && isset($_GET['log'])){
				$mail = $_GET['log'];
				$clef = $_GET['cle'];
				$recuperationOK = true;
			}
			if (isset($_POST["mail"]) && isset($_POST["clef"]) ){
				$mail = $_POST["mail"];
				$clef = $_POST["clef"];
				$recuperationOK = true;
			}
			
			//determination si la clef de recuperation est valide 
			if ($recuperationOK){
				$sql = "SELECT * FROM utilisateur ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch())
				{
					if ($row['mail'] == $mail && $row['clefActivation'] == $clef){
						$clefCorrecte = true;				
					}

				}
				
			}	

			
			if ($clefCorrecte && isset($_POST["mdp"]) && isset($_POST["mdpVerif"]) && $mdpOK && $mdpVerif ){
				$sql = 'UPDATE utilisateur SET mdp = ? WHERE mail = ? AND clefActivation = ?';
				$stmt = $pdo->prepare($sql);
				$stmt->execute([hash('sha256',$_POST["mdp"]),$_POST["mail"],$_POST["clef"]]);
				$mdpChange = true;
				
				//changement de la clef pour ne pas être reutilisé 
				
				//generation aleatoire d'une clef
				$clef = md5(microtime(TRUE)*100000);
					
				//modification bd
				$sql = 'UPDATE utilisateur SET clefActivation = ? WHERE mail = ?';
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$clef,$mail]);
				
			}
			
		
		?>
		<div class="cadre ">
			<div id="formContent">
					
				<!-- titre -->
				<a class="active titre" href=""> Recuperation mot de passe</a>
				<a class="inactive underlineHover titre" href="connexion.php">Se connecter </a>
				
				</br></br></br>

				<!-- formulaire-->
				<form action =  "recupererMDP.php"  method="post">
				
					<?php
						if (!$clefCorrecte){
							echo "<div class=\" centrer\">Le lien que vous avez chargé n'était pas ou plus  fonctionnel, veuillez refaire une demande de modification de mot de passe </div>";
						}else if (!$mdpChange){
					?>
				
					<input type="password" id="mdp" <?php if (!$mdpOK){ echo "<div class = \"formulaireERR\" ";}?> name="mdp" placeholder="nouveau mot de passe" required>
					<?php
						if (!$mdpOK){
							echo " <div class=\" txtERR\">Le mot de passe est invalide, il doit au moins contenir une majuscule, une minuscule, un chiffre et 8 caractères en tout</div>";
						}
					?>
					<input type="password" id="mdpVerif" <?php if (!$mdpVerif){ echo "<div class = \"formulaireERR\" ";}?> name="mdpVerif" placeholder="Verification de mot de passe" required>
					<?php
						if (!$mdpVerif){
							echo " <div class=\" txtERR\">Les mots de passe ne correspondent pas</div>";
						}
					?>
					<input type="HIDDEN" id="mail"  name="mail" <?php echo "value = \"".$mail."\""; ?>   >
					<input type="HIDDEN" id="clef"  name="clef" <?php echo "value = \"".$clef."\""; ?>   >
					<input type="submit" class="boutonVert" value="       Changer de mot de passe       ">
					
					<?php
							
						}else{
							echo "<div class=\" centrer\">Le mot de passe a été changé </div>";
							
						}
					?>


				</form>
				
				</br></br></br>
				
				<!-- Mot de passe oublié -->
				<div id="formFooter">
				   <a class="underlineHover" href="../../../index.php">Accueil</a>
				</div>

			</div>
		</div>
		
	  
	</body>
</html>