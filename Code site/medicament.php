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
	

	
	
	<form action='recherche.php' method='get' autocomplete='on'>
	<p>
	<input class='recherche' type='text' name='nom' value='' placeholder='Nom'/>
	<input class='recherche' type='text' name='voieAdm' value='' placeholder="Voie d'administration"/>
	<input  class='recherche'type='text' name='codeCIS' value=''placeholder='Code CIS'/>
	<input class='recherche' type="submit" value="Rechercher">
	</p>
	</form>

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
		
		while ($matSpe=$repSpe->fetch()){	
			echo "<p>  <span class='cat'>  Code CIS </span> <span class='cat'> Dénomination </span> <span class='cat'> Titulaire </span> </p>";
			echo "<p> </br> <span class='info'>". $matSpe['CodeCIS'] . "</span><span class='info'> ". $matSpe['Denomination_medicament'] . "</span><span class='info'>".$matSpe['Titulaire(s)']."</span></br> </p>";
			echo "<p><span class='cat'> Voie d'administration </span> <span class='cat'> Forme pharmaceutique </span></p>";
			echo "<p> </br><span class='info'>". $matSpe['Voie_administration'] . "</span><span class='info'>". $matSpe['Forme_pharmaceutique'] . "</span><span class='info'></br> </p>";
			echo "<p><span class='cat'> Type de procédure </span> <span class='cat'> Date de mise sur le marché </span></p>";
			echo "<p> </br><span class='info'>". $matSpe['Type_procedure_AMM'] . "</span><span class='info'>". $matSpe['Date_AMM'] . "</span></br> </p>";
	}	
	echo "</div> ";

	while ($matPres=$repPres->fetch()){	
		echo "<div id='bulle'> <p class='cat'> Prix </p>  <p class='info'> Min ".$matPres['prix_min']." € | Max ". $matPres['Prix_max']." € </br> </p> <p class='cat'> Taux de remboursement </br></p> <p class='info'>".$matPres['Taux_remboursement']."</p>";
	}
	echo "</div> ";

	
	echo "<p class='cat'> Substances Utilisées : </p>" ; 
	while ($matSub=$repSub->fetch()){	
		echo "<div id='bulle'> <p class='info'> substance : ".$matSub['substance']." | dose : ". $matSub['dose']." </br> </p>";
	}
	echo "</div> ";

	echo "<p class='cat'>Generique </p>";  
	while ($matGene=$repgene->fetch()){	
			echo "<div id='bulle'> 
			<p class='info'> Nom du Generique : ".$matGene['libelle_generique']." | type de generique : ". $matGene['type_generique']." </br> </p> ";
	}	
	echo "</div> ";	
	
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
		
	echo"
	
	<p class='retour'>
	<a 	href='recherche.php?nom=".$nom."&voieAdm=".$voieAdm."' >
			Retour vers la recherche
		</a>
	</p>";
	
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