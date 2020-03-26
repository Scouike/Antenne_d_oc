<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">	
	<head>
		<meta charset="utf-8">
		<title>Qui sommes nous</title>
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
			//Barre de navigation 
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
		?>
		<div class="container cadreAvecBordure ">
			<div class="row">
				<div class="col-md-12">
					<h1>Qui sommes-nous?</h1>
				</div>
				<div class="col-md-12">
					<h4>
						Qui sommes-nous ? Antenne d'Oc est une radio associative qui émet
						depuis 1993 sur le Lot, une radio sans pub, une radio locale. Nous
						sommes avant toute chose un service de communication sociale de
						proximité, un service pour vous, pour vos concitoyens, pour vos
						associations et pour les collectivités locales. Ce service est
						gratuit afin que tous, nous puissions l'utiliser. <br />
						<br /> Nous sommes aussi une association, qui, comme toutes les
						autres, a besoin d'adhérents, de bénévoles et de nombreuses bonnes
						volontés pour fonctionner. Nous sommes un outil d'expression fait
						pour tous et qu'il ne tient qu'à vous d'utiliser. <br />
						<br />De nos jours, les technologies les plus modernes sont à la
						portée du « grand public », mais l'information et la communication
						audiovisuelle restent la propriété de grands groupes financiers,
						donc d'une toute petite minorité. C'est pour lutter modestement
						contre cet état de fait qu'Antenne d'Oc vous ouvre ses micros. <br />
						<br />Nous intervenons dans le milieu scolaire à la demande des
						établissements, nous soutenons toutes les actions éducatives et
						culturelles, les luttes contre les discriminations, la protection de
						l'environnement et l'aide au développement. Venez nous rejoindre,
						faites-nous connaître autour de vous, et en attendant... <br />
						BONNE ÉCOUTE !...
					</h4>
				</div>
			</div>
		</div>
		

	<!-- Footer -->
	<?php   
			include('footeurs.html'); 
	?>
	  
	</body>
</html>