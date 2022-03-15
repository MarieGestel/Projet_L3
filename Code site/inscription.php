<!DOCTYPE html>
<html>
   <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <link rel="stylesheet" href="styles.css" type="text/css" media="screen" />
       <title>Medic'Info</title>
</head>

   <body >
    <h1> 	<a 	id="contact" href="index.php" > Medic'Info </a>  </h1>

    <p >  <a href="connexion.php" > Je possède déjà un compte. </a> </p>    


	<form id ="inscription" action="NouvelleInscription.php" method="get" autocomplete="off">
    <h2> <strong> Page d'inscription  <strong>  </h2>
    <p> Nom<input type="text" name="nom"></p>
    <p>Prenom <input type="text" name="prenom"></p>
    <p>
        <label>Sexe : </label>
        Homme:<input type="radio" name="sexe" value="M">
        Femme:<input type="radio" name="sexe" value="F">
    </p>
    <p> Date de naissance <input type="date" name="date"> </p>
    <p> Numero <input type="text" name="num"></p>
    <p> adresse <input type="text" name="adr"></p>
    <p> Email<input type="text" name="mail1"></p>
    <p> Confirmation email <input type="text" name="mail2"></p>
    <p> Mot de passe <input type="password" name="pass1"></p>
    <p> Confirmation mot de passe <input type="password" name="pass2"> </p>
    <p> <INPUT id="boutonInscription" type="submit" value="S'inscrire"> </p>
    </form>

    <p>
       <p id='liensBas'>
       <a 	href="quiSommesNous.php" > Qui sommes-nous ? </a>
       <a 	href="contact.php" > Contact </a>
       <a 	href="mentionLegales.php" > Mentions légales </a>
       <a 	href="donneesPersonnelles.php" > Données personnelles </a> 
       <a 	href="baseDeDonnees.php" > Base de données </a>
	</p>

    </body>
</html>
           