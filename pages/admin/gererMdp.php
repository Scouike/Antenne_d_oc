<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>gerer mot de passe</title>
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../../css/style.css" rel="stylesheet">
		
		<!-- liens vers fontawesome -->
		<link href="../../fontawesome/css/all.css" rel="stylesheet" >
</head>
<body>
		<!-- barre navigation -->
		<?php   
			if (isset($_SESSION['type']) && $_SESSION['type']=="admin") {
				include('../bareNav/barreNavAdmin.html');
			}
		?>
	  
<div class="margin">
	<h1>Page d'affichage des mots de passe</h1>

	<form class="form-inline">
	  <div class="form-group mx-sm-3 mb-2">
		<label for="inputPassword2" class="sr-only">Nom Utilisateur</label>
		<input type="password" class="form-control" id="inputPassword2" placeholder="Nom Utilisateur">
	  </div>
	  <button type="submit" class="btn btn-primary mb-2">Rechercher</button>
	</form>

	<table class="table table-bordered">
	<thead>
		<tr>
		  <th scope="col">Nom de l'utilisateur</th>
		  <th scope="col">MDP crypté</th>
		  <th scope="col">Bouton de décryptage</th>
		</tr>
	  </thead>
	  <tbody>
		<tr>
		  <th scope="row">Nom1</th>
		  <td>MDP</td>
		  <td><button type="button" class="btn btn-outline-warning">Décryptage</button></td>
		</tr>
		<tr>
		  <th scope="row">Nom2</th>
		  <td>MDP</td>
		  <td><button type="button" class="btn btn-outline-warning">Décryptage</button></td>
		</tr>
	  </tbody>
	</table>
	</div>


	<!-- Footer -->
	<?php   
		include('../footeur/footeurs.html'); 
	?>

</body>
</html>