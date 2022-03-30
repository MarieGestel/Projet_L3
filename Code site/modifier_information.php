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

    <body class='BodyProfil'>

    <?php 
		echo '<nav>';
		echo '<div class="menu">';
        if (isset($_SESSION['client'])){
            //echo "Bonjour M. ".$_SESSION['nom']." ".$_SESSION['prenom'];
            //echo "<br />";
    	echo '<a href="favoris.php" > favoris </a>';
    	echo '<a href="deconnexion.php"> Déconnexion </a>';
        echo '<a href="profil.php"> Profil </a>';
	    echo "</div>
	    </nav>";

        echo "<h1> 	<a href='index.php' > MEDIC'INFO </a>  </h1>";
        echo "</div >";

        $client = $bdd->query("select * from Clients where id_client='".$_SESSION['id_client']."'");
        $mat = $client ->fetch(); 

        echo " <div class='profil'>";
        echo "<h2> Modifier mes informations : </h2>";
        echo "<form action='modification_information.php' method='post' autocomplete='off'>";
        //echo '<p> <strong> ajouter une photo  :  </strong> <input type="file" name="photo" /> </p>';
        echo '<p> <strong> Modifier mon nom  :  </strong> <input type="text" name="nom" value='.$_SESSION['nom'].'> </p>';
        echo '<p> <strong> modifier mon prénom :  </strong> <input type="text" name="prenom" value='.$_SESSION['prenom'].'></p>';
        echo '<p> <strong> modifier ma date de naissance :  </strong> <input type="date" name="date" value='.$_SESSION['date_naissance'].'></p>';
        echo '<p> <strong> modifier mon adresse :  </strong> <input type="text" name="adresse" value='.$_SESSION['adresse'].'></p>';
        echo '<p> <strong> modifier mon numéro de téléphone :  </strong> <input type="tel" name="num" value='.$_SESSION['numero'].'></p>';
        echo '<INPUT class="bouton" type="submit" value= Modifier >';
        echo '</form>';
        echo ' </div>';

        echo " <div class='profil'>";
        echo "<h2> Modifier mon adresse mail ou mon mot de passe : </h2>";
        echo "<form action='modification_mail_mdp.php' method='post' autocomplete='off'>";
        echo '<p> <strong> modifier mon adresse mail :  </strong> <input type="email" name="mail1" ></p>';
        echo '<p> <strong> confirmer mon adresse mail :  </strong> <input type="email" name="mail2" ></p>';
        echo '<p> <strong> modifier mon mot de passe :  </strong> <input type="password" name="mdp1" ></p>';
        echo '<p> <strong> confirmer  mon mot de passe :  </strong> <input type="password" name="mdp2"></p>';
        echo '<INPUT class="bouton" type="submit" value= Modifier >';
        echo '</form>';
        echo ' </div>';

        echo " <div class='profil'>";
        echo "<h2> Modification divers : </h2>";
        echo "<form action='modification_autres.php' method='post' autocomplete='off'>";
        echo '<p> <strong> ajouter une profession :  </strong> <input type="text" name="profession" value='.$mat['Profession'].'></p>';
        echo '<p> <strong> ajouter des allergies :  </strong> <input type="text" name="allergies" value='.$mat['allergies'].'></p>';
        echo '<p> <strong> ajouter des pathologies :  </strong> <input type="text" name="pathologies" value='.$mat['Pathologies'].'></p>';
        echo '<INPUT class="bouton" type="submit" value= Modifier >';
        echo '</form>';
        echo ' </div>';
        }else{
            echo "Vous n'êtes pas connecté";
            echo '<meta http-equiv="refresh" content="1; url=index.php"/>';
        }
    ?>

    <div class='liensBas'>
		<a 	href="quisommenous.php" >Qui sommes-nous ? </a>
		<a 	href="contact.php" > Contact </a>
		<a 	href="mentionLegales.php" >	Mentions légales </a>
		<a 	href="donneesPersonnelles.php" > Données personnelles </a>
    </div>


</body>

</html>
