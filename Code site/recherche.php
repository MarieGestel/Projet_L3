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
	
	<body class='inscrire'>
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
	<h1> 	<a href="index.php" > MEDIC'INFO </a>  </h1>
		
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
	
if($nom!="" || $voieAdm!="" || $codeCIS!="" || $forme!=""){
	
	$req="SELECT count(*)  FROM specialite WHERE 1=1 ";
	
	if($nom!=""){
		$req=$req."AND denomination_medicament LIKE '%".$nom."%' ";
	}
	if($voieAdm!=""){
		$req=$req."AND Voie_administration LIKE '%".$voieAdm."%'";
	}
	if($codeCIS!=""){
		$req=$req."AND CodeCIS=".$codeCIS;
	}
	if($forme!=""){
		$req=$req."AND Forme_pharmaceutique LIKE '%".$forme."%'";
	}
	
	$present=$bdd->query($req);
	
	while ($result=$present->fetch()){
		$ligne=$result[0];
	}
	
	 if($ligne!=0){
		$req2="SELECT CodeCIS, denomination_medicament  FROM specialite WHERE 1=1 ";
	if($nom!=""){
		$req2=$req2."AND denomination_medicament LIKE '%".$nom."%' ";
	}
	if($voieAdm!=""){
		$req2=$req2."AND Voie_administration LIKE '%".$voieAdm."%'";
	}
	if($codeCIS!=""){
		$req2=$req2."AND CodeCIS=".$codeCIS;
	}
	if($forme!=""){
		$req2=$req2."AND Forme_pharmaceutique LIKE '%".$forme."%'";
	}
	$rep=$bdd->query($req2);
	
		while ($mat=$rep->fetch()){
			echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&forme=".$forme."'>".$mat['CodeCIS']."</a> |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
		}
		$rep->closeCursor();
	}else{
		echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
	}
	}
	else{
		echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
	} 
	
	
/* if($nom!="" && $voieAdm!="" && $codeCIS!=""){
>>>>>>> 716f0b41791c33df5b4e9eb290d3192aaaa3fd19
	$present =$bdd->query("SELECT count(*)  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND CodeCIS=".$codeCIS." AND Voie_administration LIKE '%".$voieAdm."%'");
	$ligne=0;
	while ($result=$present->fetch()){
		$ligne=$result[0];
	}
	if($ligne!=0){
		$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND CodeCIS=".$codeCIS." AND Voie_administration LIKE '%".$voieAdm."%'");
		while ($mat=$rep->fetch()){
			echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |  Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
		}
		$rep->closeCursor();
	}else{
		echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
	}
}
elseif($nom!="" && $voieAdm=="" && $codeCIS!=""){
	$present =$bdd->query("SELECT count(*)  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND CodeCIS=".$codeCIS." ");
	$ligne=0;
	while ($result=$present->fetch()){
		$ligne=$result[0];
	}
	if($ligne!=0){
		$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND CodeCIS=".$codeCIS." ");
		while ($mat=$rep->fetch()){
			echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
		}
		$rep->closeCursor();
	}else{
		echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
	}
}
elseif($nom!="" && $voieAdm=="" && $codeCIS==""){
	$present =$bdd->query("SELECT count(*)  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' ");
	$ligne=0;
	while ($result=$present->fetch()){
		$ligne=$result[0];
	}
	if($ligne!=0){
		$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' ");
		while ($mat=$rep->fetch()){
			echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
		}
		$rep->closeCursor();
	}else{
		echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
	}
}
elseif($nom!="" && $voieAdm!="" && $codeCIS==""){
	$present =$bdd->query("SELECT count(*)  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND Voie_administration LIKE '%".$voieAdm."%'  ");
	$ligne=0;
	while ($result=$present->fetch()){
		$ligne=$result[0];
	}
	if($ligne!=0){
		$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE denomination_medicament LIKE '%".$nom."%' AND Voie_administration LIKE '%".$voieAdm."%'  ");
		while ($mat=$rep->fetch()){
			echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
		}
		$rep->closeCursor();
	}else{
		echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
	}
}
elseif($nom=="" && $voieAdm!="" && $codeCIS!=""){
	$present =$bdd->query("SELECT count(*) FROM specialite WHERE CodeCIS=".$codeCIS." AND Voie_administration LIKE '%".$voieAdm."%' ");
	$ligne=0;
	while ($result=$present->fetch()){
		$ligne=$result[0];
	}
	if($ligne!=0){
		$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE CodeCIS=".$codeCIS." AND Voie_administration LIKE '%".$voieAdm."%' ");
		while ($mat=$rep->fetch()){
			echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
		}
		$rep->closeCursor();
	}else{
		echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
	}
}
elseif($nom=="" && $voieAdm=="" && $codeCIS!=""){
	$present = $bdd->query("SELECT count(*) FROM specialite WHERE  CodeCIS=".$codeCIS."  ");
	$ligne=0;
	while ($result=$present->fetch()){
		$ligne=$result[0];
	}
	if($ligne!=0){
		$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE  CodeCIS=".$codeCIS."  ");
		while ($mat=$rep->fetch()){
			echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
		}
		$rep->closeCursor();
	}else{
		echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
	}	
}elseif($nom=="" && $voieAdm!="" && $codeCIS==""){
	$present = $bdd->query("SELECT count(*) FROM specialite WHERE Voie_administration LIKE '%".$voieAdm."%' ");
	$ligne=0;
	while ($result=$present->fetch()){
		$ligne=$result[0];
	}
	if($ligne!=0){
		$rep = $bdd->query("SELECT CodeCIS, denomination_medicament  FROM specialite WHERE Voie_administration LIKE '%".$voieAdm."%' ");
		while ($mat=$rep->fetch()){
			echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$voieAdm."&code=".$codeCIS."'>".$mat['CodeCIS']."</a> |   Nom du médicament : ".$mat['denomination_medicament']." </br> </p>";
		}
		$rep->closeCursor();
	}else{
		echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
	}
}
else{
	echo "<p class='resultatRecherche'> Aucun médicament ne correspond a votre recherche </p>";
} */

?>

	<div class='liensBas'>
	<a 	href="quisommenous.php" > Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="mentionLegales.php" > Mentions légales </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
	</div>
	
	</body>
	
</html>