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
		<title>Medic'Info</title>

    <?php 
            function modifier_information($n,$p,$mail,$date,$adr,$num,$prof,$all,$path,$id)
           {
               $seconnecter=getBDMarie();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                }
                else {
                    $res="UPDATE Clients SET nom='".$n."',prenom='".$p."', mail='".$mail."', date_naissance='".$date."',adresse='".$adr."',numero='".$num."',allergies='".$all."', Profession='".$prof."', Pathologies='".$path."' WHERE id_client='".$id."' ";
                    if($seconnecter->exec($res)!= false){
                        echo 'les informations du client ont été mis à jour';
                    }
                }
            } 

    if (isset($_SESSION['client'])){
        if(isset($_POST['nom'])){
            $n=$_POST['nom'];	
        }
        else{
            $n=$_SESSION['nom']	;
        }

        if(isset($_POST['prenom'])){
            $p=$_POST['prenom'];	
        }
        else{
            $p=$_SESSION['prenom']	;
        }

        if(isset($_POST['mail'])){
            $mail=$_POST['mail'];	
        }
        else{
            $mail=$_SESSION['mail']	;
        }

        if(isset($_POST['date'])){
            $date=$_POST['date'];	
        }
        else{
            $date=$_SESSION['date_naissance']	;
        }

        if(isset($_POST['adresse'])){
            $adr=$_POST['adresse'];	
        }
        else{
            $adr=$_SESSION['adresse']	;
        }
        if(isset($_POST['num'])){
            $num=$_POST['num'];	
        }
        else{
            $num=$_SESSION['numero']	;
        }
        if(isset($_POST['profession'])){
            $prof=$_POST['profession'];	
        }
        else{
            $prof="";
        }
        if(isset($_POST['pathologies'])){
            $path=$_POST['pathologies'];	
        }
        else{
            $path="";
        }
        if(isset($_POST['allergies'])){
            $all=$_POST['allergies'];	
        }
        else{
            $all="";
        }
        modifier_information($n,$p,$mail,$date,$adr,$num,$prof,$all,$path,$_SESSION['client']);

    }
    ?>

    </head>

</html>
