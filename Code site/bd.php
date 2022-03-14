<?php
            function getBD(){
                $bdd = new PDO('mysql:host=localhost:8889;dbname=BDD_medicament;charset=utf8', 'root', 'root');
                return $bdd;
            }

            $bdd = getBD();

            
        ?>