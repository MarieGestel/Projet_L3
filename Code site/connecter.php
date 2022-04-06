<?php
	session_start(); // Permet de démarrer une session
 	require('bd.php'); // importe le fichier bd.php
	$bdd = getBD() ; // appel la focntion getBD() 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info/Connexion</title>

<?php
	/* Cette page permet la recupération des informations du client pour démarrer une session afin de le connecter */

	// récupération du mail envoyé depuis la page connexion
	if(isset($_POST['mail'])){
		$mail=$_POST['mail'];
	}else{
		$mail="";
	}

	//récupération du mot de passe envoyé depuis la page connexion 
	if(isset($_POST['motdepasse'])){
		if($_POST['motdepasse']!=""){
			$mdp=md5($_POST['motdepasse']);
		}else{
			$mdp="";
		}
	}
	
	if($mail=="" || $mdp==""){
		// redirection si champs vides
		echo '<meta http-equiv="refresh" content="1; url=connexion.php?mail='.$mail.'"/>';
		echo "mail ou mot de passe vide";
	}

	else{
		$result=0;
		//requête permettant de trouver le client associé au mail et au mot de passe entrée en paramètre
		$var=$bdd->query('select count(*) from Clients where mail="'.$mail.'" AND motdepasse="'.$mdp.'"');
		//recupération de la requête
		while ($ligne = $var ->fetch()){
			$result=$ligne[0];
		}
		$var->closeCursor();

 	 	if($result==0){
			//Si aucun client trouvé redirection 
			echo 'Nous ne trouvons pas de client correspondant à la demande veuillez vous inscrire';
			echo '<meta http-equiv="refresh" content="1 url=inscription.php"/>';
		} 

		else{
			//Sinon requete permettant de recuperer les informations du client
				$rep = $bdd->query('select * from Clients WHERE mail="'.$mail.'" AND motdepasse="'.$mdp.'"');
				
				while ($client = $rep ->fetch()){
					//Création de la session du client avec ses information
	 				$_SESSION['id_client']=$client['id_client'];
	 				$_SESSION['nom']=$client['nom'];
	 				$_SESSION['prenom']=$client['prenom'];
	 				$_SESSION['mail']=$client['mail'];
	 				$_SESSION['date_naissance']=$client['date_naissance'];
	 				$_SESSION['adresse']=$client['adresse'];
	 				$_SESSION['numero']=$client['numero'];
	 				$_SESSION['motdepasse']=$client['motdepasse'];
					if($client['sexe']==1){ $_SESSION['sexe']="F"; }else { $_SESSION['sexe']="H";}
	 				$_SESSION['client']=array($_SESSION['id_client'], $_SESSION['nom'], $_SESSION['prenom'], $_SESSION['mail'],$_SESSION['sexe'],$_SESSION['date_naissance'],$_SESSION['adresse'], $_SESSION['numero'], $_SESSION['motdepasse']);
				}
	 			$rep->closeCursor();
				//Redirection vers l'index du client connecté 
				echo '<meta http-equiv="refresh" content="0; url=index.php"/>';
				
	 		}
	} 
?>
</head>