<?php
	session_start();
 	require('bd.php');
	$bdd = getBD() ; 
?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info</title>

    <?php 
            function modifier_information($n,$p,$date,$adr,$num,$id)
           {
               $seconnecter=getBDMarie();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                }
                else {
                    $res="UPDATE Clients SET nom='".$n."',prenom='".$p."',date_naissance='".$date."',adresse='".$adr."',numero='".$num."'  WHERE id_client='".$id."' ";
                    $seconnecter->exec($res);
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
        // if(isset($_POST['photo'])){
        //     $photo=$_POST['photo'];	
        // }
        // else{
        //     $photo="";
        // }

        $id=$_SESSION['id_client'];

        modifier_information($n,$p,$date,$adr,$num,$id);
        echo '<meta http-equiv="refresh" content="0; url=profil.php"/>';

    }else{
        echo "Vous n'êtes pas connecté";
        echo '<meta http-equiv="refresh" content="1; url=index.php"/>';
    }
    ?>

    </head>

</html>
