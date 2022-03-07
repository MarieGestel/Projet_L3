<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" /> 
		
		<title>Nous contacter</title>
	</head>

	<body>
	<h1> Medic'Info </h1>
		<p>
			<a 	href="inscription.php" >
					S'inscrire 
				</a>
			
			<a 	href="connexion.php" >
					Se connecter
				</a>
		</p>

		<form method="get" action="message.php"  autocomplete="off">
			<p> Nom <INPUT type="text" name="n" value=""> </p>
			<p> Prenom <INPUT type="text" name="p" value=""> </p>
			<p> mail <INPUT type="text" name="mail" value=""> </p>
			<p> Sujet <INPUT type="text" name="sujet" value=""> </p>
			<p> Commentaires <TEXTAREA rows="3" name="commentaires"> Votre commentaire </TEXTAREA>
			<p><INPUT  type="submit" value="Envoyer"> </p>
		</form>
	</body>
</html>