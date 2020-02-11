<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Inscription</title>
		<!-- Lien vers boostrap -->
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../css/styleLog.css" rel="stylesheet">
		
		<!-- recapcha -->
		<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>

	<body>
	
		<?php
			//Declaration des variables
			$pseudoOK = true;
			$mailOK = true;
			$mdpOK = true;
			$mdpVerif = true;
			$reCapcha = true;
			$mailUnique = true;
			$pseudoUnique = true;
			
			
			//capcha
			require '../recapcha/recaptcha.php';
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
			
			//verification des formats
			$regexPseudo = "/^([a-zA-Z'àâéèêôùûçÀÂÉÈÔÙÛÇ[:blank:]-]{1,25})$/";
			$regexMail ="/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
			$regexMdp ="#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,30}$#";
			 
			if (isset($_POST["pseudo"]) && !preg_match($regexPseudo, $_POST["pseudo"])){
				$pseudoOK =false;
			}
			
			if (isset($_POST["mail"]) && !preg_match($regexMail, $_POST["mail"])){
				$mailOK =false;
			}
			
			if (isset($_POST["mdp"]) && !preg_match($regexMdp, $_POST["mdp"])){
				$mdpOK =false;
			}
			//verification de la correspondance des mdp
			if (isset($_POST["mdp"]) && isset($_POST["mdpVerif"]) && $_POST["mdp"] != $_POST["mdpVerif"] ){
				$mdpVerif = false;
			}			
			
			// verification que l'utilisateur et le mail sont unique
			if (isset($_POST["mail"]) || isset($_POST["pseudo"]) ){
				$sql = "SELECT * FROM utilisateur";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch())
				{
					if (isset($_POST["mail"]) && $row['mail'] == $_POST["mail"] ){
						$mailUnique = false;
					}
					
					if (isset($_POST["pseudo"]) && $row['pseudo'] == $_POST["pseudo"] ){
						$pseudoUnique = false;
					}
					
				}							
			}
			

			//requete
			if (isset($_POST["pseudo"]) && 
				isset($_POST["mail"]) &&
				isset($_POST["mdp"]) && 
				isset($_POST["mdpVerif"]) && 
				$pseudoOK &&
				$mailOK &&
				$mdpOK &&
				$mdpVerif &&
				$reCapcha &&
				$mailUnique &&
				$pseudoUnique ){
					
				$mail = $_POST["mail"];
				$mdp = hash('sha256', $_POST["mdp"]);
				$pseudo = $_POST["pseudo"];
					
				$sql = 'INSERT INTO utilisateur (attente,mail,mdp,niveau,pseudo) VALUES (false,?,? ,1,?)';
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$mail,$mdp,$pseudo]);
				
			
			}
					
		
		?>

		
		<div class="cadre ">
			<div id="formContent">
				<!-- titre -->
				<a class = "inactive underlineHove titre"  href="connexion.php"> Se connecter</a>
				<a class = "active titre"  href=""> S'inscrire</a>



				<!-- formulaire-->
				<form action="inscription.php" method="POST">
				
					<input type="text" id="pseudo" <?php if (!$pseudoOK || !$pseudoUnique){ echo "<div class = \"formulaireERR\" ";}?> name="pseudo" placeholder="pseudo" <?php if (isset($_POST["pseudo"]) && $pseudoOK){echo "value = \"".$_POST["pseudo"]."\"";}?>>
					<?php
						if (!$pseudoOK){
							echo " <div class=\" txtERR\">Le pseudo n'est pas valide il doit faire entre 1 et 25 charcatere</div>";
						}
						if (!$pseudoUnique){
							echo " <div class=\" txtERR\">Ce pseudo est déja pris veuillez en trouver un autre</div>";
						}
					?>
					<input type="email" id="mail" <?php if (!$mailOK || !$mailUnique){ echo "<div class = \"formulaireERR\" ";}?> name="mail" placeholder="mail" <?php if (isset($_POST["mail"]) && $mailOK){echo "value = \"".$_POST["mail"]."\"";}?>>
					<?php
						if (!$mailOK){
								echo " <div class=\" txtERR\">Le mail est invalide veuillez remplir un mail valide</div>";
						}
						if (!$mailUnique){
							echo " <div class=\" txtERR\">Un compte est déjà associé à ce compte</div>";
						}
					?>
					<input type="password" id="mdp" <?php if (!$mdpOK){ echo "<div class = \"formulaireERR\" ";}?> name="mdp" placeholder="mot de passe">
					<?php
						if (!$mdpOK){
							echo " <div class=\" txtERR\">Le mot de passe est invalide il doit au minimum avoir une majuscule, une minuscule et 8 characteres</div>";
						}
					?>
					<input type="password" id="mdpVerif" <?php if (!$mdpVerif){ echo "<div class = \"formulaireERR\" ";}?> name="mdpVerif" placeholder="Verification de mot de passe">
					<?php
						if (!$mdpVerif){
							echo " <div class=\" txtERR\">Les mots de passe ne sont pas identique</div>";
						}
					?>
					<div class="centrer g-recaptcha" data-sitekey="<?php echo $clef_publique;?>"></div>
					<?php
						if (!$reCapcha){
							echo " <div class=\" txtERR\">Veuillez remplir le Recapcha</div></br>";
						}
					?>
					<input type="submit" class="boutonVert"  value="Connexion">
				</form>



			</div>
		</div>
	  
	</body>
</html>