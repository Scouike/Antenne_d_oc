<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Inscription</title>
		<!-- Lien vers boostrap -->
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../css/styleLog.css" rel="stylesheet">
		

	</head>

	<body>

		
		<div class="cadre ">
			<div id="formContent">
				<!-- titre -->
				<a class = "inactive underlineHove titre"  href="connexion.php"> Se connecter</a>
				<a class = "active titre"  href=""> S'inscrire</a>



				<!-- formulaire-->
				<form>
					<input type="text" id="nom"  name="nom" placeholder="nom">
					<input type="text" id="prenom"  name="prenom" placeholder="prenom">
					<input type="text" id="pseudo"  name="pseudo" placeholder="pseudo">
					<input type="email" id="mail"  name="mail" placeholder="mail">
					<input type="tel" id="tel"  name="tel" placeholder="télephone">
					<!-- date naissance <input type="date" id="date"  name="date" placeholder="date de naissance"> -->
					<input type="submit" class="boutonVert"  value="Connexion">
				</form>



			</div>
		</div>
	  
	</body>
</html>