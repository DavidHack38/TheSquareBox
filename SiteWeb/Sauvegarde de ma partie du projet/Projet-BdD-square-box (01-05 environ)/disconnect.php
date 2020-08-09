<?php
session_start();

	//$_SESSION = array(); Alternative chelou à "session_unset" (Par Prim_FX)
	session_unset(); // Détruit toutes les variables de la table $_SESSION
	$_COOKIE = array(); // Détruit toutes les variables Cookie relatives au site
	session_destroy(); // Détruit la session en elle-même
	echo '<br><br><br><br><br>';
	echo '<p style="text-align: center;"> <font color="red" size="4">' . 'Vous êtes déconnecté ! Merci de votre visite.'. '<br><br>' . ' Vous allez être redirigé dans quelques secondes' . '</font> </p>';
	header("Refresh: 1;URL = index.php");
?>