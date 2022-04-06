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
        // Permet d'ajouter sur notre base de donnée dans la table favoris le CodeCIS et l'id du client afin de faire le lien entre les 2
            function ajouterfavoris($CodeCIS, $id_client) {
                $seconnecter=getBD();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                } else {
                    $res="INSERT INTO favoris(CodeCIS,id_client) VALUES ('".$CodeCIS."','".$id_client."')";
                    $seconnecter->exec($res);     
                }
            }
        
	        if (isset($_SESSION['client'])){// On regarde si la session du client existe 
                $tableau=array(); // Création d'un tableau pour stocker les codeCIS déja existant

                // On si le CodeCIS et le client sont déja associés.
                $result = $bdd->query("select CodeCIS from favoris Where favoris.id_client='".$_SESSION['id_client']."'");

                //ajout des codeCIS récuoérer dans la tablea favoris au tableau
                while($favoris = $result->fetch()) {
                    array_push($tableau,$favoris['CodeCIS']);
                }
                $result->closeCursor();

                $j=0;
                $codeCIS=$_POST['codeCIS'];
                // on regarde si le codeCIS envoyé se trouve dans le tableau, si c'est le cas on ajout +1 à la variable j
                for($i=0; $i<count($tableau); $i++){
                    if($tableau[$i]!=$codeCIS){
                        $j+=1;
                    }
                } 
                // Si j==0 cela signifie que le CodeCIS n'existe pas et que l'on peut ajouter le Client avec le CodeCIS à notre table favoris
                if($j==count($tableau)){
                    ajouterfavoris($codeCIS, $_SESSION['id_client']);
                }
                // Sinon une redirection se fait vers favoris sans ajouter le medicament à la table favoris 
                echo '<meta http-equiv="refresh" content="0; url=favoris.php">';

            } else{ 
                //Le client n'est pas connecté une redirection est donc effectué
                echo "Vous n'êtes pas connecté.";
                echo '<meta http-equiv="refresh" content="1; url=index.php">';
            }
        ?>
	</head>
</html>