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
	   
       <p>Bienvenue sur Medic'Info! Un doute concernant les médicaments que vous prenez ou bien besoin d'informations? Ce site est fait pour vous, peu importe votre âge, votre profession, votre mode de vie, Medic'Info a pour but de vous aider en vous apportant le plus d'informations possible à propos d'un médicament.</p>
       
       <p>Sur notre site, vous trouverez donc:</p>
       <ul>
        <li>toute les informations nécessaires concernant le médicament de votre choix</li>
        <li>des graphiques concernant les taux de remboursement et les 10 médicaments les plus mis en favoris</li>
        <li>un espace commentaire dans lequel vous pouvez nous faire part de ce que vous souhaitez si vous êtes inscrit au site</li>
	<li>la mise en favoris des médicaments que vous désirez retrouver en quelques clics (aussi pour les inscrits)</li>
       </ul>
       
       <h2>Nous accélérons vos recherches médicamenteuses</h2>
       <p>Medic'Info constitue un maillon essentiel pour faciliter l'accès aux informations d'un médicament. À travers le nom, la voie d'administration ou le Code CIS, vous trouverez en un clic tout ce que vous devez savoir sur le médicament recherché. Afin d'avoir un accès plus pratique au site ainsi que des fonctionnalités particulières, nous vous recommandons vivement de vous inscrire, promis vous ne recevrez pas tout un tas de mails inutiles.</p>
    
       <h3>Nous en bref</h3>
       <p>Nous sommes Marie, Eva, Manel et Léa, quatre étudiantes en licence Mathématiques et Informatique appliquées aux sciences humaines et sociales à l'université de Paul Valery à Montpellier. Dans le cadre de notre troisième année de licence nous devons, à partir d'une base de données, créer entièrement un site web. Après plusieurs semaines de travail, c'est ainsi qu'est né Medic'Info, un site à titre informatif s'appuyant sur la base de données publique des médicaments qui, nous l'espérons, saura vous guider dans le choix de vos médicaments tout en vous apportant un maximum d'informations.
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