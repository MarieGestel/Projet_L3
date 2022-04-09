<?php
// récupération des données envoyées depuis grapphiqueTop10_remboursement
if(isset($_GET['forme'])){
	$forme=$_GET['forme'];
}else{
	$forme="";
}
if(isset($_GET['voie'])){
	$voie=$_GET['voie'];
}else{
	$voie="";
}

//Connexion à la base de données 
$bdd = new PDO('mysql:host=localhost;dbname=bdd_medicament;charset=utf8', 'root', 'root');

// Rêquete pemettant de voir le CodeCIS existe dans la jointure faites ci-dessous 
$compte=0;
$compter=0;
if( $voie!="" || $forme!=""){
    $compte='SELECT count(presentation.CodeCIS) as CodeCIS from specialite,presentation where specialite.CodeCIS=presentation.CodeCIS';
    if($voie!=""){
        $compte=$compte." AND specialite.Voie_administration LIKE '%".$voie."%' ";
    }
    if($forme!=""){
        $compte=$compte." AND specialite.Forme_pharmaceutique LIKE '%".$forme."%' ";
    }
   $compter=$bdd->query($compte);	
}
// récupération des informations de la requêtes
$estpresent=0;
if($compter!=0){
    while ($ligne = $compter ->fetch()){
        $estpresent=$ligne[0];
    } 
} 


if ($estpresent==0){ 
    // Aucun médicament ne correspond à la demande, permet de renvoyer via l'url les variables correspondant à cette demande 
    $voie="noData" ;
    $forme="noData";
    echo '<meta http-equiv="refresh" content="0; url=graphiqueTop10_remboursement.php?forme='.$forme.'&voie='.$voie.'"/>'; 

}else{
    // Requête permettant de récupérer le taux de remboursment en odre décroissant afin d'avoir les 10 meilleurs au maximum
    if( $voie!="" || $forme!=""){
        $recherche= 'SELECT presentation.CodeCIS as CodeCIS,presentation.Taux_remboursement as Taux from specialite,presentation where specialite.CodeCIS=presentation.CodeCIS';
        if($voie!=""){
            $recherche=$recherche." AND specialite.Voie_administration LIKE '%".$voie."%' ";
        }
        if($forme!=""){
            $recherche=$recherche." AND specialite.Forme_pharmaceutique LIKE '%".$forme."%' ";
        }
        $recherche=$recherche.' ORDER BY presentation.Taux_remboursement DESC LIMIT 10 ';	
        $rechercher= $bdd->query($recherche);
    }


    $y=array(); // tableau utilisé pour stocker les taux
    $x=array(); // tableau utiliser pour stocker les codesCIS
    // récupération des informations de la requête précédente
    while ($ligne = $rechercher ->fetch()){
	    array_push($y, $ligne['Taux']);	 // insertion des données dans le tableau y
	    array_push($x, $ligne['CodeCIS']);	// insertion des données dans le tableau x
	}

    if($y!="" && $x!=""){
	    require_once ('jpgraph/src/jpgraph.php');
	    require_once ('jpgraph/src/jpgraph_bar.php');

	// Creation tdu graphique 
	$graph=new Graph(800,400,'auto');
	$graph->SetScale("textlin");

 	$theme_class=new UniversalTheme;
	$graph->SetTheme($theme_class);

	$graph->yaxis->SetTickPositions(array(0,10, 20, 30,40, 50,60, 70, 80,90,100), array(0,10, 20, 30,40, 50,60, 70, 80,90,100));
	$graph->SetBox(false);

	$graph->ygrid->SetFill(false);
	$graph->xaxis->SetTickLabels($x);
	$graph->yaxis->HideLine(false);
	$graph->yaxis->HideTicks(false,false); 

	// Création des bar plots
	$b3plot = new BarPlot($y);

	// Create du groupement des bar plot 
	$gbplot = new GroupBarPlot(array($b3plot));
	// ...insertion dans le graphe 
	$graph->Add($gbplot);

	$b3plot->SetColor("white"); //couleur de fond
	$b3plot->SetFillColor("#5ca678"); //couleur des bar plot 

     if( $voie!="" || $forme!=""){
         //création du titre 
        $titre="Top 10 du taux de remboursement selon";
        if( $voie!="" && $forme!=""){
            $titre=$titre." la voie : ".$voie." et la forme : ".$forme ;
        }else if($voie!="" && $forme=="" ){
            $titre=$titre." la voie : ".$voie ;
        }else{
            $titre=$titre." la forme : ".$forme; 
        }
    }
    $graph->title->Set($titre); 
    
    // Titre pour l'axe horizontal(axe x) et vertical (axe y)
    $graph->xaxis->title->Set("CodeCIS");
    $graph->yaxis->title->Set("Taux de remboursement");
    $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

    //$graph->stroke();

   // Display the graph
	if(file_exists('remboursement_top10.png')){
		unlink('remboursement_top10.png');
	}
	$graph->Stroke('remboursement_top10.png'); 
    echo '<meta http-equiv="refresh" content="0; url=graphiqueTop10_remboursement.php?forme='.$forme.'&voie='.$voie.'"/>'; 

}

}
?>