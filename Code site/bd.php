
    <?php
    // Permet de faire la connexion entre notre base de données et nos fichiers PHP 
            function getBD(){
                $bdd = new PDO('mysql:host=localhost;dbname=BDD_medicament;charset=utf8', 'root', 'root');
                return $bdd;
            }
    // recupère la fonction getBD() pour l'utiliser dans nos autres pages php
            $bdd = getBD();
        ?>


   