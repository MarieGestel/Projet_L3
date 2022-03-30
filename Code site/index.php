<?php
	session_start();
 	require('bd.php');
	$bdd = getBDMarie() ; 
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
		echo '<nav>';
		echo '<div class="menu">';
		if (isset($_SESSION['client'])){
            //echo "Bonjour M. ".$_SESSION['nom']." ".$_SESSION['prenom'];
            //echo "<br />";
   		 	echo '<a href="favoris.php" > Favoris </a>';
			echo "<a href='profil.php'> profil </a>";
			echo '<a href="deconnexion.php"> Déconnexion </a>';
    	} else {
			echo "<a 	href='inscription.php' > Inscription </a>";
			echo '<a 	href="connexion.php" > Connexion </a>'; 
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
		
	<?php
	/*
	require('graphiqueTopFavoris.php');
	echo '<div id="imagesIndex"><img src="favoris.png" alt ="graphique" /> </div>';
	*/
	?>
	
	<div class='liensBas'>
	<a 	href="quisommenous.php" >Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="mentionLegales.php" >	Mentions légales </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
	</div>
	
	</body>
	
</html>