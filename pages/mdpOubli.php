<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Mot de passe oublié</title>
		<!-- Lien vers boostrap -->
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../css/styleLog.css" rel="stylesheet">
		
		<!-- recapcha -->
		<script src="https://www.google.com/recaptcha/api.js"></script>
		
		

	</head>

	<body>
		<?php
			
			//variables
			$mailInexistant = false;
			$envoimailOK = false;
			
			//fonction envoie du mail
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
			
			//connexion
			if (isset($_POST["mail"])){
				$mailInexistant = true;
				$sql = "SELECT * FROM utilisateur ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				while ($row = $stmt->fetch())
				{
					if ($row['mail'] == $_POST["mail"] && $row['attente'] == 0){
						$mailInexistant = false;
						$envoimailOK = true;
					}
				}				
			}
			
			//envoie de mail 
			if ($envoimailOK){
				$mail = $_POST["mail"];
				
				//generation aleatoire d'une clef
				$clef = md5(microtime(TRUE)*100000);
					
				//modification bd
				$sql = 'UPDATE utilisateur SET clefActivation = ? WHERE mail = ?';
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$clef,$mail]);
				
				$subject = "Recuperer mot de passe " ;
				$body = 'Bonjour,
						 
						Vous avez demandé une récupération de mot de passe cliquer, sur le liens pour le réinitialiser. Si vous n\'etes 
						pas à l\'origine de ce mail veuillez l\'ignorer.
						 
						</br></br></br> 
						http://localhost/ProjetRadioGit/ProjetRadioPhp/pages/recupererMDP.php?log='.urlencode($mail).'&cle='.urlencode($clef).'
						 
						</br></br></br>
						---------------
						Ceci est un mail automatique, Merci de ne pas y répondre.';
				
				envoieMail($mail,$subject,$body);
				
			}
			
		
		?>

		
		<div class="cadre ">
			<div id="formContent">
					
				<!-- titre -->
				<a class="active titre" href=""> Mot de passe oublié</a>
				<a class="inactive underlineHover titre" href="connexion.php">Se connecter </a>
				


				<!-- formulaire-->
				<form action =  "mdpOubli.php"  method="post">
				
					<?php
						if(!$envoimailOK){
					?>
					<div class = "centrer" >Pour changer votre mot de passe veuillez renseigner votre adresse mail</div>
					<input type="email" id="mail" <?php if ($mailInexistant){ echo "<div class = \"formulaireERR\" ";}?> name="mail" placeholder="mail" required>
					<?php
						if ($mailInexistant){
							echo " <div class=\" txtERR\">Aucun compte n'est associé à cette email</div>";
						}
						
						}else{
							echo "<div class=\" centrer\">Un mail vous a été envoyé </div>";
						}
					?>
					<input type="submit" class="boutonVert" value="       Recuperer mot de passe       ">
				</form>

				<!-- Mot de passe oublié -->
				<div id="formFooter">
				   <a class="underlineHover" href="../index.php">Accueil</a>
				</div>

			</div>
		</div>
		
	  
	</body>
</html>