<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" /> 
		
		<title>Nous contacter</title>
	</head>

	<body>		
	<p id="inscriptionConnexion">

	<?php 
        if (isset($_SESSION['client'])){
            echo "Bonjour M. ".$_SESSION['nom']." ".$_SESSION['prenom'];
            echo "<br />";
      		echo '<a href="favoris.php" > favoris </a>';
	  		echo '<a href="deconnexion.php"> Déconnexion </a>';
    		echo '<a href="profil.php"> Votre profil </a>';
    	} else {
			echo "<a href='inscription.php' > S'inscrire </a>";
			echo '<a href="connexion.php" > Se connecter </a>';
		} 
    ?>

	<h1> <a id="contact" href="index.php" > Medic'Info </a>  </h1>

	<div>
		<form method="post" action="message.php"  autocomplete="off">
			<p> Nom <INPUT type="text" name="n" value=""> </p>
			<p> Prenom <INPUT type="text" name="p" value=""> </p>
			<p> mail <INPUT type="email" name="mail" value=""> </p>
			<p> Sujet <INPUT type="text" name="sujet" value=""> </p>
			<p> Commentaires <TEXTAREA rows="3" name="commentaires"> Votre commentaire </TEXTAREA>
			<p><INPUT  type="submit" value="Envoyer"> </p>
		</form>
	</div>
	
	<p id='liensBas'>
	<a 	href="quisommenous.php" > Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="mentionLegales.php" > Mentions légales </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
	</p>
	
	</body>
</html>