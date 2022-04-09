<?php
session_start();// Permet l'activation de la session du client connecté
require('bd.php'); // importe le fichier bd.php
$bdd = getBD() ; // appel la focntion getBD() 

            // Fonction permettant de modifier les informations relatifs au nom, prenom, date de naissance, adresse, numéro de téléphone du client dans la table Clients
            function modifier_information($n,$p,$date,$adr,$num,$id)
           {
               $seconnecter=getBD();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                }
                else {
                    $res="UPDATE Clients SET nom='".$n."',prenom='".$p."',date_naissance='".$date."',adresse='".$adr."',numero='".$num."'  WHERE id_client='".$id."' ";
                    $seconnecter->exec($res);
                }
            } 

    if (isset($_SESSION['client'])){ //savoir si le clien est connecté

        if(isset($_POST['nom'])){
            // Si un nom est passée en paramètre
            $n=$_POST['nom'];	
        }
        else{
            // Sinon récupération du nom associé à la session du client
            $n=$_SESSION['nom']	;
        }

        if(isset($_POST['prenom'])){
            // Si un prénom est passée en paramètre
            $p=$_POST['prenom'];	
        }
        else{
            // Sinon récupération du prenom associé à la session du client
            $p=$_SESSION['prenom']	;
        }

        if(isset($_POST['date'])){
            // Si une date est passée en paramètre
            $date=$_POST['date'];	
        }
        else{
            // Sinon récupération de la date de naissance associé à la session du client
            $date=$_SESSION['date_naissance']	;
        }

        if(isset($_POST['adresse'])){
            // Si une adresse est passée en paramètre
            $adr=$_POST['adresse'];	
        }
        else{
            // Sinon récupération de l'adresse associé à la session du client
            $adr=$_SESSION['adresse']	;
        }
        if(isset($_POST['num'])){
            // Si un numéro est passée en paramètre
            $num=$_POST['num'];	
        }
        else{
            // Sinon récupération du numéro associé à la session du client
            $num=$_SESSION['numero']	;
        }
        // Essaie de l'ajout d'une photo de profil
        //if(isset($_POST['photo'])){
        //     $photo=$_POST['photo'];	
        // }
        // else{
        //     $photo="";
        // }

        $id=$_SESSION['id_client']; //récupération de l'identifiant du client
        //utilisation de la fonction pour modifier les information à l'issue des récupérations précédentes
        modifier_information($n,$p,$date,$adr,$num,$id);
        echo '<meta http-equiv="refresh" content="0; url=profil.php"/>';

    }else{
        echo "Vous n'êtes pas connecté";
        echo '<meta http-equiv="refresh" content="1; url=index.php"/>';
    }
    ?>

    </head>

</html>
