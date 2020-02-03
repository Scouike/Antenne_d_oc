<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Deconnexion</title>
		<!-- Lien vers boostrap -->
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		
		<!-- Lien vers mon CSS -->
		<link href="../css/styleLog.css" rel="stylesheet">
		

	</head>

	<body>


		
		<div class="cadre ">
			
				<!-- on detruit la session -->	
				<?php session_destroy(); ?>
				<!-- formulaire-->
				<form action =  "../index.php"  method="post">			  			  
				  <input type="submit" class="boutonVert" value="Deconnexion">
				</form>



			
		</div>
		
					
	  
	</body>
</html>