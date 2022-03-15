<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info/Connexion</title>
	</head>
	
	<body id="formulaire" >
	
	<h1> <a id="contact" href='index.php'> Medic'Info </a> </h1>
	<h2> <strong>Page de Connexion</strong> </h2>
		
	<form action="connecter.php" method="get" autocomplete="off">
	<p> Adresse mail <INPUT type="text" name="mail" value = <?php if (isset($_GET['mail'])){ echo $_GET['mail'] ; } else{ echo "";}?>> </p>	
	<p> Mot de passe <INPUT type="password" name="motdepasse" value="" > </p>
	<p> <INPUT id="bouton" type="submit" value="Se connecter"></p>
	</form>
	
	<a 	href="inscription.php" > Je ne possède pas encore de compte </a>



<p id='liensBas'>
	<a 	href="quiSommesNous.php" >
			Qui sommes-nous ?
		</a>
	
	<a 	href="contact.php" >
			Contact
		</a>
	
	<a 	href="mentionLegales.php" >
			Mentions légales
		</a>
	
	<a 	href="donneesPersonnelles.php" >
			Données personnelles
		</a>
	
	<a 	href="baseDeDonnees.php" >
			Base de données
		</a>
	</p>
	
	</body>
	
</html>