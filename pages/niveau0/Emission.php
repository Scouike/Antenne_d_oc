<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Emission</title>
		<!-- Lien vers boostrap -->
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
			
			if (isset($_SESSION['level']) && $_SESSION['level']==1) {
				include('../bareNav/barreNavUtilisateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				/* inclu une barre de navigation */
				include('../bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==3) {
				/* inclu une barre de navigation */
				include('../bareNav/barreNavAdmin.html');
			}else{
				/* inclu une barre de navigation */
				include('../bareNav/barreNav.html'); 
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
			if($_GET["titre"]!=""){
				Echo '<h1 class="text-uppercase m-4 text-center"> Emission : '.$_GET["titre"].' </h1>';
				$sql="SELECT *
					FROM Theme AS T 
					JOIN liason AS L 
					ON T.id_theme = L.id_theme
					JOIN emission AS E
					ON L.id_emission = E.id_emission
					AND titre = ?";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(array($_GET["titre"]));
			}else{
				Echo '<h1 class="text-uppercase m-4 text-center"> Aucun titre transmis </h1>';
			}
		?>
	<div class="margin">
		<table class="table table-striped ">
			<?php	
			//On analyse toutes les émissions disponibles dans un thème
				While( $ligne = $stmt->fetch() ) {	
					echo'<tr>
						<td>'.$ligne["nom"].'</td>
						<td>'.$ligne["texte"].'</td>
						<tr>';
					$podcast="SELECT son,image,texte
							From Podcast
							Where id_Emission = ?";
					$requete = $pdo->prepare($podcast);
					$requete->execute(array($ligne["id_emission"]));
					//On analyse tout les podcast liées aux émissions
					While($analyse = $requete->fetch()){
						//On crée des liens pour aller sur la page du podcast sur laquelle on pourra écouter et télécharger celui-ci
						echo'<td>
								<a href="Podcast.php?son='.$analyse["son"].'&theme='.$ligne["titre"].'">'.basename($analyse["son"]).'</a>
							</td>';
					}
					echo'</tr></tr>';
				}
			?>
		</table>
	</div>

	<!-- Footer -->
	<?php   
			include('../footeur/footeurs.html'); 
	?>
		
	</body>
	
</html>
