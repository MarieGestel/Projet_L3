<?php
	session_start();
 	require('bd.php');
	$bdd = getBDMarie() ; 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type"
		content="text/html; charset=UTF-8" />
		
		<link rel="stylesheet" href="styles.css"
		type="text/css" media="screen" />
		
		
		<title>Medic'Info</title>
	</head>
	
	<body>
    <p id="inscriptionConnexion">
    <?php 
        if (isset($_SESSION['client'])){
            echo "Bonjour M. ".$_SESSION['nom']." ".$_SESSION['prenom'];
            echo "<br />";
   		 	echo '<a href="favoris.php" > Favoris </a>';
			echo "<a href='profil.php'> Votre profil </a>";
			echo '<a href="deconnexion.php"> Déconnexion </a>';
    } else {
    ?>
	<a 	href="inscription.php" >
			S'inscrire 
		</a>
	<a 	href="connexion.php" >
			Se connecter
		</a>
    <?php 
    } 
    ?>
	</p>
	<h1> <a id="contact"href="index.php" > Medic'Info </a>  </h1>

	<form action='recherche.php' method='get' autocomplete='on'>
	<p>
	<input class='recherche' type='text' name='nom' value='' placeholder='Nom'/>
	<input class='recherche' type='text' name='voieAdm' value='' placeholder="Voie d'administration"/>
	<input  class='recherche'type='text' name='codeCIS' value=''placeholder='Code CIS'/>
	<input class='recherche' type="submit" value="Rechercher">
	</p>
	</form>
	
	
	<div id='imagesIndex'>
	<img src="Images/médicament1.jpeg" 
		alt ="Image accueil1" height='366px' width='499px' />
		
	<img src="Images/médicament2.jpg" 
		alt ="Image accueil2" />
	
	</div>
	
	<p id='liensBas'>
		
	<a 	href="quisommenous.php" >Qui sommes-nous ? </a>
	
	<a 	href="contact.php" > Contact </a>
	
	<a 	href="mentionLegales.php" >	Mentions légales </a>
	
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	
	<a 	href="baseDeDonnees.php" > Base de données </a>
	</p>
	
	</body>
	
</html>