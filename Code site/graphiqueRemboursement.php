<?php

$bdd = new PDO('mysql:host=localhost;dbname=bdd_medicament;charset=utf8', 'root', 'root');

if(isset($_GET['forme'])){
	$voieAdm="";
	$forme=$_GET['forme'];
	$rep = $bdd->query('SELECT ((count(*)/(SELECT count(*) from presentation, specialite WHERE presentation.CodeCIS=specialite.CodeCIS
AND specialite.Forme_pharmaceutique="'.$forme.'"))*100) as Nombre, Taux_remboursement 
FROM presentation, specialite
WHERE presentation.CodeCIS=specialite.CodeCIS
AND specialite.Forme_pharmaceutique="'.$forme.'"
group by Taux_remboursement ORDER BY Nombre DESC');
$titre="Pourcentages des médicaments par taux de remboursement pour la forme pharmaceutique : ".$forme;
	}
	
elseif(isset($_GET['voieAdm'])){
	$forme="";
	$voieAdm=$_GET['voieAdm'];
	$rep = $bdd->query('SELECT ((count(*)/(SELECT count(*) from presentation, specialite WHERE presentation.CodeCIS=specialite.CodeCIS
AND specialite.Voie_administration="'.$voieAdm.'"))*100) as Nombre, Taux_remboursement 
FROM presentation, specialite
WHERE presentation.CodeCIS=specialite.CodeCIS
AND specialite.Voie_administration="'.$voieAdm.'"
group by Taux_remboursement ORDER BY Nombre DESC');
$titre="Pourcentages des médicaments par taux de remboursement pour la voie d'administration : ".$voieAdm;
	}


$datay=array();
$valx=array();
		while ($ligne = $rep ->fetch()){
		array_push($datay, $ligne['Nombre']);	
		array_push($valx, $ligne['Taux_remboursement']);	
		}
		$rep ->closeCursor();
		
if(count($datay)==0 || count($valx)==0){
	if($forme!=""){
	echo '<meta http-equiv="refresh" content="0; url=donneesclees.php?forme=noData">';	
	}
	else{
	echo '<meta http-equiv="refresh" content="0; url=donneesclees.php?voieAdm=noData">';	
	}
}


// content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');


// Create the graph. These two calls are always required
$graph = new Graph(800,400,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(0,25,50,75,100), array(0,10, 20, 30,40, 50,60, 70, 80,90,100));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels($valx);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b3plot = new BarPlot($datay);

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b3plot));
// ...and add it to the graPH
$graph->Add($gbplot);

$b3plot->SetColor("white");
$b3plot->SetFillColor("#5ca678");

$graph->title->Set($titre);

// Display the graph
if(file_exists('remboursement.png')){
	unlink('remboursement.png');
}
$graph->Stroke('remboursement.png');  

echo '<meta http-equiv="refresh" content="0; url=donneesclees.php?forme='.$forme.'&voieAdm='.$voieAdm.'">';


?>