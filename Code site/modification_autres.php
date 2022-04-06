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
            function modifier_information($prof,$all,$path,$id) {
               $seconnecter=getBD();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                }
                else {
                    $res="UPDATE Clients SET allergies='".$all."', Profession='".$prof."', Pathologies='".$path."' WHERE id_client='".$id."' ";
                    $seconnecter->exec($res);
                }
            } 

            if(isset($_SESSION['id_client'])){
                $client = $bdd->query("select * from Clients where id_client='".$_SESSION['id_client']."'");
                $mat = $client ->fetch(); 

                if(isset($_POST['profession'])){
                    $prof=$_POST['profession'];	
                } else{
                    $prof=$mat['Profession'];
                }

                if(isset($_POST['pathologies'])){
                    $path=$_POST['pathologies'];	
                } else{
                    $path=$mat['Pathologies'];
                }

                if(isset($_POST['allergies'])){
                    $all=$_POST['allergies'];	
                } else{
                    $all=$mat['allergies'];
                }

                $id=$_SESSION['id_client'];
                modifier_information($prof,$all,$path,$id);
                echo '<meta http-equiv="refresh" content="0; url=profil.php"/>';
            }else{
                echo "Vous n'êtes pas connecté";
                echo '<meta http-equiv="refresh" content="1; url=index.php"/>';
            }
        ?>
    </head>
</html>