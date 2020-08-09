<?php

	
	if(isset($_POST['mailform']))
	{
		$mail_key = 'ceciestunekeytest';
		$pseudo = 'ceciestunpseudo';

		$header = "MIME-Version: 1.0\r\n";
		$header .= 'From:"The Square Box"<admin@squarebox.com>'."\n";
		$header .= 'Content-Type:text/html; charset="UTF-8"'."\n";
		$header .= 'Content-Transfer-Encoding: 8bit';

		$message = 'ceci est un test';
		
		include('fichiers/messages/mail_confirm.php');
		$mailsss = mail("pierro.david038@gmail.com", "Salut tout le monde !", $message, $header);
		if ($mailsss) {echo 'oui';}else{echo 'non';}
	}
?>

<form method="POST" action="">
	<input type="submit" value="Recevoir un mail !" name="mailform"/>
</form>