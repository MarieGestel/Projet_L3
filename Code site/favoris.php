<?php
session_start();
include('bd.php');  
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
	
	<body id='medicament'>
	<p id="inscriptionConnexion">
	<a 	href="deconnexion.html" > Se déconnecter </a>
	<h1> <a id="contact"href="index.html" > Medic'Info </a>  </h1>

	<?php

	 if (isset($_SESSION['client'])){
        
        $result = $bdd->query("select id_commandes, Commandes.id_art, articles.nom as nom_article, articles.prix,
        Commandes.quantite,envoi from Commandes,Clients,articles Where Clients.id_client=Commandes.id_client and 
        Commandes.id_art=articles.id_art and Commandes.id_client='".$_SESSION['id_client']."'");

        $commande = $result->fetchAll();
	 ?>

    </body>
	
	
	
	
    </html>