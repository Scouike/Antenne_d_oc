<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Connexion</title>
		<!-- Lien vers boostrap -->
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../css/styleLog.css" rel="stylesheet">
		

	</head>

	<body>


		
		<div class="cadre ">
			<div id="formContent">
					<?php
					/* si le formulaire a deja été remplie et qu'il est correct cela va changer la page */
					
					if (isset($_POST['pseudo']) && isset($_POST['mdp'])){
						
						if ($_POST['pseudo'] == $_POST['mdp'] && $_POST['mdp'] == "admin" ){
							/* on declare une variable de session qui nous servira à identifier le type d'utilisateur */
							 $_SESSION['type'] = 'admin';
							 $message = '<p>Bienvenue admin, 
										vous êtes maintenant connecté!</p>
										<p>Cliquez <a href="../index.php">ici</a> 
											pour revenir à la page d accueil</p>'; 
							echo $message.'</body></html>';
						}else if ($_POST['pseudo'] == $_POST['mdp'] && $_POST['mdp'] == "animateur" ){
							/* on declare une variable de session qui nous servira à identifier le type d'utilisateur */
							 $_SESSION['type'] = 'animateur';
							 $message = '<p>Bienvenue animateur, 
										vous êtes maintenant connecté!</p>
										<p>Cliquez <a href="../index.php">ici</a> 
											pour revenir à la page d accueil</p>'; 
							echo $message.'</div></div></body></html>';
						}
					}else {
				
				?>
				<!-- titre -->
				<a class="active titre" href=""> Se connecter</a>
				<a class="inactive underlineHover titre" href="inscription.php">S'inscrire </a>
				


				<!-- formulaire-->
				<form action =  "connexion.php"  method="post">
				  <input type="text" id="pseudo"  name="pseudo" placeholder="pseudo">
				  <input type="password" id="mdp"  name="mdp" placeholder="mot de passe">
				  
				  
				  <input type="submit" class="boutonVert" value="Connexion">
				</form>

				<!-- Mot de passe oublié -->
				<div id="formFooter">
				  <a class="underlineHover" href="#">Mot de passe oublié?</a>
				</div>

			</div>
		</div>
		
					<?php } ?>
	  
	</body>
</html>