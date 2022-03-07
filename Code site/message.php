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
		<h1> Medic'Info </h1>
        <?php
               include('bd.php');
               $n=$_GET['n'];
               $p=$_GET['p'];
               $mail=$_GET['mail'];
               $sujet=$_GET['sujet'];
               $comm=$_GET['commentaires'];

                function enregistrer($n, $p,$mail,$sujet,$comm)
                {
                    $seconnecter=getBDMarie();
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


        <p> votre message a bien été envoyé, nous le traiterons au plus vite.</p>
    </body>
    </html>