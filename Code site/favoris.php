<?php
session_start();
include('bd.php');  
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type"
		content="text/html; charset=UTF-8" />
		
		<link rel="stylesheet" href="styles.css"
		type="text/css" media="screen" />
		
		<title>Medic'Info</title>
	</head>
	
	<body >
	<p id="inscriptionConnexion">
	<a 	href="deconnexion.php" > Se déconnecter </a>
	<h1> <a id="contact"href="index.php" > Medic'Info </a>  </h1>
	<?php

	 if (isset($_SESSION['client'])){
       	$result = $bdd->query("select specialite.CodeCIS as CodeCIS, specialite.Denomination_medicament as Denomination_medicament, specialite.forme_pharmaceutique as forme_pharmaceutique, specialite.Voie_administration as Voie_administration from specialite,Clients,favoris Where Clients.id_client=favoris.id_client and 
        favoris.CodeCIS=specialite.CodeCIS and Clients.id_client='".$_SESSION['id_client']."'");
        $favoris= $result->fetchAll();
        print_r ($_SESSION['id_client']);
		?>

		<h2> <strong> Récapitulatif de vos favoris: </strong> </h2>
        <table id="favoris">
                <tr>
                    <th> CodeCIS</th>
                    <th> Denomination Médicament </th>
                    <th> Forme pharmaceutique </th>
                    <th> Voie d'administration  </th>
                </tr>  
        <?php
                foreach ($favoris as $favoris) {
                    echo "<tr>";
                    echo "<td> <a href='medicament.php?CodeCIS=".$favoris['CodeCIS'].'&nom='.$favoris['Denomination_medicament'].'&voieAdm='.$favoris['Voie_administration']."'>". $favoris['CodeCIS'].  '</td>';
                    echo "<td>" . $favoris['Denomination_medicament']. "</td>";
                    echo "<td>" . $favoris['forme_pharmaceutique']. "</td>";
                    echo "<td>" . $favoris['Voie_administration']. "</td>";
                    echo "</tr>"; 
                }
        }else{
            echo "Vous n'avez pas de favoris";
        }
            
            ?>
            </table>


    </body>
	
	
	
	
    </html>