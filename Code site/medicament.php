<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type"
		content="text/html; charset=UTF-8" />
		
		<link rel="stylesheet" href="styles.css"
		type="text/css" media="screen" />
		
		<?php 
		//$medicament$_GET['medicament'];
		//echo "<title>".$medicament."</title>";
		?>
		
	</head>
	
	<body id='medicament'>
	
	<h1>Medic'Info</h1>

	<?php 

		
		$bdd = new PDO('mysql:host=localhost;dbname=bdd_medicament;charset=utf8', 'root', 'root');

		//require('bd.php');
		//$bdd = getBD() ;
	
		//$CodeCIS=$_GET['CodeCIS'];				
		$CodeCIS='60022275';
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
			//echo "<img src='".$matPres['url_photo']. "' alt ='Image médicament ".$CodeCIS."' />";
		}
					
		$repSpe ->closeCursor();
		$repPres ->closeCursor();
		

		
	?>
	
	
	<p class='retour'>
	<a 	href="index.html" >
			Retour
		</a>
	</p>
	
	
	<p id='liensBas'>
	<a 	href="quisommesnous.html" >
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