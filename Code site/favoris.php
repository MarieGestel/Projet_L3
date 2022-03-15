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
	
	<body id='medicament'>
	<p id="inscriptionConnexion">
	<a 	href="deconnexion.php" > Se déconnecter </a>
	<h1> <a id="contact"href="index.html" > Medic'Info </a>  </h1>
	<?php

	 //if (isset($_SESSION['client'])){
       	// $result = $bdd->query("select Denomination_medicament, forme pharmaceutique, Voie_administration from Specialite,Clients,favoris Where Clients.id_client=favoris.id_client and 
        //favoris.CodeCIS=aSpecialite.CodeCIS and Clients.id_client='".$_SESSION['id_client']."'");
		$result = $bdd->query("select specialite.CodeCIS as CodeCIS,specialite.Denomination_medicament as Denomination_medicament, specialite.forme_pharmaceutique as forme_pharmaceutique , 
		Specialite.Voie_administration as Voie_administration from specialite,Clients,favoris Where Clients.id_client=favoris.id_client and favoris.CodeCIS=specialite.CodeCIS and Clients.id_client=1");

        $favoris= $result->fetchAll();
		?>

		<p> <strong> Récapitulatif de vos favoris: </strong> </p>
        <table>
                <tr>
                    <th> CodeCIS</th>
                    <th> Denomination Médicament </th>
                    <th> Forme pharmaceutique </th>
                    <th> Voie d'administration  </th>
                </tr>  
        <?php
                foreach ($favoris as $favoris) {
                    echo "<tr>";
                    echo '<td>' . $favoris['CodeCIS']. '</td>';
                    echo "<td>" . $favoris['Denomination_medicament']. "</td>";
                    echo "<td>" . $favoris['forme_pharmaceutique']. "</td>";
                    echo "<td>" . $favoris['Voie_administration']. "</td>";
                    echo "</tr>"; 
                }
            //}
            ?>
            </table>
            <a href="index.html"> Retour </a>


    </body>
	
	
	
	
    </html>