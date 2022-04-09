<?php
	session_start();
 	require('bd.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info</title>
	</head>
	


	<body id="index">
    <?php 
	echo '<img id="log" src="Images/Sanstitre.png">';
		echo '<nav>';
		echo '<div class="menu">';
		//echo '<img id="log" src="Images/MEDICInfo.png">';
		if (isset($_SESSION['client'])){
   		 	echo '<a href="favoris.php" > Favoris </a>';
			echo "<a href='profil.php'> profil </a>";
			echo '<a href="deconnexion.php"> Déconnexion </a>';
			//fait apparaitre les liens favoris, profil et déconnexion lorsque le client est connecté
    	} else {
			echo "<a 	href='inscription.php' > Inscription </a>";
			echo '<a 	href="connexion.php" > Connexion </a>'; 
			//liens qui apparaissent en haut de page lorsque le client n'est pas encore inscrit ou connecté
    	} 
    ?>

	</div>
	</nav>
	<h1> <a id="contact" href="index.php" > MEDIC'INFO </a>  </h1>
	
	<h2>
		<a href='pageRecherche.php'> Recherche </a>
		<a href='donneesClees.php'> Données clées </a>
	</h2>

	<p id='bienvenu'> Bienvenu(e) sur notre site ! </p>
	
	<div class='liensBas'>
	<a 	href="quisommenous.php" >Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
	</div>
	
	</body>
	
</html>