<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" /> 
		
		<title>Nous contacter</title>
	</head>

	<body>
			
	<p id="inscriptionConnexion">
	<a 	href="inscripton.html" >
			S'inscrire 
		</a>
	
	<a 	href="connexion.html" >
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

		<h1> Medic'Info </h1>

		<form method="get" action="message.php"  autocomplete="off">
			<p> Nom <INPUT type="text" name="n" value=""> </p>
			<p> Prenom <INPUT type="text" name="p" value=""> </p>
			<p> mail <INPUT type="text" name="mail" value=""> </p>
			<p> Sujet <INPUT type="text" name="sujet" value=""> </p>
			<p> Commentaires <TEXTAREA rows="3" name="commentaires"> Votre commentaire </TEXTAREA>
			<p><INPUT  type="submit" value="Envoyer"> </p>
		</form>
	
	</div>
	
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