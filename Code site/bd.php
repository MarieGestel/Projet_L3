
    <?php
            function getBDMarie(){
                $bdd = new PDO('mysql:host=localhost;dbname=BDD_medicament;charset=utf8', 'root', 'root');
                return $bdd;
            }

            $bdd = getBDMarie();
        ?>


   