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
    <h2> Qu’est-ce que les données personnelles ?</h2>
    <p> Une donnée à caractère personnel correspond en droit français à toute information relative à une personne physique identifiée ou qui peut être identifiée, directement ou indirectement, par référence à un numéro d'identification ou à un ou plusieurs éléments qui lui sont propres. 
        En France, les données ayant été l'objet d'un procédé d'anonymisation ne sont pas considérées comme des données à caractère personnel.
        Ces données sont protégées par divers instruments juridiques notamment la loi Informatique, fichiers et libertés de 1978 et le Règlement général sur la protection des données ou RGPD (abrogeant la directive 95/46/CE) au niveau communautaire ainsi que la Convention no 108 pour la protection des données personnelles du Conseil de l'Europe.
        En France, la loi énonce que « toute personne dispose du droit de décider et de contrôler les usages qui sont faits des données à caractère personnel la concernant ».
        Le règlement européen RGPD a été adapté en droit interne par la loi du 20 juin 2018 relative à la protection des données personnelles. 
    </p>
    <p> <strong> Consulter le règlement générale sur la protection des données pour plus d'information :</strong>  <a 	href="https://www.cnil.fr/fr/reglement-europeen-protection-donnees" >https://www.cnil.fr/fr/reglement-europeen-protection-donnees</a> </p>

    <div id='liensBas'>
	<a 	href="quisommenous.php" > Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="mentionLegales.php" > Mentions légales </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
    </div>
    </body>
</html>