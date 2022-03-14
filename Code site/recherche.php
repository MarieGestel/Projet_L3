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
	<a 	href="inscripton.html" >
			S'inscrire 
		</a>
	
	<a 	href="connexion.html" >
			Se connecter
		</a>
	</p>
		<h1> 	<a 	id="contact"href="index.html" > Medic'Info </a>  </h1>
		
		<form action='recherche.php' method='get' autocomplete='on'>
	<p>
	<input class='recherche' type='text' name='nom' value='' placeholder='Nom'/>
	<input class='recherche' type='text' name='voieAdm' value='' placeholder="Voie d'administration"/>
	<input  class='recherche'type='text' name='codeCIS' value=''placeholder='Code CIS'/>
	<input class='recherche' type="submit" value="Rechercher">
	</p>
	</form>

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

if(isset($_GET['codeCIS'])){
	$codeCIS=$_GET['codeCIS'];	
}
else{
	$codeCIS=""	;
}


		require('bd.php');
		


if($nom!="" && $voieAdm!="" && $codeCIS!=""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND CodeCIS=".$codeCIS." AND Voie_administration LIKE '%".$voieAdm."%' ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."'>".$mat['CodeCIS']."</a> |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom!="" && $voieAdm=="" && $codeCIS!=""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND CodeCIS=".$codeCIS." ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."'>".$mat['CodeCIS']."</a>  |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom!="" && $voieAdm=="" && $codeCIS==""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."'>".$mat['CodeCIS']."</a>  |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom!="" && $voieAdm!="" && $codeCIS==""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND Voie_administration LIKE '%".$voieAdm."%'  ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."'>".$mat['CodeCIS']."</a>  |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom=="" && $voieAdm!="" && $codeCIS!=""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE CodeCIS=".$codeCIS." AND Voie_administration LIKE '%".$voieAdm."%' ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."'>".$mat['CodeCIS']."</a>  |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom=="" && $voieAdm=="" && $codeCIS!=""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE  CodeCIS=".$codeCIS."  ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."'>".$mat['CodeCIS']."</a>  |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}
elseif($nom=="" && $voieAdm!="" && $codeCIS==""){
	$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE Voie_administration LIKE '%".$voieAdm."%' ");
	while ($mat=$rep->fetch()){
	echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."'>".$mat['CodeCIS']."</a>  |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
	}
	$rep->closeCursor();
}


?>

<p id='liensBas'>
	<a 	href="quisommenous.html" >
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