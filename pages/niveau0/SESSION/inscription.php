<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../../PHPMailer-master/src/Exception.php';
require '../../../PHPMailer-master/src/PHPMailer.php';
require '../../../PHPMailer-master/src/SMTP.php';

?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Inscription</title>
		<!-- Lien vers boostrap -->
		<link href="../../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../../css/styleLog.css" rel="stylesheet">
		
		<!-- recapcha -->
		<script src="https://www.google.com/recaptcha/api.js"></script>
	</head>

	<body>
	
		<?php
		
			//envoie de mail 
			function envoieMail($destinataire,$subject,$body){
				// Instantiation and passing `true` enables exceptions
				$mail = new PHPMailer(true);
				$mail->SMTPOptions = array('ssl' =>  
				   array( 
					  'verify_peer' => false, 
					  'verify_peer_name' => false, 
					  'allow_self_signed' => true));

				try {
					//Server settings
					$mail->isSMTP();                                            // Send using SMTP
					$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
					$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
					$mail->Username   = 'mathieuzenonetutomail@gmail.com';                     // SMTP username
					$mail->Password   = 'Ef7McERA';                               // SMTP password
					$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
					$mail->Port       = 587;                                    // TCP port to connect to

					//Recipients
					$mail->setFrom('mathieuzenonetutomail@gmail.com', 'Radio Antenne d\'Oc');
					$mail->addAddress($destinataire, 'Joe User');     // Add a recipient
					
					// Content
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = $subject;
					$mail->Body    = $body;
					$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

					$mail->send();
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}
			}
		
		
		
		
			//Declaration des variables
			$nomOK = true;
			$prenomOK = true;
			$ageOK = true;
			$mailOK = true;
			$mdpOK = true;
			$mdpVerif = true;
			$reCapcha = true;
			$mailUnique = true;
			$inscriptionValide = false;
			
			
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
			if (isset($_POST["dateNaiss"]) && (age($_POST["dateNaiss"]) < 15 || age($_POST["dateNaiss"]) >= 100) ){
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
				$reCapcha &&
				$mailUnique ){
					
				$mail = $_POST["mail"];
				$mdp = hash('sha256', $_POST["mdp"]);
				$prenom = $_POST["prenom"];
				$nom = $_POST["nom"];
				$dateNaiss = $_POST["dateNaiss"];
				//generation aleatoire d'une clef
				$clef = md5(microtime(TRUE)*100000);
				//donne la date + 1 semaine
				$dateSupr = date("Y-m-d");
				$dateSupr = date("Y-m-d",strtotime(date("Y-m-d", strtotime($dateSupr)) . " +1 week"));	
				//modification bd
				$sql = 'INSERT INTO utilisateur (attente,mail,mdp,niveau,prenom,nom,dateNaiss,clefActivation,dateSupr) VALUES (true,?,? ,1,?,?,?,?,?)';
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$mail,$mdp,$prenom,$nom,$dateNaiss,$clef,$dateSupr]);
				
				//envoie du mail
				$subject = "Activer votre compte" ;
				$body = 'Bienvenue sur Anthene d\'Oc,
						 
						Pour activer votre compte, veuillez cliquer sur le lien ci-dessous
						ou copier/coller dans votre navigateur Internet.
						 </br></br></br>
						http://localhost/ProjetRadioGit/ProjetRadioPhp/pages/niveau0/SESSION/activation.php?log='.urlencode($mail).'&cle='.urlencode($clef).'
						 
						</br></br></br>
						---------------
						Ceci est un mail automatique, Merci de ne pas y répondre.';
				
				envoieMail($mail,$subject,$body);
				
				
				
				
				
				
				
				$inscriptionValide = true;
				
				
				
			
			}
					
		
		?>

		
		<div class="cadre ">
			<div id="formContent">
				<!-- titre -->
				<a class = "inactive underlineHove titre"  href="connexion.php"> Se connecter</a>
				<a class = "active titre"  href=""> S'inscrire</a>

				<?php
					if ($inscriptionValide){
						
						echo "<div class=\" centrer\">Bravo votre inscription a été prise en compte, veuillez maintenant activer votre compte en cliquant sur le lien qui vous a été envoyé, merci. </div>";
						echo " <a class=\"underlineHover\" href=\"../../../index.php\">Accueil</a>";
					}else{
						
				?>
				
				<!-- formulaire-->
				<form action="inscription.php" method="POST">
				
					<input type="text" id="prenom" <?php if (!$prenomOK ){ echo "<div class = \"formulaireERR\" ";}?> name="prenom" placeholder="prenom" <?php if (isset($_POST["prenom"]) && $prenomOK){echo "value = \"".$_POST["prenom"]."\"";}?> required>
					<?php
						if (!$prenomOK){
							echo " <div class=\" txtERR\">Le prenom n'est pas valide il doit faire entre 1 et 25 charcatere</div>";
						}
						
					?>
					
					<input type="text" id="nom" <?php if (!$nomOK){ echo "<div class = \"formulaireERR\" ";}?> name="nom" placeholder="nom" <?php if (isset($_POST["nom"]) && $nomOK){echo "value = \"".$_POST["nom"]."\"";}?> required>
					<?php
						if (!$nomOK){
							echo " <div class=\" txtERR\">Le nom n'est pas valide il doit faire entre 1 et 25 caractères</div>";
						}
						
					?>
					
					<input type="date" id="dateNaiss" <?php if (!$ageOK){ echo "<div class = \"formulaireERR\" ";}?> name="dateNaiss" min="1900-00-01" max="2200-00-01" required >
					<?php
						if (!$ageOK){
							echo " <div class=\" txtERR\">Le site est réservé au personnes de plus de 15 ans</div>";
						}
						
					?>
					
					
					<input type="email" id="mail" <?php if (!$mailOK || !$mailUnique){ echo "<div class = \"formulaireERR\" ";}?> name="mail" placeholder="mail" <?php if (isset($_POST["mail"]) && $mailOK){echo "value = \"".$_POST["mail"]."\"";}?> required>
					<?php
						if (!$mailOK){
								echo " <div class=\" txtERR\">Le mail est invalide, veuillez remplir un mail valide</div>";
						}
						if (!$mailUnique){
							echo " <div class=\" txtERR\">Un compte est déjà associé à ce mail</div>";
						}
					?>
					<input type="password" id="mdp" <?php if (!$mdpOK){ echo "<div class = \"formulaireERR\" ";}?> name="mdp" placeholder="mot de passe" required>
					<?php
						if (!$mdpOK){
							echo " <div class=\" txtERR\">Le mot de passe est invalide, il doit au minimum avoir une majuscule, une minuscule, un chiffre et 8 caractères en tout</div>";
						}
					?>
					<input type="password" id="mdpVerif" <?php if (!$mdpVerif){ echo "<div class = \"formulaireERR\" ";}?> name="mdpVerif" placeholder="Verification de mot de passe" required>
					<?php
						if (!$mdpVerif){
							echo " <div class=\" txtERR\">Les mots de passe ne correspondent pas</div>";
						}
					?>
					<div class="centrer g-recaptcha" data-sitekey="<?php echo $clef_publique;?>"></div>
					<?php
						if (!$reCapcha){
							echo " <div class=\" txtERR\">Veuillez remplir le Recapcha</div></br>";
						}
					?>
					<input type="submit" class="boutonVert"  value="Inscription">
				</form>
				
				<?php
					}
				?>


			</div>
		</div>
	  
	</body>
</html>