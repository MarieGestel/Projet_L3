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
               $n=$_GET['n'];
               $p=$_GET['p'];
               $mail=$_GET['mail'];
               $sujet=$_GET['sujet'];
               $comm=$_GET['commentaires'];
               if($n=="" || $p=="" || $adr=="" || $mail==""|| $sujet==""|| $comm=="") {;
        ?>
        <p> votre message a bien été envoyé, nous le traiterons au plus vite.</p>
    </body>
    </html>