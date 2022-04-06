<?php
	session_start();
    include('bd.php');  
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type "content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />

    <?php
       function nouvelleIncription($n, $p, $adr,$num,$mail,$mdp,$sexe,$date)
       {
           $seconnecter=getBD();
            if (!$seconnecter){
                $MessageConnexion = die (" la connection impossible");
            }
            else {
                if ($sexe="F"){ 
                    $sexe=1 ;
                }else{
                    $sexe=0;
                }
                $res="INSERT INTO Clients(nom,prenom,mail,date_naissance,sexe,adresse,numero,motdepasse) VALUES ('".$n."','".$p."','".$mail."','".$date."','".$sexe."','".$adr."','".$num."','".$mdp."')";
                if($seconnecter->exec($res)!= false){
                    echo 'Un nouveau client a été ajouté à la table';
                }
            }
        }
        if(isset($_POST['nom'])){
            $n=$_POST['nom'];}
        else{
            $n="" ;
        }
        if(isset($_POST['prenom'])){
            $p=$_POST['prenom'];
        }else{
            $p="" ;
        }
        if(isset($_POST['date'])){
            $date=$_POST['date'];
        }else{
            $date="";
        }
        if(isset($_POST['sexe'])){
            $sexe=$_POST['sexe'];
        }else{
            $sexe="";
        }
        if(isset($_POST['adr'])){
            $adr=$_POST['adr'];
        }else{
            $adr="";
        }
        if(isset($_POST['num'])){
            $num=$_POST['num'];
        }else{
            $num="";
        }
        if(isset($_POST['mail1'])){
            $mail=$_POST['mail1'];
        }else{
            $mail="";
        }
        if(isset($_POST['mail2'])){
            $mail2=$_POST['mail2'];
        }else{
            $mail2="";
        }
        if(isset($_POST['pass1'])){
            if($_POST['pass1']!=""){
                $mdp=md5($_POST['pass1']);
            }else{
                $mdp="";
            }
        }
        if(isset($_POST['pass2'])){
            if($_POST['pass2']!=""){
                $mdp2=md5($_POST['pass2']);
            }else{
                $mdp2="";
            }
        }

        if($n=="" || $p=="" || $mail=="" || $date=="" || $sexe==""|| $adr==""|| $num==""||$mail==""||$mdp==""|| $mail!=$mail2|| $mdp!= $mdp2) {
            echo '<meta http-equiv="refresh" content="1; url=inscription.php?nom='.$n.'&prenom='.$p.'&adr='.$adr.'&num='.$num.'&mail='.$mail.'"/>';
            echo "Il faut remplir tous les champs";
        } else{
            $client = $bdd->query("select count(*) from Clients where mail='".$mail."' and motdepasse='".$mdp."'");
            $estPresent=0;
            while ($ligne = $client ->fetch()){
                $estPresent=$ligne[0];
            }
            $client ->closeCursor();
            if($estPresent==0){
                nouvelleIncription($n, $p, $adr,$num,$mail,$mdp,$sexe,$date);

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
            }else{
                echo 'Cet utilisateur est déjà enregistré, veuillez vous connecter : .';
                echo '<meta http-equiv="refresh" content="2; url=connexion.php">';
            }
        }
    ?>
    </head>
</html>