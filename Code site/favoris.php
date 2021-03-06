<?php
session_start();
include('bd.php');  
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
		<title>Medic'Info</title>
	</head>
	
	<body id='BodyFavoris'>
	<nav>
    <div class="menu">
	<a 	href="deconnexion.php" > Deconnexion </a>
    <a 	href="profil.php" > Profil </a>
    </div>
    </nav>
	<h1> <a href="index.php" > MEDIC'INFO </a>  </h1>
	<?php 
	    if (isset($_SESSION['client'])){
        
       	$result = $bdd->query("select specialite.CodeCIS as CodeCIS, specialite.Denomination_medicament as Denomination_medicament, specialite.forme_pharmaceutique as forme_pharmaceutique, specialite.Voie_administration as Voie_administration from specialite,Clients,favoris Where Clients.id_client=favoris.id_client and 
        favoris.CodeCIS=specialite.CodeCIS and Clients.id_client='".$_SESSION['id_client']."'");
		//requête qui récupère les informations des médicaments mis en favoris et l'identifiant du client lorsque celui-ci est connecté
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
                while($favoris = $result->fetch()) {
                    echo "<tr>";
                    echo "<td> <a href='medicament.php?CodeCIS=".$favoris['CodeCIS'].'&nom='.$favoris['Denomination_medicament'].'&voieAdm='.$favoris['Voie_administration']."'>". $favoris['CodeCIS'].  '</td>';
                    echo "<td>" . $favoris['Denomination_medicament']. "</td>";
                    echo "<td>" . $favoris['forme_pharmaceutique']. "</td>";
                    echo "<td>" . $favoris['Voie_administration']. "</td>";
                    echo "</tr>"; 
                //tableau des favoris qui récupère dans la base de données les différentes informations des médicaments mis en favoris 
				}
                $result->closeCursor();
        }else{
            echo "Vous n'avez pas de favoris";
            echo '<meta http-equiv="refresh" content="1; url=index.php">';
			//message qui apparait lorsqu'aucun médicaments n'a été mis en favoris
        }
            
        ?>
        </table>

        <div class='liensBas'>
        <a 	href="quisommenous.php" >Qui sommes-nous ? </a>
        <a 	href="contact.php" > Contact </a>    
        <a 	href="donneesPersonnelles.php" > Données personnelles </a>        
        <a 	href="baseDeDonnees.php" > Base de données </a>
    </div>
        
    </body>
</html>