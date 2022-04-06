<?php
	session_start(); // Permet de démarrer une session
	require('bd.php'); // importe le fichier bd.php
   $bdd = getBD() ; // appel la focntion getBD() 
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
	
	<body class='rechercheIndex'>
    <?php 
		echo '<nav>';
		echo '<div class="menu">';
		if (isset($_SESSION['client'])){
			//Si utilisateur connecté
   		 	echo '<a href="favoris.php" > Favoris </a>';
			echo "<a href='profil.php'> profil </a>";
			echo '<a href="deconnexion.php"> Déconnexion </a>';
    	} else {
			//Si aucun utilisateur connecté
			echo "<a 	href='inscription.php' > Inscription </a>";
			echo '<a 	href="connexion.php" > Connexion </a>'; 
    	} 
    ?>
	</div>
	</nav>

	<h1> <a id="contact"href="index.php" > MEDIC'INFO </a>  </h1>
	<h2><a href='pageRecherche.php'> Recherche </a> </h2>

	<div class='graphique'>
    <h2> Top 5 des médicaments en favoris : </h2>
	<?php require('graphiqueTopFavoris.php'); // importe le fichier garphiqueTopFavoris.php ?>
	<div> <img src="favoris.png" alt ="graphique Favoris" /></div>

	<h2> <a href='graphiqueTop10_remboursement.php'>Top 10 des taux de remboursements selon la voie d'administration et/ou la forme pharmaceutique  </a> </h2>

	<h2><a href='graphique_taux_remboursement.php'> Poucentage des taux de remboursements selon la voie d'administration ou la forme pharmaceutique :</h2>
	</div>
	
	<div class='liensBas'>
	<a 	href="quisommenous.php" >Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
	</div>
	
	</body>
	
</html>