<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer Thème ou Emission </title>
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../../fontawesome/css/all.css" rel="stylesheet" >
		
		<!-- Lien vers mon CSS -->
		<link href="../../css/styleLog.css" rel="stylesheet">
</head>
<body>
	<!-- barre navigation -->
		<?php   
			if (isset($_SESSION['type']) && $_SESSION['type']=="admin") {
				include('../bareNav/barreNavAdmin.html');
			}
		?>
	<h1 class="text-uppercase m-4 text-center">Supprimer de Thème et Emission</h1>
	<div class="cadre ">
		<div>
			<!-- titre -->
			<a class="inactive titre" href="ModifierSite.php"> Ajout</a>
			<a class="active underlineHover titre" href="Supprimer.php">Supprimer </a>
			<a class="inactive underlineHover titre" href="Restaurer.php">Restaurer </a>
		</div>
	</div>
	<div class="margin cadre2">
		<h2>Theme</h2>
		<form name="Thème">
			<div class="form-row">
				<select class="custom-select">
					<option selected>Choisissez quel thème vous désirez supprimer</option>
					<option value="1">Emission 1</option>
					<option value="2">Emission 2</option>
					<option value="3">Emission 3</option>
				</select>
			</div>
			<br/>
			<!-- Liste déroulante avec les possibles émissions 	 -->
			
			
			<button type="button" class="btn btn-danger float-right btnpadding">Supprimer	</button>
		</form>
	</div>
	<div class="margin cadre2">
		<h2>Emission</h2>
		<form name="Emission">
			<div class="form-row">
				<select class="custom-select">
					<option selected>Choisissez quelle Emission vous désirez supprimer</option>
					<option value="1">Emission 1</option>
					<option value="2">Emission 2</option>
					<option value="3">Emission 3</option>
				</select>
			</div>
			<br/>
			<!-- Liste déroulante avec les possibles émissions 	 -->
			
			
			<button type="button" class="btn btn-danger float-right btnpadding">Supprimer	</button>
		</form>
	</div>

<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>
</body>
</html>