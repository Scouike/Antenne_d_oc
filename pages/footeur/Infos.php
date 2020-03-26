<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">	
	<head>
		<meta charset="utf-8">
		<title>Infos</title>
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
					<h1>Un peu d'histoire</h1>
					<h4>En 1989, après avoir brillement fêté le bicentenaire de la
						Révolution, quelques amis s'interrogent sur la possibilité de
						développer les nouvelles technologies de communication dans notre
						milieu rural, de leur questionnement va naître l'association
						Multi-Com. <br/> <br/>
						Quand, au début des années 1990, le Conseil Supérieur de
						l'Audiovisuel (CSA) lance un appel à candidatures de radiodiffusion
						en Midi-Pyrénées, il n'y a plus de radio locale associative dans le
						Lot, toutes ont été récupérées, rachetées, par des radios
						commerciales.<br/> <br/>
						 Consciente du grand vide médiatique laissé par ces
						disparitions, Multi-Com dépose un dossier de candidature en décembre
						1991, la chaîne publique de télévision Antenne 2 vient de changer de
						nom, l'association décide alors d'appeler Antenne d'Oc, la future
						radio locale. <br/>
						Seize mois plus tard, le 23 mai 1993, la décision du
						CSA est publié au Journal Officiel et Antenne d'Oc obtient 2
						fréquences, 89 MHz à Trespoux et 93,7 MHz au Boulvé. Vingt ans plus
						tard, Antenne d'Oc regroupe 3 studios, emploie 11 personnes et
						diffuse sur tout le département avec 10 émetteurs.</h4>
				</div>
			</div>
		</div>
				
<!-- Footer -->
	<?php   
			include('footeurs.html'); 
	?>	  
</body>

</html>