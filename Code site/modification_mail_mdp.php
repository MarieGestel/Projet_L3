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
        function modifier_mail($mail,$id){
            $seconnecter=getBD();
            if (!$seconnecter){
                $MessageConnexion = die (" la connection impossible");
            } else {
                $res="UPDATE Clients SET mail='".$mail."' WHERE id_client='".$id."' ";
                $seconnecter->exec($res);
            }
        } 
        function modifier_mdp($mdp,$id){
            $seconnecter=getBDMarie();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                } else {
                    $res="UPDATE Clients SET motdepasse='".$mdp."' WHERE id_client='".$id."' ";
                    $seconnecter->exec($res);
                }
        } 

        if(isset($_SESSION['client'])){
            $id=$_SESSION['id_client'];

            if($_POST['mail1']!="" || $_POST['mail2']!=""){
                $mail=$_POST['mail1'];	
                $mail2=$_POST['mail2'];	
                if($mail!=$mail2){
                    echo "vous n'avez pas bien confirmé votre adresse mail";
                    echo '<meta http-equiv="refresh" content="2; url=modifier_information.php"/>';
                }else{
                    modifier_mail($mail,$id);
                    echo '<meta http-equiv="refresh" content="0; url=profil.php"/>';
                }
            }else if($_POST['mdp1']!="" || $_POST['mdp2']!=""){
                $mdp=md5($_POST['mdp1']);	
                $mdp2=md5($_POST['mdp2']);
                if($mdp!=$mdp2){
                    echo "vous n'avez pas bien confirmé le mot de passe";
                    echo '<meta http-equiv="refresh" content="2; url=modifier_information.php"/>';
                }else{
                    modifier_mdp($mdp,$id);
                    echo '<meta http-equiv="refresh" content="0; url=profil.php"/>';
                }
            }else{
                echo '<meta http-equiv="refresh" content="0; url=modifier_information.php"/>';
            }

        }else{
            echo "Vous n'êtes pas connecté";
            echo '<meta http-equiv="refresh" content="1; url=index.php"/>';
        }
    ?>
    </head>
</html>

        