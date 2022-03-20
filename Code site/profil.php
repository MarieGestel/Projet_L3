<?php
	session_start();
 	require('bd.php');
	$bdd = getBDMarie() ; 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info</title>
	</head>

	<body >
	<p id="inscriptionConnexion">
    <?php 
        if (isset($_SESSION['client'])){
            echo "Bonjour M. ".$_SESSION['nom']." ".$_SESSION['prenom'];
            echo "<br />";
    	echo '<a href="favoris.php" > favoris </a>';
    	echo '<a href="deconnexion.php"> Déconnexion </a>';
		echo "</p>";
	}
	$re = $bdd->query("select * from Clients where id_client='".$_SESSION['id_client']."'");
	$mat = $re ->fetch(); 

	echo "<h1> 	<a 	id='contact'href='index.php' > Medic'Info </a>  </h1>";

	echo '<div id="profil">';
	echo '<h2> Mon profil  </h2>'; 
	//echo "<img src=".$mat['url_photo'].">"; 
	echo " <ul>";
	echo '<li> <strong> Nom : </strong>'.$mat['nom'].'<br/> </li>' ;
	echo '<li> <strong> Prenom  : </strong>'.$mat['prenom'].'<br/> </li>' ;
	echo '<li> <strong> adresse mail  : </strong>'.$mat['mail'].'<br/> </li>' ;
	echo '<li> <strong> date de naissance  : </strong>'.$mat['date_naissance'].'<br/> </li>' ;
	echo '<li> <strong> Numero : </strong>'.$mat['numero'].'</li>';
	echo '<li> <strong> Mon adresse : </strong>'.$mat['adresse'].'</li>';
	echo "</ul>"; 
	?>
	<form action="profil.php" method="post" autocomplete="off">
	<p>  <INPUT type="text" name="profession" value =<?php if (isset($_POST['profession'])){ echo $_POST['profession'] ; } else{ echo " Profession ";}?>> </p>	
	<p>  <INPUT type="text" name="allergie" value = <?php if (isset($_POST['allergie'])){ echo $_POST['allergie'] ; } else{ echo "Allergie";}?>> </p>	
	<p> <INPUT type="text" name="pathologie" value =<?php if (isset($_POST['pathologie'])){ echo $_POST['pathologie'] ; } else{ echo "Pathologie ";}?>> </p>	
	<p> <INPUT id="boutonProfil" type="submit" value=""></p>
	</form>
	</div>;

	<p id='liensBas'>
		
		<a 	href="quisommenous.php" >Qui sommes-nous ? </a>
		
		<a 	href="contact.php" > Contact </a>
		
		<a 	href="mentionLegales.php" >	Mentions légales </a>
		
		<a 	href="donneesPersonnelles.php" > Données personnelles </a>
		
		<a 	href="baseDeDonnees.php" > Base de données </a>
		</p>
		
</body>