<?php
session_start();// Permet l'activation de la session du client connecté
require('bd.php'); // importe le fichier bd.php
$bdd = getBD() ; // appel la focntion getBD() 

            // Fonction permettant de modifier ou ajoter les informations relatifs aux pathologies, allergies et profession du client dans la table Clients
            function modifier_information($prof,$all,$path,$id) {
               $seconnecter=getBD();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                }
                else {
                    $res="UPDATE Clients SET allergies='".$all."', Profession='".$prof."', Pathologies='".$path."' WHERE id_client='".$id."' ";
                    $seconnecter->exec($res);
                }
            } 

            if(isset($_SESSION['id_client'])){ //savoir si le clien est connecté
            // Récupération pour récupérer les informations du client             
                $client = $bdd->query("select * from Clients where id_client='".$_SESSION['id_client']."'");
                $mat = $client ->fetch(); 

                if(isset($_POST['profession'])){
                    // Si une profession est passée en paramètre
                    $prof=$_POST['profession'];	
                } else{
                    // Sinon récupération de la profession depuis la bd
                    $prof=$mat['Profession'];
                }

                if(isset($_POST['pathologies'])){
                    // Si une pathologie est passée en paramètre
                    $path=$_POST['pathologies'];	
                } else{
                    // Sinon récupération des pathologies depuis la bd
                    $path=$mat['Pathologies'];
                }

                if(isset($_POST['allergies'])){
                    // Si des allergies sont passée en paramètre
                    $all=$_POST['allergies'];	
                } else{
                    // Sinon récupération des allergies depuis la bd
                    $all=$mat['allergies'];
                }

                $id=$_SESSION['id_client']; // récupération de l'identifiant du client
                //utilisation de la fonction pour modifier les information à l'issue des récupérations précédentes
                modifier_information($prof,$all,$path,$id);
                echo '<meta http-equiv="refresh" content="0; url=profil.php"/>';
            }else{
                echo "Vous n'êtes pas connecté";
                echo '<meta http-equiv="refresh" content="1; url=index.php"/>';
            }
        ?>
    </head>
</html>