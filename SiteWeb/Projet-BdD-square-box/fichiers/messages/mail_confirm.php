<?php
	
	$header = "MIME-Version: 1.0\r\n";
	$header .= 'From:"The Square Box"<admin@squarebox.com>'."\n";
	$header .= 'Content-Type:text/html; charset="UTF-8"'."\n";
	$header .= 'Content-Transfer-Encoding: 8bit';

	$message = '
		<html>
			<body>
				<div align=\'center\'>
					<a href=\'localhost/Projet-BdD-square-box/index.php\'> <img src=\'http://<IP_PUBLIC>/Projet-BdD-square-box/fichiers/images/favicon2_no-process.png\' alt=\'image non trouvé\'/> </a> <br>
					<p> The Square Box </p> <br>
					<p> Bonjour, vous avez créer un compte sous le pseudo de ' . $pseudo . '. Vous devez le valider pour pouvoir insérer vos logements ! </p>
					<br>
					<p> Pour le valider, cliquez sur ce lien : </p> <a href=\'http://localhost/Projet-BdD-square-box/account_confirm.php?key=' . $mail_key . '&pseudo=' . urlencode($pseudo) . '\'> Valider mon compte !</a>
				</div>
			</body>
		</html> ';
?>