<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Rubriques</title>
		<!-- Lien vers boostrap -->
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../fontawesome/css/all.css" rel="stylesheet" >
		
		<!-- script boostrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>

	<body>

		 
		<!-- Barre de navigation --> 
		<?php   
			if (isset($_SESSION['type']) && $_SESSION['type']=="animateur") {
				include('bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['type']) && $_SESSION['type']=="admin") {
				include('bareNav/barreNavAdmin.html');
			}else{
				include('bareNav/barreNav.html'); 
			}
		?>
		<!-- DIfférents thème d'émission -->
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-6">
					<div class="polaroid">
						<a href="Emission.php"><div class="image" style="background-image:url(../images/nature.jpg)"><img src="../images/nature.jpg" alt="" /></div>
						<div class="polatxt">
							<p>Nature</p>
						</div></a>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="polaroid">
						<a href="Emission.php"><div class="image" style="background-image:url(../images/reggae.png)"><img src="../images/reggae.png" alt="" /></div>
						<div class="polatxt">
							<p>Reggae</p>
						</div></a>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="polaroid">
						<a href="Emission.php"><div class="image" style="background-image:url(../images/culture.jpg)"><img src="../images/culture.jpg" alt="" /></div>
						<div class="polatxt">
							<p>Culture</p>
						</div> </a>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="polaroid">
						<a href="Emission.php"><div class="image" style="background-image:url(../images/cuisine.jpg)"><img src="../images/cuisine.jpg" alt="" /></div>
						<div class="polatxt">
							<p>Cuisine</p>
						</div> </a>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="polaroid">
						<a href="Emission.php"><div class="image" style="background-image:url(../images/automobile.jpg)"><img src="../images/automobile.jpg" alt="" /></div>
						<div class="polatxt">
							<p>Automobile</p>
						</div> </a>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="polaroid">
						<a href="Emission.php"><div class="image" style="background-image:url(../images/politique.jpg)"><img src="../images/politique.jpg" alt="" /></div>
						<div class="polatxt">
							<p>Politique</p>
						</div></a>
					</div>
				</div>
			</div>
		</div>
	<!-- Footer -->
	<?php   
		include('footeur/footeurs.html'); 
	?>
		
	</body>

	
</html>