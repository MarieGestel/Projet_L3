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
	
	<body class="BodyLiensBas">
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

    <h1> <a href="index.php" > MEDIC'INFO </a>  </h1>

    <div class="divLiensBas">
    <h2> Qu’est-ce que les données personnelles ?</h2>
    <p> Une donnée à caractère personnel correspond en droit français à toute information relative à une personne physique identifiée ou qui peut être identifiée, directement ou indirectement, par référence à un numéro d'identification ou à un ou plusieurs éléments qui lui sont propres. 
        En France, les données ayant été l'objet d'un procédé d'anonymisation ne sont pas considérées comme des données à caractère personnel.
        Ces données sont protégées par divers instruments juridiques notamment la loi Informatique, fichiers et libertés de 1978 et le Règlement général sur la protection des données ou RGPD (abrogeant la directive 95/46/CE) au niveau communautaire ainsi que la Convention no 108 pour la protection des données personnelles du Conseil de l'Europe.
        En France, la loi énonce que « toute personne dispose du droit de décider et de contrôler les usages qui sont faits des données à caractère personnel la concernant ».
        Le règlement européen RGPD a été adapté en droit interne par la loi du 20 juin 2018 relative à la protection des données personnelles. 
    </p>
    <p> <strong> Consulter le règlement générale sur la protection des données pour plus d'information :</strong>  <a 	href="https://www.cnil.fr/fr/reglement-europeen-protection-donnees" >https://www.cnil.fr/fr/reglement-europeen-protection-donnees</a> </p>

    <div class='liensBas'>
	<a 	href="quisommenous.php" > Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
    </div>
    </div>
    </body>
</html>