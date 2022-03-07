<!DOCTYPE html>
<html >
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" media="screen" /> 
        <title> Ma base de donnée </title>
    </head>

    <body>
        <?php
            function getBDMarie(){
                $bdd = new PDO('mysql:host=localhost:8889;dbname=BDD_medicament;charset=utf8', 'root', 'root');
                return $bdd;
            }

            $bdd = getBDMarie();

            
        ?>
    </body>
</html>