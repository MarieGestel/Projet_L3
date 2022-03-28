<?php
session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		
		<title>Medic'Info</title>
	</head>
	
	<body>
	<p id="inscriptionConnexion">
	<?php 
        if (isset($_SESSION['client'])){
            echo "Bonjour M. ".$_SESSION['nom']." ".$_SESSION['prenom'];
            echo "<br />";''
   ?>	
   <a 	href="favoris.php" > favoris </a>
    <a href="deconnexion.php"> Déconnexion </a>
    <a href="profil.php"> Votre profil </a>
    <?php 
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
        <h1> 	<a 	id="contact"href="index.php" > Medic'Info </a>  </h1>
    <h2> Base de données utilisées : </h2>
    <p> La base de données publique des médicaments permet au grand public et aux professionnels de santé d'accéder à des données et documents de référence sur les médicaments commercialisés ou ayant été commercialisés durant les trois dernières années en France.
        Cette base de données administratives et scientifiques sur les traitements et le bon usage des produits de santé est mise en œuvre par l'Agence nationale de sécurité du médicament et des produits de santé (ANSM), en liaison avec la Haute Autorité de santé 
        (HAS) et l'Union nationale des caisses d'assurance maladie (UNCAM), sous l'égide du ministère des Affaires sociales et de la santé.</p>
    <p> <strong> Lien vers le téléchargement de la base de données :</strong>  <a 	href="https://base-donnees-publique.medicaments.gouv.fr/telechargement.php" >https://base-donnees-publique.medicaments.gouv.fr/telechargement.php</a> </p>

    <div id='liensBas'>
	<a 	href="quisommenous.php" > Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="mentionLegales.php" > Mentions légales </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
    </div>
    </body>
</html>