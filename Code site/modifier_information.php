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

    <body>

	<p id="inscriptionConnexion">
    <?php 
        if (isset($_SESSION['client'])){
            echo "Bonjour M. ".$_SESSION['nom']." ".$_SESSION['prenom'];
            echo "<br />";
    	echo '<a href="favoris.php" > favoris </a>';
    	echo '<a href="deconnexion.php"> Déconnexion </a>';
		echo "</p>";
        echo "<h1> 	<a 	id='contact' href='index.php' > Medic'Info </a>  </h1>";

        $client = $bdd->query("select * from Clients where id_client='".$_SESSION['id_client']."'");
        $mat = $client ->fetch(); 

        echo " <div>";
        echo "<h2> Modifier mes informations : </h2>";
        echo "<form action='modification_information.php' method='post' autocomplete='off'>";
        echo '<p>  Modifier mon nom  :  <input type="text" name="nom" value='.$_SESSION['nom'].'></p>';
        echo '<p> modifier mon prénom :  <input type="text" name="prenom" value='.$_SESSION['prenom'].'></p>';
        echo '<p> modifier mon adresse mail :  <input type="text" name="mail" value='.$_SESSION['mail'].'></p>';
        echo '<p> modifier ma date de naissance :  <input type="text" name="date" value='.$_SESSION['date_naissance'].'></p>';
        echo '<p> modifier mon adresse :  <input type="text" name="adresse" value='.$_SESSION['adresse'].'></p>';
        echo '<p> modifier mon numéro de téléphone :  <input type="text" name="num" value='.$_SESSION['numero'].'></p>';
        echo '<p> ajouter une profession :  <input type="text" name="profession" value='.$mat['Profession'].'></p>';
        echo '<p> ajouter des allergies :  <input type="text" name="allergies" value='.$mat['allergies'].'></p>';
        echo '<p> ajouter des pathologies :  <input type="text" name="pathologies" value='.$mat['Pathologies'].'></p>';
        echo '<p> <INPUT id="boutonInscription" type="submit" value= Modifier > </p>';
        echo '</form>';
	    echo '</div>';

        }
    ?>
    </p>
</body>

</html>
