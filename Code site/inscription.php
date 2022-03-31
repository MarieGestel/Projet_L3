<?php
session_start();
require "PHPMailer/PHPMailerAutoload.php";
require('bd.php');
//$bdd = new PDO('mysql:host=localhost;dbname=bd_manel;charset=utf8', 'root', 'root');
//$bdd = getBDMarie() ;

if(isset($_POST['s\'inscrire'])){
    if(!empty($_post['nom']) && !empty($_POST['prenom']) && !empty($_POST['date']) && !empty($_POST['sexe']) && !empty($_POST['adr']) && !empty($_POST['num'])&& !empty($_POST['mail1']) && !empty($_POST['mail2']) && !empty($_POST['pass1'])&& !empty($_POST['pass2'])){
        $cle = rand(10000, 900000);
        $n=$_POST['nom'];
        $p=$_POST['prenom'];
        $date=$_POST['date'];
        $sexe=$_POST['sexe']; 
        $adr=$_POST['adr'];
        $num=$_POST['num'];
        $mail=$_POST['mail1'];
        $mail2=$_POST['mail2'];
        $mdp=md5($_POST['pass1']);
        $mdp2=md5($_POST['pass2']);
  
        $insererinscription = $bdd->prepare('INSERT INTO inscription(nom,prenom,date,sexe,adr,num,mail1,mail2,pass1,pass2, cle,confirme )VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $insererUser->execute(array($nom, $prenom, $date, $sexe, $adr,$num, $mail1, $mail2, $pass1, $pass2, $cle, 0 ));
        
        $recupinscription = $bdd->prepare('SELECT* FROM inscription WHERE nom=?');
        $recupinscription->execute(array($nom));

        if($recupinscription->rowCount() > 0){
            $inscriptionInfos = $recupinscription->fetch();
            $_session['id']=$inscriptionInfos['id']; 
        }
   function smtpmailer($to, $from, $from_name, $subject, $body) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true; 
 
        $mail->SMTPSecure = 'ssl'; 
        $mail->Host = 'smtp.gmail.Com';
        $mail->Port = 465;  
        $mail->Username = 'medicinfo2@gmail.com';
        $mail->Password = 'l3miashs';   
   
   //   $path = 'reseller.pdf';
   //   $mail->AddAttachment($path);
   
        $mail->IsHTML(true);
        $mail->From="medicinfo2@gmail.com";
        $mail->FromName=$from_name;
        $mail->Sender=$from;
        $mail->AddReplyTo($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
   }
    if(!$mail->Send()){
    $to   = $nom;
    $from = 'medicinfo2@gmail.com';
    $name = 'medic\'infos';
    $subj = 'Email de confirmation de compte';
    $msg = 'http://localhost:8888//mon_projet/projet_l3/code%20site/inscription.php/verif.php?id='.$_SESSION['id'].'&cle='.$cle  ;
    
    $error=smtpmailer($to,$from, $name ,$subj, $msg);
           
    }   
    }else{
        echo "veuiller completer tout les champs";
    }
}
?>
<!DOCTYPE html>
<html>
   <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
       <title>Medic'Info</title>
</head>


<body class='inscrire'>
    <h1> <a href='index.php'> MEDIC'INFO </a> </h1>
    <p >  <a href="connexion.php" > Je possède déjà un compte. </a> </p> 
    <div id ="inscription" > 
	<form action="NouvelleInscription.php" method="post" autocomplete="off">

    <h2> <strong> Page d'inscription  <strong>  </h2>
    <p> Nom <input type="text" name="nom" value= <?php if (isset($_POST["nom"])) { echo $_POST["nom"];} else{ echo "";}?>></p>
    <p>Prenom <input type="text" name="prenom" value=<?php if (isset($_POST["prenom"])) { echo $_POST["prenom"];} else{ echo "";}?>></p>

    <p>
        <label> Sexe : </label>
        Homme:<input type="radio" name="sexe" value="M">
        Femme:<input type="radio" name="sexe" value="F">
    </p>

    <p> Date de naissance <input type="date" name="date" value=<?php if (isset($_POST["date"])) { echo $_POST["date"];} else{ echo "";}?>> </p>
    <p> Numero <input type="tel" name="num" value=<?php if (isset($_POST["num"])) { echo $_POST["num"];} else{ echo "";}?>></p>
    <p> adresse <input type="text" name="adr" value=<?php if (isset($_POST["adr"])) { echo $_POST["adr"];} else{ echo "";}?>></p>
    <p> Email<input type="email" name="mail1" <?php if (isset($_POST["mail1"])) { echo $_POST["mail1"];} else{ echo "";}?>></p>
    <p> Confirmation email <input type="eamil" name="mail2"></p>
    <p> Mot de passe <input type="password" name="pass1"></p>
    <p> Confirmation mot de passe <input type="password" name="pass2"> </p>
    <p> <INPUT id="boutonInscription" type="submit" value="s'inscrire"> </p>
    </form>
    </div>

    <div class='liensBas'>
       <a 	href="quiSommesNous.php" > Qui sommes-nous ? </a>
       <a 	href="contact.php" > Contact </a>
       <a 	href="mentionLegales.php" > Mentions légales </a>
       <a 	href="donneesPersonnelles.php" > Données personnelles </a> 
       <a 	href="baseDeDonnees.php" > Base de données </a>
    </div>

    </body>
</html>
           