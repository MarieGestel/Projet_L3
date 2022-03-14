<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type"
		content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css"
		type="text/css" media="screen" />
		
		
		
		<title>Connexion</title>
	</head>
	
	<body>
	
	<h1> <a id='titre' href='index.html'> Medic'Info </a> </h1>
	
	<p id="inscriptionConnexion">
	<a 	href="inscripton.html" >
			S'inscrire 
		</a>
	
	<a 	href="connexion.php" >
			Se connecter
		</a>
	</p>
	
		
	<h2>
	<a 	href="rechercheNom.php" >
			Recherche par nom 
		</a>
	
	<a 	href="rechercheVoieAdm.php" >
			 Recherche par voie d'administration 
		</a>
	
	<a 	href="rechercheCodeCIS.php" >
			 Recherche par code CIS
		</a>
	
	


	
	</h2>
	<p>	
		<strong>Page de Connexion</strong>
		</p>
		
<?php
if(isset($_GET['mail']))
	$mail=$_GET['mail'];
else
	$mail="";
?>		
		
	<form action="connecter.php" method="post" autocomplete="off">
	<p> <input type="text" name="mail" value="Email" > </p>
	
	<p> <input type="password" name="motdepasse" value="Mot de passe" > </p>
	
	<p><input type="submit" value="Se connecter"></p>

	</form>
	
	<a 	href="inscripton.html" >
			Je ne possède pas encore de compte		
			</a>
	
	
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