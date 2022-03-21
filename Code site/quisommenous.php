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
      
      <title>qui somme nous</title>
        
   </head>
   <body>
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
	<a 	href="inscription.html" >
			S'inscrire 
		</a>
	
	<a 	href="connexion.php" >
			Se connecter
		</a>

    <?php 
    } 
    ?>
       <h1> 	<a 	id="contact" href="index.php" > Medic'Info </a>  </h1>
	   
       <p>L'activité de Medic'Info est consacrée aux services de gestion médicale à destination de toute population confondue. Medic'Info propose des solutions d'information sur les produits de santé et d'aide a la décision thérapeutique dans une perspective d'amélioration continue des pratiques medicinales.</p>
       
       <p>Nous somme guidées par une statégie qui se décline ainsi</p>
       <ul>
        <li>ouverture et transparence</li>
        <li>performance</li>
        <li>accès au informations d'un medicament</li>
       </ul>
       
       <h2>Nous accélérons vos recherches medicamenteuses</h2>
       <p>Medic'Info constitue un maillon essentiel pour faciliter la mise a disposition en France des informations d'un médicament, des thérapies et des dispositifs médicaux innovants et sûrs, et nous favorisons un accés plus large et rapide aux traitements dans des conditions assurant la securité de nos visiteurs.</p>
    
       <h3>Nous en bref</h3>
       <p>Nous somme quatre étudiantes en licence Mathématiques et Informatique appliquées aux sciences humaines et sociales a l'université de Paul Valery Montpellier , notre cursus s'est donc achevé par notre projet de fin d'études qui a donné naissance à Medic'Info.
       </p>
      <img src="Images/universite-paul-valery-montpellier-3.png">

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