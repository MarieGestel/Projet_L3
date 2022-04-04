<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info/Connexion</title>
	</head>
	
	<body class='inscrire'>
	<div id="formulaire"	>
	<h1> <a href='index.php'> MEDIC'INFO </a> </h1>
	<h2> <strong>Page de Connexion</strong> </h2>
		
	<form  action="connecter.php" method="post" autocomplete="off">
	<?php
	if (isset($_GET["mail"])){ 
		$mail=$_GET['mail'] ; 
	}else{ 
		$mail="";
	}
	echo '<p> Adresse mail <INPUT type="text" name="mail" value ='.$mail.' > </p>';
	?>	
	<p> Mot de passe <INPUT type="password" name="motdepasse" value="" > </p>
	<p> <INPUT id="bouton" type="submit" value="Se connecter"></p>
	</form>
	
	<a 	href="inscription.php" > Je ne possède pas encore de compte </a>
</div>
	<div class='liensBas'>
	<a 	href="quisommesnous.php" >Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
	</div>
	
	</body>
	
</html>