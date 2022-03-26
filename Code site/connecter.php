<?php
	session_start();
 	require('bd.php');
	$bdd = getBDMarie() ;
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info/Connexion</title>

<?php	
	$mail=$_POST['mail'];
	$mdp=md5($_POST['motdepasse']);
	
	if($mail=="" || $mdp==""){
		echo '<meta http-equiv="refresh" content="1; url=connexion.php?mail='.$mail.'"/>';
		echo "mail ou mot de passe vide";
	}

	else{
		$result=0;
		$var=$bdd->query('select count(*) from Clients where mail="'.$_GET['mail'].'" AND motdepasse="'.$_GET['motdepasse'].'"');
		while ($ligne = $var ->fetch()){
			$result=$ligne[0];
		}
		$var->closeCursor();
		
 	 	if($result==0){
			echo '<meta http-equiv="refresh" content="0; url=connexion.php"/>';
		} 

		else{
				$rep = $bdd->query('select * from Clients WHERE mail="'.$mail.'" AND motdepasse="'.$mdp.'"');
				
				while ($client = $rep ->fetch()){
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
				echo '<meta http-equiv="refresh" content="0; url=index.php"/>';
				
	 		}
	} 
?>
</head>