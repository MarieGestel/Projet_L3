<?php
	session_start();
 	require('bd.php');
	$bdd = getBD() ; 
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
	
	<body class='rechercheIndex'>
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
	<h1> <a id="contact"href="index.php" > MEDIC'INFO </a>  </h1>
	<h2><a href='pageRecherche.php'> Recherche </a> <a href='donneesclees.php'> Données clées </a> </h2>

	<div class='graphique'>
	<h2> Pourcentage des médicaments remboursés à un certain taux selon la Voie d'administration : </h2>
	<form action='graphiqueRemboursement.php' method='get' autocomplete='on'>
	<select class='recherche' name='voieAdm'  id='voieAdm'>
	<option value=""> voie d'administration </option>
    <option value="auriculaire"> auriculaire </option>
    <option value="buccogingivale"> buccogingivale </option>
    <option value="cutanée"> cutanée </option>
	<option value="endotrachéobronchique"> endotrachéobronchique</option>
	<option value="épilésionnelle"> épilésionnelle </option>
	<option value="gastrique"> gastrique</option>
	<option value="gastro-entérale"> gastro-entérale</option>
	<option value="gingivale"> gingivale</option>
	<option value="hémodialyse"> hémodialyse</option>
	<option value="hémofiltration"> hémofiltration</option>
	<option value="implantation "> implantation </option>
    <option value="infiltration "> infiltration </option>
	<option value="inhalée"> inhalée</option>
    <option value="intestinale "> intestinale </option>
    <option value="inta-artérielle "> inta-artérielle </option>
    <option value="intra-articulaire"> intra-articulaire </option>
	<option value="intra-camérulaire"> intra-camérulaire</option>
    <option value="intra-mural "> intra-mural </option>
    <option value="intra-oculaire"> intra-oculaire </option>
	<option value="intra-osseuse"> intra-osseuse </option>
    <option value="intra-utérine"> intra-utérine</option>
    <option value="intrabursale"> intrabursale</option>
	<option value="intracoronaire"> intracoronaire </option>
    <option value="intradermique"> intradermique </option>
    <option value="intralésionnelle"> intralésionnelle</option>
	<option value="intramusculaire"> intramusculaire</option>
	<option value="intraséreuse"> intraséreuse</option>
	<option value="intrathécale"> intrathécale</option>
	<option value="intraveineuse"> intraveineuse</option>
	<option value="intraventriculaire cétébrale"> intraventriculaire cétébrale</option>
	<option value="intravésicale"> intravésicale</option>
	<option value="intravitréenne"> intravitréenne</option>
	<option value="nasale "> nasale </option>
	<option value="ophtalmique"> ophtalmique </option>
	<option value="orale"> orale</option>
	<option value="périarticulaire"> périarticulaire </option>
	<option value="péribulbaire"> péribulbaire</option>
	<option value="éridurale"> péridurale</option>
	<option value="périneurale"> périneurale</option>
	<option value="périosseuse"> périosseuse</option>
	<option value="rectale"> rectale</option>
	<option value="sous-conjonctivale"> sous-conjonctivale</option>
	<option value="sous-cutanée"> sous-cutanée</option>
	<option value="sous-musqueuse"> sous-musqueuse</option>
	<option value="sublinguale"> sublinguale</option>
	<option value="transdermique"> transdermique</option>
	<option value="urétrale"> urétrale</option>
	<option value="vaginale"> vaginale</option>
	<option value="voie buccale autre"> voie buccale autre </option>
	<option value="voie extracorporelle autre"> voie extracorporelle autre</option>
	</select>
	<input class='recherche' type="submit" value="Rechercher">
	</form> 

	<?php
	if(isset($_GET['voieAdm']) ){
		if($_GET['voieAdm']!=""){
			if($_GET['voieAdm']=="noData"){
				echo"<div class='noData'> <p> Aucune donnée n'est disponible pour votre sélection. </p> </div>";
			}
			else{
			echo '<div><img src="remboursement.png" alt ="graphique" /> </div>';
			}
		} 
	}
	?>
	<h2> Pourcentage des médicaments remboursés à un certain taux selon la forme Pharmaceutique : </h2>
	<form action='graphiqueRemboursement.php' method='get' autocomplete='on'>
	<select class='recherche' name="formePhar" id='forme'>
	<option value=""> forme pharmaceutique</option>
    <option value="capsule"> capsule </option>
    <option value="collyre"> collyre </option>
    <option value="comprimé"> comprimé</option>
    <option value="crème"> crème</option>
	<option value="dispersible"> dispersible</option>
    <option value="dispositif transdermique"> dispositif </option>
    <option value="emplâtre"> emplâtre </option>
    <option value="émulsion"> émulsion</option>
    <option value="gel"> gel</option>
    <option value="gélule"> gélule</option>
    <option value="granulés"> granulés </option>
    <option value="lyophilisat"> lyophilisat </option>
    <option value="pastille"> pastille</option>
    <option value="pommade"> pommade </option>
    <option value="poudre"> poudre</option>
    <option value="sirop"> sirop</option>
    <option value="solution"> solution </option>
    <option value="suspension"> suspension </option>
    </select>
	<input class='recherche' type="submit" value="Rechercher">
	</form>  
	
	<?php
	if(isset($_GET['forme']) ){
		if($_GET['forme']!=""){
			if($_GET['forme']=="noData"){
				echo"<div class='noData'> <p> Aucune donnée n'est disponible pour votre sélection. </p> </div>";
			}
			else{
			echo '<div> <img src="remboursement.png" alt ="graphique" /> </div>';
			}
		}
	}
	?>
	</div>
	<div class='liensBas'>
	<a 	href="quisommenous.php" >Qui sommes-nous ? </a>
	<a 	href="contact.php" > Contact </a>
	<a 	href="donneesPersonnelles.php" > Données personnelles </a>
	<a 	href="baseDeDonnees.php" > Base de données </a>
	</div>
</body>
</html>
	
	
