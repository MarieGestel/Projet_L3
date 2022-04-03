<?php
if(isset($_GET['forme'])){
	$forme=$_GET['forme'];
}else{
	$forme="";
}
if(isset($_GET['voieAdm'])){
	$voie=$_GET['voieAdm'];
}else{
	$voie="";
}

$bdd = new PDO('mysql:host=localhost;dbname=bdd_medicament;charset=utf8', 'root', 'root');
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

$estpresent=0;
if($compter!=0){
    while ($ligne = $compter ->fetch()){
        $estpresent=$ligne[0];
    } 
}


if ($estpresent==0){ 
    echo 'Nous ne pouvons pas répondre à votre demande';
    echo '<meta http-equiv="refresh" content="2; url=donneesclees.php"/>';

}else{
    if( $voie!="" || $forme!=""){
        $recherche= 'SELECT presentation.CodeCIS as CodeCIS,presentation.Taux_remboursement as Taux from specialite,presentation where specialite.CodeCIS=presentation.CodeCIS';
        if($voie!=""){
            $recherche=$recherche." AND specialite.Voie_administration LIKE '%".$voie."%' ";
        }
        if($forme!=""){
            $recherche=$recherche." AND specialite.Forme_pharmaceutique LIKE '%".$forme."%' ";
        }
        $recherche=$recherche.' ORDER BY presentation.Taux_remboursement DESC LIMIT 7 ';	
        $rechercher= $bdd->query($recherche);
    }


    $y=array();
    $x=array();
    while ($ligne = $rechercher ->fetch()){
	    array_push($y, $ligne['Taux']);	
	    array_push($x, $ligne['CodeCIS']);	
	}

    if($y!="" && $x!=""){
	    require_once ('jpgraph/src/jpgraph.php');
	    require_once ('jpgraph/src/jpgraph_bar.php');

	// Create the graph. These two calls are always required
	$graph=new Graph(800,400,'auto');
	$graph->SetScale("textlin");

 	$theme_class=new UniversalTheme;
	$graph->SetTheme($theme_class);

	$graph->yaxis->SetTickPositions(array(20,40,60,80,100), array(20,40,60,80,100));
	$graph->SetBox(false);

	$graph->ygrid->SetFill(false);
	$graph->xaxis->SetTickLabels($x);
	$graph->yaxis->HideLine(false);
	$graph->yaxis->HideTicks(false,false); 

	// Create the bar plots
	$b3plot = new BarPlot($y);

	// Create the grouped bar plot
	$gbplot = new GroupBarPlot(array($b3plot));
	// ...and add it to the graPH
	$graph->Add($gbplot);

	$b3plot->SetColor("white");
	$b3plot->SetFillColor("#5ca678");

     if( $voie!="" || $forme!=""){
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

    //$graph->stroke();

   // Display the graph
	if(file_exists('remboursement.png')){
		unlink('remboursement.png');
	}
	$graph->Stroke('remboursement.png'); 
    echo '<meta http-equiv="refresh" content="0; url=donneesclees.php?forme='.$forme.'&voie='.$voie.'"/>'; 

}

}
?>