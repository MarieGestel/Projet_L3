<?php
       $bdd = new PDO('mysql:host=localhost;dbname=bd_manel;charset=utf8', 'root', 'root');
?>

<!DOCTYPE html>
<html>
   <head>
       <meta http-equiv="Content-Type"
		content="text/html; charset=UTF-8" />
       
       <link rel="stylesheet" href="styles.css"
		type="text/css" media="screen" />
       
</head>
   <body>
       <?php
       $bdd = new PDO('mysql:host=localhost;dbname=bd_manel;charset=utf8', 'root', 'root');

       <h1> 	
           <a 	id="contact"href="index.html" > Medic'Info </a> 
           </h1>
	   
       <p id="inscriptionConnexion">

	<a 	href="connexion.html" >
			Se connecter
		</a>
           </p>
	
		
	<h2>
	<a 	href="rechercheNom.php" >
			Recherche par nom 
		</a>
	
	<a 	href="rechercheVoieAdm.php" >
			 Recherche par voie d'administration 
		</a>
	
	<a 	href="rechercheCodeCIS.php" >
			 Recherche par code CIS
		</a>
           <?php
       $bdd = new PDO('mysql:host=localhost;dbname=bd_manel;charset=utf8', 'root', 'root');
?>

	
	<form action="connexion.php" method="get" autocomplete="off">
	</form>

<p>	
    Page d'inscription
      
	</p>
   
    <?php
         $nom=$_GET['nom'];
         $pre=$_GET['prenom'];
         $sexe=$_GET['sexe'];
         $date=$_GET['date'];
         $EML=$_GET['eml'];
         $mail=$_GET['email'];
         $pws=$_GET['pwd'];
         $mdp=$_GET['pass'];
       
    $req="inser into inscription (nom,prenom,sexe,date de naissance,email,confirmation email,mot de passe,confirmation mot de passe) values ('$nom','$pre','$sexe',$date,'$EML','$mail','$pws','$mdp')";
       $res=mysql_query($conn,$res);
?>
    
       <p>
	<a 	href="quiSommesNous.php" >

   
       <p id='liensBas'>
	<a 	href="quisommenous.html" >
			Qui sommes-nous ?
		</a>s
	
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
           