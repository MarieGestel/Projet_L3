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
		<h1> 	<a 	id="contact" href="index.php" > Medic'Info </a>  </h1>
        <?php
            include('bd.php');
            function enregistrer($n, $p,$mail,$sujet,$comm){
                $seconnecter=getBDMarie();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                } else {
                    $res="INSERT INTO commentaires(nom,prenom,mail,sujet,commentaire) VALUES ('".$n."','".$p."','".$mail."','".$sujet."','".$comm."')";
                    $seconnecter->exec($res);
                }
            }
            if(isset($_POST['n'])){
                $n=$_POST['n'];
            }else{
                $n="";
            }

            if(isset($_POST['p'])){
                $p=$_POST['p'];
            }else{
                $p="";
            }

            if(isset($_POST['mail'])){
                $mail=$_POST['mail'];
            }else{
                $mail="";
            }

            if(isset($_POST['sujet'])){
                $sujet=$_POST['sujet'];
            }else{
                $sujet="";
            }

            if(isset($_POST['commentaires'])){
                $comm=$_POST['commentaires'];
            }else{
                $comm="";
            }

            if($n=="" || $p==""|| $mail==""|| $sujet==""|| $comm=="") {  
                echo '<meta http-equiv="refresh" content="O; url=contact.php?nom='.$n.'&mail='.$mail.'"/>';    
            } else{
                enregistrer($n, $p,$mail,$sujet,$comm);
                echo '<p> Votre message a bien été envoyé, nous le traiterons au plus vite.</p>';
                echo '<meta http-equiv="refresh" content="1; url=index.php"/>';    
            }
        ?>
        <p id='liensBas'>
	        <a 	href="quiSommesNous.php" > Qui sommes-nous ? </a>
	        <a 	href="contact.php" > Contact </a>
            <a 	href="mentionLegales.php" > Mentions légales</a>
	        <a 	href="donneesPersonnelles.php" > Données personnelles </a>	
	        <a 	href="baseDeDonnees.php" > Base de données </a>
	</p>
	
    </body>
</html>