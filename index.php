<!-- demare une session -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Accueil</title>
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
		<?php   
			if(isset($_GET['deconexion'])){
				// on détruit la session	
				session_destroy();
				header('Location: http://localhost/ProjetRadioGit/ProjetRadioPhp/index.php');
				Exit();
			}
			//on regarde si une session existe et si oui de qu'elle type elle est
			if (isset($_SESSION['level']) && $_SESSION['level']==1) {
				include('pages/bareNav/barreNavUtilisateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==2) {
				/* inclu une barre de navigation */
				include('pages/bareNav/barreNavAnimateur.html');
			}else if (isset($_SESSION['level']) && $_SESSION['level']==3) {
				/* inclu une barre de navigation */
				include('pages/bareNav/barreNavAdmin.html');
			}else{
				/* inclu une barre de navigation */
				include('pages/bareNav/barreNav.html'); 
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
			$cadreFestif = false;
			if ($cadreFestif){
				?>
					
						<div class="row cadre3">
							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">
								<img src="images/imageFestive.jpg" class ="imagFestive" alt="image festive" />
							</div>
							<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 ">
							texte : blablabla
							</div>
						</div>
					
				<?php
			}
			
		?>
		<p class="cadre3"> Les fréquences : Bretenoux 89.0 &nbsp; Cahors 88.1 &nbsp; Cahors sud
						   89.0 &nbsp; Cazals 88.8 &nbsp;Figeac 88.1 &nbsp; Gourdon 105.3
						   &nbsp; Labastide-Murat 104.1 &nbsp;  Montcuq 88.8 &nbsp; Prayssac
						   93.7 &nbsp; Souillac 100.3 <br />
		</p>
		<h1 class="text-uppercase m-4 text-center">Derniers podcasts publiés</h1>
		<div class="container-fluid">
			<div class="row">
				<div class="col-1 fleches">
					<a class="precedent" onclick="changerSlide(-1)">&#10094;</a>
				</div>		
				<div class="col-10 colonne-milieu">
		<!-- Affichage des podcasts depuis la BD -->
		<?php 
			$sql = "SELECT dateCreation, podcast.id_podcast AS idpodcast, podcast.id_emission AS idemission, image, son, podcast.texte AS texte_podcast, emission.nom FROM podcast
					JOIN emission ON podcast.id_emission = emission.id_emission
					WHERE podcast.archive = 0
					AND podcast.attente = 0
					AND dateCreation <= NOW()
					ORDER BY dateCreation DESC";
				$stmt = $pdo->prepare($sql);
				$stmt->execute();
				$n = 0;
				
				// Boucle de 3 itérations pour afficher 3 podcasts
				while ($n < 3 && $row = $stmt->fetch()) {
					$n++;
		?>		
		<div class="mySlides transition">
		<?php
			affichagePodcast($row['dateCreation'], $row['idemission'], $row['son'], $row['texte_podcast'], $row['image']);
		?>
		</div>
		<?php
			}	
		?>
					</div>
					<div class="col-1 fleches">
					<a class="suivant" onclick="changerSlide(1)">&#10095;</a>
				</div>
			</div>
		</div>
		<!-- Points sous les slides -->
		<div class="indicateurs">
		<?php
			for ($j = 1 ; $j <= $n ; $j++) {
				echo "<span class='point' onclick='selectionnerSlide($j)'></span>";
			}	
		?>
		</div>
		
	
		<?php   
			/* inclus le code du footeur */
			include('pages/footeur/footeurs.html'); 
		?>
		
		<?php 
		// Fonction qui affiche un podcast
			function affichagePodcast($date, $idemission, $podcast, $texte, $image){
				global $pdo;
				$date =  date("d-m-Y",strtotime($date));
				//recuperation du nom de l'emission
				$sql = "SELECT nom FROM emission WHERE id_emission = ? ";
				$stmt = $pdo->prepare($sql);
				$stmt->execute([$idemission]);	

				
				while ($row = $stmt->fetch()) {
					$nomemission = $row['nom'];
				}
				
			
				//dertermination du type de podcast
				if ($image != "NULL" && $texte != "NULL" ){
					
					//affichage d'un podcast avec une image et un texte
					echo	'<div class=" cadre3 decalageGauche">
							<div class="row">
								<div class="col cadre_image ">
									<img src="'.$image.'" class="illustration" alt="Image Emission">
								</div>
								<div class="col ">
									<div class="row">
										<div class="col description"><p>'.$texte.'</p></div>
									</div>	
									<div class="row">
										<div class="col"><figure>
											<figcaption>Ecouter le podcast :</figcaption><br/>
											<audio controls src="'.$podcast.'">Your browser does not support the<code>audio</code> element.</audio><br/><br/>
											<a href="'.$podcast.'"  class="btn btn-outline-success">Télécharger</a>
											</figure>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col">date de mise en ligne : '.$date.' </div>
								<div class="col">Emmision : '.$nomemission.'</div>
							</div>
						</div>';
					
				}else if($image == "NULL" && $texte == "NULL"){
					//affichage d'un podcast sans image et sans texte
					echo   '<div class=" cadre3 decalageGauche">
								<div class="row">
									<div class="col">				
										<div class="row">
											<div class="col"><figure>
												<figcaption>Ecouter le podcast :</figcaption><br/>
												<audio controls src="'.$podcast.'">Your browser does not support the<code>audio</code> element.</audio><br/><br/>
												<a href="'.$podcast.'"  class="btn btn-outline-success">Télécharger</a>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">date de mise en ligne : '.$date.' </div>
									<div class="col">Emmision : '.$nomemission.'</div>
								</div>
							</div>';
					
				}else if($image != "NULL"){
					//affichage d'un podcast avec une image mais pas de texte
					echo	'<div class=" cadre3 decalageGauche">
								<div class="row">
									<div class="col cadre_image">
										<img src="'.$image.'" class="illustration" alt="Image Emission">
									</div>
									<div class="col">
										<div class="row">
											<div class="col"><figure>
												<figcaption>Ecouter le podcast :</figcaption><br/>
												<audio controls src="'.$podcast.'">Your browser does not support the<code>audio</code> element.</audio><br/><br/>
												<a href="'.$podcast.'"  class="btn btn-outline-success">Télécharger</a>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">date de mise en ligne : '.$date.' </div>
									<div class="col">Emmision : '.$nomemission.'</div>
								</div>
							</div>';
					
				}else{
					//affichage d'un podcast avec un texte et pas d'image
					echo	'<div class=" cadre3 decalageGauche">
								<div class="row">
									<div class="col">
										<div class="row">
											<div class="col description"><p>'.$texte.'<p></div>
										</div>
										
										<div class="row">
											<div class="col"><figure>
												<figcaption>Ecouter le podcast :</figcaption><br/>
												<audio controls src="'.$podcast.'">Your browser does not support the<code>audio</code> element.</audio><br/><br/>
												<a href="'.$podcast.'"  class="btn btn-outline-success">Télécharger</a>
												</figure>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">date de mise en ligne : '.$date.' </div>
									<div class="col">Emmision : '.$nomemission.'</div>
								</div>
							</div>';
				}
				
			}
		?>
		
	</body>
	
</html>

<script>
	var slideIndex = 1;
afficherSlide(slideIndex);

// boutons précédent/suivant
function changerSlide(n) {
  afficherSlide(slideIndex += n);
}

// Selecteur par points
function selectionnerSlide(n) {
  afficherSlide(slideIndex = n);
}

function afficherSlide(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var points = document.getElementsByClassName("point");
  if (n > slides.length) {slideIndex = 1} 
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none"; 
  }
  for (i = 0; i < points.length; i++) {
      points[i].className = points[i].className.replace(" actif", "");
  }
  slides[slideIndex-1].style.display = "block"; 
  points[slideIndex-1].className += " actif";
  
} 
</script>