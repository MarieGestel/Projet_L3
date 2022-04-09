<?php
session_start();// Permet l'activation de la session du client connecté
require('bd.php'); // importe le fichier bd.php
$bdd = getBD() ; // appel la focntion getBD() 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info</title>
	</head>

	<body class='BodyProfil'>
    <?php 
		echo '<nav>';
		echo '<div class="menu">';
        if (isset($_SESSION['client'])){ // Savoir si le client est connecté 
			echo '<a href="favoris.php" > favoris </a>';
			echo '<a href="deconnexion.php"> Déconnexion </a>';
			echo '<a href="profil.php"> Profil </a>';
			echo "</div>
			</nav>";
		
			echo "<h1> 	<a href='index.php' > MEDIC'INFO </a>  </h1>";

			//requete pour récupérer les information du client 
			$re = $bdd->query("select * from Clients where id_client='".$_SESSION['id_client']."'");
			$mat = $re ->fetch(); 
			
			echo '<div class="profil">';
			echo '<h2> Mon profil  </h2>'; 
			//if ( $mat['photo']!=Null ) { echo '<img src='.$mat['photo'];}
			echo " <ul>";
			echo '<li> <strong> Nom : </strong>'.$mat['nom'].'<br/> </li>' ;
			echo '<li> <strong> Prenom  : </strong>'.$mat['prenom'].'<br/> </li>' ;
			echo '<li> <strong> adresse mail  : </strong>'.$mat['mail'].'<br/> </li>' ;
			echo '<li> <strong> date de naissance  : </strong>'.$mat['date_naissance'].'<br/> </li>' ;
			echo '<li> <strong> Numero : </strong>'.$mat['numero'].'</li>';
			echo '<li> <strong> Mon adresse : </strong>'.$mat['adresse'].'</li>';
			if ( $mat['allergies']!=Null ) { echo '<li> <strong> Mes allergies : </strong>'.$mat['allergies'].'</li>';}
			if ( $mat['Profession']!=Null ) { echo '<li> <strong> Ma profession : </strong>'.$mat['Profession'].'</li>';}
			if ( $mat['Pathologies']!=Null ) { echo '<li> <strong> Mes pathologie : </strong>'.$mat['Pathologies'].'</li>';}
			echo "</ul>"; 

			echo "<form action='modifier_information.php' method='post' autocomplete='off'>";
			echo '<INPUT class="bouton" type="submit" value= "Modifier mes informations" >';
			echo '</form>';
			echo "</div>";
		}else{
			echo "Vous n'êtes pas connecté";
			echo '<meta http-equiv="refresh" content="1; url=index.php"/>';
		}
	?>

	<div class='liensBas'>
		<a 	href="quisommenous.php" >Qui sommes-nous ? </a>
		<a 	href="contact.php" > Contact </a>
		<a 	href="donneesPersonnelles.php" > Données personnelles </a>
		<a 	href="baseDeDonnees.php" > Base de données </a>
	</div>

		
	</body>
</html>