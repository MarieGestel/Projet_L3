<?php
session_start();// Permet l'activation de la session du client connecté
require('bd.php'); // importe le fichier bd.php
$bdd = getBD() ; // appel la focntion getBD() 
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
		//Si utilisateur connecté
			echo '<a href="favoris.php" > Favoris </a>';
		echo "<a href='profil.php'> profil </a>";
		echo '<a href="deconnexion.php"> Déconnexion </a>';
	} else {
		//Si aucun utilisateur connecté
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
	<input class='recherche' type='text' name='forme' value='' placeholder='forme pharmaceutique'/>
	<input  class='recherche'type='text' name='codeCIS' value='' placeholder='Code CIS'/>
	<input class='recherche' type="submit" value="Rechercher">
	</form>
	

	<div id='rechercheMedicament'>
	<?php
	//Récupération des  variables envoyées depuis pageRecherche
		if(isset($_GET['CodeCIS'])){
			$CodeCIS=$_GET['CodeCIS'];	
		}else{
			$CodeCIS="";	
		}
		if(isset($_GET['nom'])){
			$nom=$_GET['nom'];
		}else{
			$nom="";
		}
		if(isset($_GET['voieAdm'])){
			$voieAdm=$_GET['voieAdm'];
		}else{
			$voieAdm="";
		}
		if(isset($_GET['forme'])){
			$forme=$_GET['forme'];
		}else{
			$forme="";
		}
		
		//Requêtes permettant de récupérer les données qui sont dans la base de données selon les informations passées en paramètre
		//#1 récupération des informations mis dan sla table spécialité 
		$repSpe = $bdd->query("SELECT * FROM specialite WHERE CodeCIS='{$CodeCIS}'"); 
		//#2 récupération des informations mis dans la table présentation
		$repPres = $bdd->query("SELECT * FROM presentation WHERE CodeCIS='{$CodeCIS}'");
		//#3 Permet de savoit si un médicament a un générique
		$repgene = $bdd->query("SELECT generique_medicament.libelle_gp_gen as libelle_generique,generique_medicament.type_generique as type_generique FROM generique_medicament,specialite,est_le_generique_de WHERE specialite.CodeCIS=est_le_generique_de.CodeCIS And generique_medicament.ID_grp_generique=est_le_generique_de.ID_gp_gen And specialite.CodeCIS='{$CodeCIS}'");
		//#4 récupération des composants du médicament
		$repSub = $bdd->query("SELECT composants.nom_substance as substance,composants.dose_substance as dose FROM composants,specialite,est_compose_de WHERE specialite.CodeCIS=est_compose_de.CodeCIS And composants.Code_substance=est_compose_de.Code_substance And specialite.CodeCIS='{$CodeCIS}'");
		//#5 permet de savoir si le médicament a des Conditions de prescription ou de délivrance
		$repcpd = $bdd->query("SELECT Condition_prescription_ou_delivrance FROM cpd WHERE CodeCIS='{$CodeCIS}'");
		
		while ($matSpe=$repSpe->fetch()){	
			//Recupération des information des requêtes #1 
			echo "<p class='cat'>  <span >  CodeCIS |  dénomination | Titulaire :  </span> </p> ";
			echo "<p> <span class='info'> CodeCIS : ". $matSpe['CodeCIS'] . " | Dénomination : ".$matSpe['Denomination_medicament']." | Titulaire : ".$matSpe['Titulaire(s)']."</span> </p> ";
			echo "<p class='cat'> <span> Voie d'administration  | Forme pharmaceutique </span></p>";
			echo "<p> <span class='info'> Voie d'administration : ". $matSpe['Voie_administration']." | Forme pharmaceutique :".$matSpe['Forme_pharmaceutique']." </span>  ";
			echo "<p class='cat'> <span> Date de mise sur le marché </span></p>";
			echo "<p> <span class='info'>". $matSpe['Date_AMM']. "</span> </p>";
		}

	while ($matPres=$repPres->fetch()){	
		//Recupération des information de la requêtes #2
		echo "<span id='bulle'>
		<p class='cat'> Prix </p>  
		<p class='info'> Min ".$matPres['prix_min']." € | Max ". $matPres['Prix_max']." € </br> </p> 
		<p class='cat'> Taux de remboursement </br></p> 
		<p class='info'>".$matPres['Taux_remboursement']."%</p>";
		echo "</span> ";
	}

	$substance=0;
	echo "<p class='cat'> Substances Utilisées : </p>" ; 
	while ($matSub=$repSub->fetch()){	
		//Recupération des information de la requêtes #4
		echo "<span id='bulle'> <p class='info'> substance : ".$matSub['substance']." | dose : ". $matSub['dose']." </br> </p>";
		$substance=$matSub['substance'];
	}
	echo "</span> ";

	while ($matGene=$repgene->fetch()){	
		//Recupération des information de la requêtes #3
		echo "<p class='cat'>Generique </p>";  
		echo "<span id='bulle'> 
		<p class='info'> Nom du Generique : ".$matGene['libelle_generique']." | type de generique : ". $matGene['type_generique']." </br> </p> ";
		echo "</span> ";
	}

	$count = $bdd->query("SELECT count(*) FROM cpd WHERE CodeCIS='{$CodeCIS}'");
		//Permet de savoir s'il faut prendre en compte la requêtes #5
	$compter=0;
	while ($ligne=$count->fetch()){	
		$compter=$ligne[0];
	}
	if($compter!=0){
		echo "<p class='cat'> Conditions de prescription et de délivrance : </p>" ; 
	while ($matcpd=$repcpd->fetch()){	
		//Recupération des information de la requêtes #5
		echo "<span id='bulle'> 
		<p class='info'>".$matcpd['Condition_prescription_ou_delivrance']."</p> ";
		echo "</span> ";
	}	
}
		$count ->closeCursor();
		$repSpe ->closeCursor();
		$repPres ->closeCursor();
		$repgene ->closeCursor();
		$repSub ->closeCursor();
	
	// requête associé a la recommandation => Permet de savoir si le médicament de la recherche utilise les mêmes sustances qu'un médicament qui aurait été mis dans la table favoris
	$req="SELECT specialite.CodeCIS, Denomination_medicament,Forme_pharmaceutique ,Voie_administration FROM specialite, favoris, composants, est_compose_de WHERE est_compose_de.CodeCIS=specialite.CodeCIS AND est_compose_de.Code_substance=composants.Code_substance AND composants.nom_substance LIKE '%".$substance."%'";

	// requête de savoir si la requête prédente existe
	$req2="SELECT count(*) FROM specialite, favoris, composants, est_compose_de WHERE est_compose_de.CodeCIS=specialite.CodeCIS AND est_compose_de.Code_substance=composants.Code_substance AND composants.nom_substance LIKE '%".$substance."%' ";
	if($CodeCIS!=""){
		$req=$req." AND specialite.CodeCIS!=".$CodeCIS;
		$req2=$req2." AND specialite.CodeCIS!=".$CodeCIS;
	}
	$req=$req." AND favoris.CodeCIS=specialite.CodeCIS  GROUP BY favoris.CodeCIS ORDER BY specialite.CodeCIS DESC LIMIT 5 ";
	$req2=$req2." AND favoris.CodeCIS=specialite.CodeCIS GROUP BY favoris.CodeCIS";
	$rep=$bdd->query($req);
	$rep2=$bdd->query($req2);
	$resultatreq2=0; 
	
	
	while($ligne=$rep2->fetch()){
		$resultatreq2=$ligne[0];
	} 
	$rep2->closeCursor();

	if($resultatreq2!=0){
		echo "<p class='cat'> D'autres ont mis en favoris : </p>"; 
		while ($mat=$rep->fetch()){ // récupération des informations pour la recommandation
			echo "<p class='resultatRecherche'> Code CIS : <a href='medicament.php?CodeCIS=".$mat['CodeCIS']."&nom=".$nom."&voieAdm=".$mat['Voie_administration']."&forme=".$mat['Forme_pharmaceutique']."'>".$mat['CodeCIS']."</a> |  Nom du médicament : ".$mat['Denomination_medicament']." </br> </p>";
	}
	}
		$rep->closeCursor();
	
	if (isset($_SESSION['client'])){// savori si le client est connecté 
		// Si oui peut ajouter le médicament à ses favoris
		echo "<form action='AjouterFavoris.php' method='post' autocomplete='on'>
		<p>
		<input  type='hidden' name='codeCIS' value='".$CodeCIS."'/> 
		<input class='recherche' type='submit' value='Ajouter aux favoris'>
		</p>
		</form>
		";
	}
	//permet un retour vers le recherche en gardant en mémoire les variables passées en paramètre
	echo" <p id='retour'> <a href='recherche.php?nom=".$nom."&voieAdm=".$voieAdm."&forme=".$forme."' > Retour vers la recherche </a> </p>";
	?>
	</div>

	<div class='liensBas'>
	<a 	href="quisommenous.php" > Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
</div>
	
	</body>
	
	
	
	
</html>