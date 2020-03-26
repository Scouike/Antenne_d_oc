<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">	
	<head>
		<meta charset="utf-8">
		<title>Nosfrequences FM</title>
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
						<img  class= "img-fluid imageGrande" src="../../images/couverture_AOC.jpg">
					</div>
				</div>
			</div>


		<!-- Footer -->
		<?php   
				include('footeurs.html'); 
		?>		
		  
	</body>

</html>