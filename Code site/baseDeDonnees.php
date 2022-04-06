<?php
// Permet l'activation de la session du client connecté
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		
		<title>Medic'Info</title>
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
    <div class="divLiensBas">

    <h2> Base de données utilisées : </h2>
    <p> La base de données publique des médicaments permet au grand public et aux professionnels de santé d'accéder à des données et documents de référence sur les médicaments commercialisés ou ayant été commercialisés durant les trois dernières années en France.
        Cette base de données administratives et scientifiques sur les traitements et le bon usage des produits de santé est mise en œuvre par l'Agence nationale de sécurité du médicament et des produits de santé (ANSM), en liaison avec la Haute Autorité de santé 
        (HAS) et l'Union nationale des caisses d'assurance maladie (UNCAM), sous l'égide du ministère des Affaires sociales et de la santé.</p>
    <p> <strong> Lien vers le téléchargement de la base de données :</strong>  <a 	href="https://base-donnees-publique.medicaments.gouv.fr/telechargement.php" >https://base-donnees-publique.medicaments.gouv.fr/telechargement.php</a> </p>

    <div class='liensBas'>
	<a 	href="quisommenous.php" > Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
    </div>
    </div>
    </body>
</html>