<?php
	// Permet l'activation de la session du client connecté
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" /> 
		
		<title>Nous contacter</title>
	</head>

	<body class="BodyLiensBas">		
	<?php 
		echo '<nav>';
		echo '<div class="menu">';
		if (isset($_SESSION['client'])){
			//Si utilisateur connecté
   		 	echo '<a href="favoris.php" > Favoris </a>';
			echo "<a href='profil.php'> profil </a>";
			echo '<a href="deconnexion.php"> Déconnexion </a>';
    	} else {
			//Sinon
			echo "<a 	href='inscription.php' > Inscription </a>";
			echo '<a 	href="connexion.php" > Connexion </a>'; 
    	} 
    ?>
	</div>
	</nav>

	<h1> <a href="index.php" > MEDIC'INFO </a>  </h1>

	<div id ="contacter" > 
		<!-- Formulaire de contact  -->
		<h2> Nous contacter : </h2>
		<form method="post" action="message.php"  autocomplete="off">
			<p> Nom : </p>
				<INPUT type="text" name="n" value=""> 
			<p> Prenom : </p>
				<INPUT type="text" name="p" value=""> 
			<p> email : </p>
				<INPUT type="email" name="mail" value=""> 
			<p> Sujet : </p>
				<INPUT type="text" name="sujet" value=""> 
			<p> <TEXTAREA rows="3" name="commentaires"> Votre commentaire </TEXTAREA>
			<p><INPUT  type="submit" value="Envoyer"> </p>
		</form>
		
	<div class ='liensBas'>
	<a 	href="quisommenous.php" > Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
	</div>
	</div>

	</body>
</html>