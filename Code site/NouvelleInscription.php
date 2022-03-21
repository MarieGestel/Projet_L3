<?php
include('bd.php');  
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type "content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
        <?php
        $n=$_GET['nom'];
        $p=$_GET['prenom'];
        $mail=$_GET['mail1'];
        $date=$_GET['date'];
        $sexe=$_GET['sexe'];
        $adr=$_GET['adr'];
        $num=$_GET['num'];
        $mdp=$_GET['pass1'];

       function nouvelleIncription($n, $p, $adr,$num,$mail,$mdp,$sexe,$date)
       {
           $seconnecter=getBDMarie();
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

        if($n=="" || $p=="" || $mail=="" || $date=="" || $sexe==""|| $adr==""|| $num==""|| $mail!=$_GET['mail2']|| $mdp!= $_GET['pass2']) {;
            ?>
            <meta http-equiv="refresh" content="0; url=inscription.html">
            <?php
            } else{
                nouvelleIncription($n, $p, $adr,$num,$mail,$mdp,$sexe,$date);
            ?>
            <meta http-equiv="refresh" content="0; url=index.html">
             <?php
            }
            ?>
    </head>
</html>