<?php
	session_start();
 	require('bd.php');
	$bdd = getBDMarie() ; 
	
	if($_GET['mail']=="" || $_GET['motdepasse']==""){
		echo '<meta http-equiv="refresh" content="0; url=connexion.php?mail='.$_GET['mail'].'"/>';
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
				$rep = $bdd->query('select * from Clients WHERE mail="'.$_GET['mail'].'" AND motdepasse="'.$_GET['motdepasse'].'"');
				
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