<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type"
		content="text/html; charset=UTF-8"/>
		<link rel="stylesheet" href="styles.css"
		type="text/css" media="screen" /> 
		
		<title>Nous contacter</title>
	</head>

	<body>
		<h1> 	<a 	id="contact"href="index.html" > Medic'Info </a>  </h1>
		
		<p id="inscriptionConnexion">
	<a 	href="inscripton.html" >
			S'inscrire 
		</a>
	
	<a 	href="connexion.html" >
			Se connecter
		</a>
	</p>
	
        <?php
               include('bd.php');
               $n=$_GET['n'];
               $p=$_GET['p'];
               $mail=$_GET['mail'];
               $sujet=$_GET['sujet'];
               $comm=$_GET['commentaires'];

                function enregistrer($n, $p,$mail,$sujet,$comm)
                {
                    $seconnecter=getBD();
                     if (!$seconnecter){
                         $MessageConnexion = die (" la connection impossible");
                     }
                     else {
                         $res="INSERT INTO commentaires(nom,prenom,mail,sujet,commentaire) VALUES ('".$n."','".$p."','".$mail."','".$sujet."','".$comm."')";
                         if($seconnecter->exec($res)!= false){
                             echo '';
                         }
                     }
                 }
                 if($n=="" || $p==""|| $mail==""|| $sujet==""|| $comm=="") {
                ?>
                    <!-- <meta http-equiv="refresh" content="0; url=http://localhost:8888/Gestel/nouveau.php?n="> -->
                <?php        
                } else{
                    enregistrer($n, $p,$mail,$sujet,$comm);
                }
                ?>


        <p> Votre message a bien été envoyé, nous le traiterons au plus vite.</p>
		
		
			
<p id='liensBas'>
	<a 	href="quiSommesNous.php" >
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