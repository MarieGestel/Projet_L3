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
	    if (isset($_SESSION['client'])){
            $tableau=array();
            $result = $bdd->query("select CodeCIS from favoris Where favoris.id_client='".$_SESSION['id_client']."'");
            
            while($favoris = $result->fetch()) {
                array_push($tableau,$favoris['CodeCIS']);
            }
            $result->closeCursor();

            $j=0;
            $codeCIS=$_POST['codeCIS'];

            for($i=0; $i<count($tableau); $i++){
                if($tableau[$i]!=$codeCIS){
                    $j+=1;
                }
            } 

            if($j==count($tableau)){
                ajouterfavoris($codeCIS, $_SESSION['id_client']);
            }
        }
        ?>
        <meta http-equiv="refresh" content="0; url=favoris.php">

	</head>
    </html>