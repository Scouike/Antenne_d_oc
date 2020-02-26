<!-- demare une session -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Acceuil</title>
		<!-- Lien vers boostrap -->
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="fontawesome/css/all.css" rel="stylesheet" >
		
		<!-- script boostrap -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>

	<body>

		<!-- Barre de navigation regarde si une seesion existe et si oui determine si c'est une session admin ou utilisateur--> 
		<?php   
			if (isset($_SESSION['level']) && $_SESSION['level']==1) {
				/* inclu une barre de navigation */
				include('pages/bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				/* inclu une barre de navigation */
				include('pages/bareNav/barreNavAdmin.html');
			}else{
				/* inclu une barre de navigation */
				include('pages/bareNav/barreNav.html'); 
			}
		?>
		
			<p class="cadre2"> Les fréquences : Bretenoux 89.0 &nbsp; Cahors 88.1 &nbsp; Cahors sud
				89.0 &nbsp; Cazals 88.8 &nbsp;Figeac 88.1 &nbsp; Gourdon 105.3
				&nbsp; Labastide-Murat 104.1 &nbsp;  Montcuq 88.8 &nbsp; Prayssac
				93.7 &nbsp; Souillac 100.3 <br />
		</p>
	<div class=" cadre2 decalageGauche">
		<div class="row">
			<div class="col">
				<img src="images/Logo.png" class="img-fluid logo" alt="Image Emission">
			</div>

			<div class="col">
				<div class="row">
					<div class="col">LA DATE</div>
					<div class="col">AUTEUR</div>
				</div>
				<div class="row">
					<div class="col"><h3>Texte descriptif du podcast</h3></div>
				</div>
				<div class="row">
					<div class="col"><figure>
						<figcaption>Ecouter le podcast : 	</figcaption>
						<audio controls src="lien_audio">Your browser does not support the<code>audio</code> element.</audio> 
						</figure>
					</div>
					<div class="col">
						<br/>
						<button type="button" class="btn btn-outline-success">Télécharger</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class=" cadre2 decalageGauche">
		<div class="row">
			<div class="row">
				<div class="col mini-box"><h3>&nbsp; &nbsp; Texte descriptif du podcast</h3></div>
			</div>
			<div class="col">
				<div class="row">
					<div class="col mini-box">LA DATE</div>
					<div class="col mini-box">AUTEUR</div>
				</div>
				<div class="row">
					<div class="col mini-box"><figure>
						<figcaption>Ecouter le podcast : 	</figcaption>
						<audio
							controls
							src="/media/examples/t-rex-roar.mp3">
								Your browser does not support the
								<code>audio</code> element.
						</audio> 
						</figure>
					</div>
					<div class="col mini-box">
						<br/>
						<button type="button" class="btn btn-outline-success">Télécharger</button>
					</div>
			  </div>
			</div>

		</div>
	</div>
	  
	
	
	<?php   
			/** inclus le code du footeur */
			include('pages/footeur/footeurs.html'); 
	?>
	</body>
	
</html>