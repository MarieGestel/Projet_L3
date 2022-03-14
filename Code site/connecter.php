<?php
 require('bd.php');
	$bdd = getBD() ; 

	if($_POST['mail']=="" || $_POST['motdepasse']==""){
		echo '<meta http-equiv="refresh" content="0; url=connexion.php?mail='.$_POST["mail"].'"/>';
	}

	else{
	
		$var=$bdd->query('select count(*) from clients where mail="'.$_POST['mail'].'" AND motdepasse="'.$_POST['motdepasse'].'"');
		
		$result=0;
		while ($ligne = $var ->fetch()){
		$result=$ligne[0];
		}
		$var->closeCursor();
		
		if($result==0){
			echo '<meta http-equiv="refresh" content="0; url=connexion.php"/>';
		}

		else{
				$rep = $bdd->query('select * from clients WHERE mail="'.$_POST['mail'].'" AND motdepasse="'.$_POST['motdepasse'].'"');
				while ($ligne = $rep ->fetch()){
					session_start();
					$_SESSION['clients']=array($ligne['id_clients'], $ligne['nom'], $ligne['prenom'], $ligne['mail'], $ligne['sexe'],$ligne['adresse'], $ligne['numero'], $ligne['motdepasse']);
				}
				$rep->closeCursor();
				echo '<meta http-equiv="refresh" content="0; url=index.html"/>';
				
			}
	}
?>