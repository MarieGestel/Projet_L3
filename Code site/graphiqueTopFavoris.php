<?php
//Connexion à la base de données 
$bdd = new PDO('mysql:host=localhost;dbname=bdd_medicament;charset=utf8', 'root', 'root');

// Requête permettant de savoir les codesCIS les plus mis en favoris dans l'ordre décroissant et limité à 5
$rep = $bdd->query('SELECT CodeCIS, count(*) as occurence FROM `favoris` GROUP BY CodeCIS ORDER BY occurence DESC LIMIT 5 ');

$datay=array(); // tableau utilisé pour stocker les occurences d'un CodeCIS mis en favoris
$valx=array();// tableau utilisé pour stocker les CodeCIS les plus mis en favoris
		while ($ligne = $rep ->fetch()){
		array_push($datay, $ligne['occurence']);	
		array_push($valx, $ligne['CodeCIS']);	
		}
		$rep ->closeCursor();
		
 // content="text/plain; charset=utf-8"
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');

//$data3y=array(87,86,88,155);

// Create the graph. These two calls are always required
$graph=new Graph(800,400,'auto');
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(1,2,3,4,5), array(1,2,3,4,5));
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

$graph->title->Set("Top 5 des médicaments les plus mis en favoris");

// Display the graph
if(file_exists('favoris.png')){
	unlink('favoris.png');
}
$graph->Stroke('favoris.png');   

?>