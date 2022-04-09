<!DOCTYPE html>
<html>
	<head>
        <?php
            include('bd.php');  // importe le fichier bd.php
            // Fonction permettant de mettre dans la table commentaires de notre base de données les informations envoyées depuis la page contact 
            function enregistrer($n, $p,$mail,$sujet,$comm){
                $seconnecter=getBD();
                if (!$seconnecter){
                    $MessageConnexion = die (" la connection impossible");
                } else {
                    $res="INSERT INTO commentaires(nom,prenom,mail,sujet,commentaire) VALUES ('".$n."','".$p."','".$mail."','".$sujet."','".$comm."')";
                    $seconnecter->exec($res);
                }
            }
             // Récupération du nom
            if(isset($_POST['n'])){
                $n=$_POST['n'];
            }else{
                $n="";
            }
             // Récupération du prénom 
            if(isset($_POST['p'])){
                $p=$_POST['p'];
            }else{
                $p="";
            }

            // Récupération du mail
            if(isset($_POST['mail'])){
                $mail=$_POST['mail'];
            }else{
                $mail="";
            }
             // Récupération du sujet
            if(isset($_POST['sujet'])){
                $sujet=$_POST['sujet'];
            }else{
                $sujet="";
            }
             // Récupération du commentaore
            if(isset($_POST['commentaires'])){
                $comm=$_POST['commentaires'];
            }else{
                $comm="";
            }

            if($n=="" || $p==""|| $mail==""|| $sujet==""|| $comm=="") {  
                //redirection si toutes les informatiosnn'ont pas été saisi
                echo '<meta http-equiv="refresh" content="O; url=contact.php?nom='.$n.'&mail='.$mail.'"/>';    
            } else{
                 // Sinon utilisation de la fonction afin d'enregistrer les informations dans la BDD
                enregistrer($n, $p,$mail,$sujet,$comm);
                echo '<p> Votre message a bien été envoyé, nous le traiterons au plus vite.</p>';
                echo '<meta http-equiv="refresh" content="1; url=index.php"/>';    
            }
        ?>
    </head>
</html>