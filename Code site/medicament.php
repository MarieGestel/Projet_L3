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
	
		
		require('bd.php');
	
		$CodeCIS=$_GET['CodeCIS'];	
		$nom=$_GET['nom'];
		$voieAdm=$_GET['voieAdm'];
		$code=$_GET['code'];
		
		$repSpe = $bdd->query("SELECT * FROM specialite WHERE CodeCIS='{$CodeCIS}'");
		$repPres = $bdd->query("SELECT * FROM presentation WHERE CodeCIS='{$CodeCIS}'");

		
		while ($matSpe=$repSpe->fetch()){	
			echo "<p>  <span class='cat'>  Code CIS </span> <span class='cat'> Dénomination </span> <span class='cat'> Titulaire </span> </p>";
			echo "<p> </br> <span class='info'>". $matSpe['CodeCIS'] . "</span><span class='info'> ". $matSpe['Denomination_medicament'] . "</span><span class='info'>".$matSpe['Titulaire(s)']."</span></br> </p>";
			echo "<p><span class='cat'> Voie d'administration </span> <span class='cat'> Forme pharmaceutique </span></p>";
			echo "<p> </br><span class='info'>". $matSpe['Voie_administration'] . "</span><span class='info'>". $matSpe['Forme_pharmaceutique'] . "</span><span class='info'></br> </p>";
			echo "<p><span class='cat'> Type de procédure </span> <span class='cat'> Date de mise sur le marché </span></p>";
			echo "<p> </br><span class='info'>". $matSpe['Type_procedure_AMM'] . "</span><span class='info'>". $matSpe['Date_AMM'] . "</span></br> </p>";
	}	

	
	while ($matPres=$repPres->fetch()){	
			echo "<div id='bulle'> <p class='cat'>Prix </p>  <p class='info'> Min ".$matPres['prix_min']." € | Max ". $matPres['Prix_max']." € </br> </p> <p class='cat'> Taux de remboursement </br></p> <p class='info'>".$matPres['Taux_remboursement']."</p>";
		}
					
		$repSpe ->closeCursor();
		$repPres ->closeCursor();
		
	echo "<form action='AjouterFavoris.php' method='post' autocomplete='on'>
	<p>
	<input  type='hidden' name='codeCIS' value='".$CodeCIS."'/>
	<input class='recherche' type='submit' value='Ajouter aux favoris'>
	</p>
	</form>
	";
		
		
	echo"
	
	<p class='retour'>
	<a 	href='recherche.php?nom=".$nom."&codeCIS=".$code."&voieAdm=".$voieAdm."' >
			Retour
		</a>
	</p>";
	
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