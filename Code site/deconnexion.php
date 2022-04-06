<?php
// Voir si une session est trouvé
session_start();
// Si oui la supprimer pour déconnecter le client
session_destroy();
// Redirection vers un index non connecté
echo '<meta http-equiv="refresh" content="0; url=index.php"/>';
?>
