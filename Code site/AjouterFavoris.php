<?php
session_start();
include('bd.php');  
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type "content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info</title>

        <?php
            function ajouterfavoris($CodeCIS, $id_client) {
                $seconnecter=getBDMarie();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                }
                else {
                    $res="INSERT INTO favoris(CodeCIS,id_client) VALUES ('".$CodeCIS."','".$id_client."')";
                    if($seconnecter->exec($res)!= false){
                        echo 'La table favoris a été mise à jour.'.'<br/>';
                    }
                
                }
            }
           
            //$id_client=$_SESSION['id_client'];
            //ajouterfavoris($_POST["CodeCIS"], $id_client);
            ajouterfavoris(12,10);
        ?>

        <meta http-equiv="refresh" content="0; url=../index.php">
	</head>
    </html>