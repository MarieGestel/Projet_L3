<?php
session_start();
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
	
	<body id='medicament'>
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
		
	<form action='recherche.php' method='get' autocomplete='on'>
	<input class='recherche' type='text' name='nom' value='' placeholder='Nom'/>
	<input class='recherche' type='text' name='voieAdm' value='' placeholder="Voie d'administration"/>
	<input  class='recherche'type='text' name='codeCIS' value=''placeholder='Code CIS'/>
	<input class='recherche' type="submit" value="Rechercher">
	</form>
	

	<div id='rechercheMedicament'>
	<?php
		require('bd.php');
	
		$CodeCIS=$_GET['CodeCIS'];	
		$nom=$_GET['nom'];
		$voieAdm=$_GET['voieAdm'];
		//$code=$_GET['code'];
		
		$repSpe = $bdd->query("SELECT * FROM specialite WHERE CodeCIS='{$CodeCIS}'");
		$repPres = $bdd->query("SELECT * FROM presentation WHERE CodeCIS='{$CodeCIS}'");
		$repgene = $bdd->query("SELECT generique_medicament.libelle_gp_gen as libelle_generique,generique_medicament.type_generique as type_generique FROM generique_medicament,specialite,est_le_generique_de WHERE specialite.CodeCIS=est_le_generique_de.CodeCIS And generique_medicament.ID_grp_generique=est_le_generique_de.ID_gp_gen And specialite.CodeCIS='{$CodeCIS}'");
		$repSub = $bdd->query("SELECT composants.nom_substance as substance,composants.dose_substance as dose FROM composants,specialite,est_compose_de WHERE specialite.CodeCIS=est_compose_de.CodeCIS And composants.Code_substance=est_compose_de.Code_substance And specialite.CodeCIS='{$CodeCIS}'");
		$repcpd = $bdd->query("SELECT Condition_prescription_ou_delivrance FROM cpd WHERE CodeCIS='{$CodeCIS}'");
		
		while ($matSpe=$repSpe->fetch()){	
			echo "<p class='cat'>  <span >  CodeCIS |  dénomination | Titulaire :  </span> </p> ";
			echo "<p> <span class='info'> CodeCIS : ". $matSpe['CodeCIS'] . " | Dénomination : ".$matSpe['Denomination_medicament']." | Titulaire : ".$matSpe['Titulaire(s)']."</span> </p> ";
			echo "<p class='cat'> <span> Voie d'administration  | Forme pharmaceutique </span></p>";
			echo "<p> <span class='info'> Voie d'administration : ". $matSpe['Voie_administration']." | Forme pharmaceutique :".$matSpe['Forme_pharmaceutique']." </span>  ";
			echo "<p class='cat'> <span> Date de mise sur le marché </span></p>";
			echo "<p> <span class='info'>". $matSpe['Date_AMM']. "</span> </p>";
		}

	while ($matPres=$repPres->fetch()){	
		echo "<span id='bulle'>
		<p class='cat'> Prix </p>  
		<p class='info'> Min ".$matPres['prix_min']." € | Max ". $matPres['Prix_max']." € </br> </p> 
		<p class='cat'> Taux de remboursement </br></p> 
		<p class='info'>".$matPres['Taux_remboursement']."</p>";
		echo "</span> ";
	}

	echo "<p class='cat'> Substances Utilisées : </p>" ; 
	while ($matSub=$repSub->fetch()){	
		echo "<span id='bulle'> <p class='info'> substance : ".$matSub['substance']." | dose : ". $matSub['dose']." </br> </p>";
	}
	echo "</span> ";

	while ($matGene=$repgene->fetch()){	
		echo "<p class='cat'>Generique </p>";  
		echo "<span id='bulle'> 
		<p class='info'> Nom du Generique : ".$matGene['libelle_generique']." | type de generique : ". $matGene['type_generique']." </br> </p> ";
		echo "</span> ";
	}	
	while ($matcpd=$repcpd->fetch()){	
		echo "<p class='cat'> Condition de prescription et de délivrance : </p>";  
		echo "<span id='bulle'> 
		<p class='info'>".$matcpd['Condition_prescription_ou_delivrance']."</p> ";
		echo "</span> ";
	}	
	
		$repSpe ->closeCursor();
		$repPres ->closeCursor();
		$repgene ->closeCursor();
		$repSub ->closeCursor();
		
	if (isset($_SESSION['client'])){

	echo "<form action='AjouterFavoris.php' method='post' autocomplete='on'>
	<p>
	<input  type='hidden' name='codeCIS' value='".$CodeCIS."'/>
	<input class='recherche' type='submit' value='Ajouter aux favoris'>
	</p>
	</form>
	";
	}
		
	echo" <p id='retour'> <a href='recherche.php?nom=".$nom."&voieAdm=".$voieAdm."' > Retour vers la recherche </a> </p>";
	
	?>
	</div>

	<div class='liensBas'>
	<a 	href="quisommenous.php" > Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="mentionLegales.php" > Mentions légales </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
</div>
	
	</body>
	
	
	
	
</html>