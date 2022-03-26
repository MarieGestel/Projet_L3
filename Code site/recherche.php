<?php
	session_start();
	require('bd.php');
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
   		 	echo '<a href="favoris.php" > favoris </a>';
    		echo '<a href="deconnexion.php"> Déconnexion </a>';
    		echo '<a href="profil.php"> Votre profil </a>';
    	} else {
			echo "<a href='inscription.php' > S'inscrire </a>";
			echo '<a href="connexion.php" > Se connecter </a>';
    	} 
    ?>
	<h1> 	<a 	id="contact"href="index.php" > Medic'Info </a>  </h1>
		
	<?php
		if(isset($_GET['nom'])){
			$nom=$_GET['nom'];	
		}
		else{
			$nom=""	;
		}

		if(isset($_GET['voieAdm'])){
			$voieAdm=$_GET['voieAdm'];	
		}
		else{
			$voieAdm=""	;
		}
		if(isset($_GET['forme'])){
			$forme=$_GET['forme'];	
		}
		else{
			$forme=""	;
		}

		if(isset($_GET['codeCIS'])){
			$codeCIS=$_GET['codeCIS'];	
		}
		else{
			$codeCIS=""	;
		}

echo " <form action='recherche.php?nom=".$nom."&voieAdm=".$voieAdm."&forme=".$forme."&codeCIS=".$codeCIS." method='get' autocomplete='on'>
			<p>
			<input class='recherche' type='text' name='nom' value='".$nom."' placeholder='Nom'/>
			<input class='recherche' type='text' name='voieAdm' value='".$voieAdm."' placeholder='Voie Administration'/>
			<input class='recherche' type='text' name='forme' value='".$forme."' placeholder='forme pharmaceutique'/>
			<input  class='recherche'type='text' name='codeCIS' value='".$codeCIS."'placeholder='Code CIS'/>
			<input class='recherche' type='submit' value='Rechercher'>
			</p>
		</form>";
	
if($nom!="" && $voieAdm!="" && $codeCIS!=""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND CodeCIS=".$codeCIS." AND Voie_administration LIKE '%".$voieAdm."%'");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom!="" && $voieAdm=="" && $codeCIS!=""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND CodeCIS=".$codeCIS." ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom!="" && $voieAdm=="" && $codeCIS==""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom!="" && $voieAdm!="" && $codeCIS==""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND Voie_administration LIKE '%".$voieAdm."%'  ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom=="" && $voieAdm!="" && $codeCIS!=""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE CodeCIS=".$codeCIS." AND Voie_administration LIKE '%".$voieAdm."%' ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom=="" && $voieAdm=="" && $codeCIS!=""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE  CodeCIS=".$codeCIS."  ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom=="" && $voieAdm!="" && $codeCIS==""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE Voie_administration LIKE '%".$voieAdm."%' ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
else{
	echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
}

?>

<p id='liensBas'>
	<a 	href="quisommenous.php" >
			Qui sommes-nous ?
		</a>
	
	<a 	href="contact.php" >
			Contact
		</a>
	
	<a 	href="mentionLegales.php" >
			Mentions légales
		</a>
	
	<a 	href="donneesPersonnelles.php" >
			Données personnelles
		</a>
	
	<a 	href="baseDeDonnees.php" >
			Base de données
		</a>
	</p>
	
	</body>
	
</html>