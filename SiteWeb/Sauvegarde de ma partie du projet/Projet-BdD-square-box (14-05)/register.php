<?php
	session_start();
	
	include('fonction.php');

	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options); // Connex à la BdD par PDO

	/*
	$req_user = $bdd -> prepare('SELECT * FROM membres WHERE id_user = ? ');
	$req_user -> execute(array($_SESSION['id_user']));
	$user_info = $req_user-> Fetch();
	*/

	Try
	{

		if (isset($_SESSION['id_user'])) // fais le test pour renvoyer vers le bon profil (dans le html ligne 111)
		{
			$profil_php = 'profil.php?id_user=' . $_SESSION['id_user'];
		}
		else
		{
			$profil_php = 'profil.php';
		}

//________________________________________________________________________________________________________________________________________________________________
	
		if (isset($_POST['form_inscription'])) // Vérifie que le bouton "Je m'inscris" a été cliqué
		{
			$pseudo = htmlspecialchars(trim($_POST['pseudo'])); // Enlève les caractères HTML pour éviter les injections + trim($var) pour enlever les espaces
			$mail = htmlspecialchars(trim($_POST['mail']));
			$mail2 = htmlspecialchars(trim($_POST['mail2']));
			$motdepasse = sha1(trim($_POST['motdepasse'])); // sha1 --> méthode de hashage (comme le md5 mais en mieux)
			$mdp2 = sha1(trim($_POST['mdp2'])); // Sachant que le sha1 et md5 sont mauvais pour les motdepasse !!(voir php.net)
			$PIN = htmlspecialchars(trim($_POST['PIN']));
			$date = htmlspecialchars(trim(date('d/m/Y')));
			$heure = htmlspecialchars(trim(date('H:i:s')));

			require('fichiers/ReCaptcha/autoload.php'); //chargement du  chargement automatique du Captcha
			$recaptcha = new \ReCaptcha\ReCaptcha('6LctZxgUAAAAAPDKNIRwsvjXqETTavxWZdOhSIwl');
			$resp = $recaptcha-> verify($_POST['g-recaptcha-response']);

//-- les vérifications ---------------------------------------------------------------------------------------------------------------------------------------------------------------------

			
			if (!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['motdepasse']) AND !empty($_POST['mdp2'])) // Vérifie que tous les champs sont remplis
			{
				if (strlen($PIN) == 4)
				{
					if (strlen($pseudo) <= 255) // Si la longueur du pseudo est < ou = à 255 bits
					{
						if ($mail == $mail2) // Si la vérification du mail est bonne
						{
							if (filter_var($mail, FILTER_VALIDATE_EMAIL)) // Si l'@ mail est de bonne forme (blabla@exemple.com)
							{
								$req_mail = $bdd->prepare('SELECT * FROM membres WHERE mail = ? '); // Prépare la requête pour les mails
								$req_mail->execute(array($mail)); // exécute la requête et les place dans un tableau
								$mail_exist = $req_mail-> rowcount(); // Compte le nombre de mail identique
								if ($mail_exist == 0) //Si aucun mail n'existe déjà
								{
									$req_pseudo = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ? '); // Même chose que pour les mails
									$req_pseudo->execute(array($pseudo)); // même chose que pour les mails
									$pseudo_exist = $req_pseudo->rowcount(); // même chose que pour les mails
									if ($pseudo_exist == 0) // même chose que pour les mails
									{
										if ($motdepasse == $mdp2) // Si la vérification du mot de passe correspond
										{
											if ($resp-> isSuccess())
											{
												$key = '';
												$chaine = 'abcdefghijklmnopqrstuvwxyz0123456789';
												$lgt_chaine = strlen($chaine);
												//boucle for : le 16 représente la longueur de la chaine $key
												for ($i=1; $i < 16 ; ++$i) 
												{
													global $key;
													$key .= $chaine[mt_rand()%$lgt_chaine];
												}

												$mail_key = str_shuffle($key); //str_shuffle sert à mélanger les caractères d'une chaine

												include('fichiers/messages/mail_confirm.php');
												$mailsss = mail('pierro.david038@gmail.com', 'Valider votre compte !', $message, $header);
												if ($mailsss) {echo 'oui ça marche';}else{echo 'non marche pas';}

												$insert_mbr = $bdd-> prepare('INSERT INTO membres (pseudo, mail, motdepasse, PIN, avatar, date, heure, mail_key, confirm_by_mail, admin) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'); // Prépare la requête pour inserer le membres dans la BdD
												$insert_mbr-> execute(array($pseudo, $mail, $motdepasse, $PIN, 'default_profil.png', $date, $heure, $mail_key, 'FALSE', 'FALSE')); // Crée un tableau et exécute la requête
												$erreur = 'Votre compte a bien été créé ! Connectez-vous !' ;
												//header('Refresh: 1; URL = register.php');
												
//- les erreurs ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
											}
											else 
											{
											    $errors = $resp-> getErrorCodes();
											    var_dump($errors);

											    if (isset($errors))
												{
												    if ($errors['0'] == 'missing-input-response')
												    {	
												    	$erreur = 'Vous n\'avez pas validé le Captcha';
												    }
												    else
												    {
												    	$erreur = 'Erreur inconnu avec le Captcha, veuillez réessayer. <br> <br> Si cela ne marche toujours pas, contacter l\'administrateur';
												    }
												}
											}
										}
										else
										{
											$erreur = 'Votre mot de passe ne correspond pas à la vérification !';
										}
									}
									else
									{
										$erreur = 'Ce pseudo est déjà utilisé!';
									}
								}
								else
								{
									$erreur = 'Cette adresse mail est déjà utilisée !';
								}
							}
							else
							{
								$erreur = 'Votre adresse mail n\'est pas valide !';					
							}	
						}
						else 
						{
							$erreur = 'Votre mail ne correspond pas à la vérification !';
						}	
					}
					else
					{
						$erreur = 'Votre pseudo ne doit pas excéder 255 caractères !';
					}
				}
				else
				{
					$erreur = 'Votre PIN doit faire 4 chiffres !';
				}
			}
			else
			{
				$erreur = 'Tous les champs doivent être complétés !';
			}
		}		
?>

<!DOCTYPE html>

<html>
	<head>
		<?php
			head(); // fonction qui regroupe tout le head
		?>

		<meta charset='utf-8'>
		<title> Créez-vous un compte ! </title>
		<script src='https://www.google.com/recaptcha/api.js'> </script>

	</head>
	<body>

			<div class='moncadre'>

				<p id='title'> Bienvenue sur le site du projet "The Square Box" </p>
				
				<a href='index.php'> <img class='zoom' src='fichiers/images/favicon2_no-process.png'/> </a>
					
					<nav id='navigation'>
					
						<li> <a href='index.php'> Accueil </a> </li>
						<li> <a id='active' href='register.php'> Inscription au site </a> </li>
						<li> <a href='login.php'> Connexion </a> </li>
						<li> <a href="<?php echo $profil_php ?>"> Profil </a> </li>
						<li> <a href='admin.php'> Panel Admin (pas secure) </a> </li>
						<li> <a href='android.php'> Android.php </a> </li>
						
					</nav>
					
			</div>

			<br><br><br><br><br><br><br><br><br><br><bR>

			<div id='superglobal'>
			<div id='global'>

			<div align='center'>

				<font size='4em'> Déjà inscrit ? <a class='link' href='login.php'> Me connecter ! </a> </font>

				<h2 class='explic'> Inscrivez - Vous ! </h2>
				<form method='POST' action='' enctype='multipart/form-data'>
					
					<table>
						<tr>
							<td align='right'>
								<label for='serial_key'> Entrer la clé de série <br> (obtenu par l'entreprise "The Square Box") </label>
							</td>
							<td>
								<input type='text' name='serial_key' id='serial_key' value="<?php if (isset($serial_key)) { echo  $serial_key; } ?>" placeholder='La clé de série' autofocus>
							</td>
						</tr>
						<tr>
							<td align='right'>
								<label for='pseudo'> Pseudo : </label>
							</td>
							<td>
								<input type='text' name='pseudo' id='pseudo' value="<?php if (isset($pseudo)) { echo  $pseudo; } ?>" placeholder='Votre pseudo' autofocus>
							</td>
						</tr>
						<tr>
							<td align='right'>
								<label for='mail'> Adresse mail : </label>
							</td>
							<td>
								<input type='email' name='mail' id='mail' value="<?php if (isset($mail)) { echo  $mail; } ?>" placeholder='Votre mail'>
							</td>
						</tr>
						<tr>
							<td align='right'>
								<label for='mail2'> Confirmation de votre adresse mail : </label>
							</td >
							<td>
								<input type='email' name='mail2' id='mail2' value="<?php if (isset($mail2)) { echo  $mail2; } ?>" placeholder='Votre mail'>
							</td>
						</tr>
						<tr>
							<td align='right'>
								<label for='motdepasse'> Mot de passe : </label>
							</td>
							<td>
								<input type='password' name='motdepasse' id='motdepasse' placeholder='Votre mot de passe'>
							</td>
						</tr>
						<tr>
							<td align='right'>
								<label for='mdp2'> Confirmation de votre mot de passe : </label>
							</td>
							<td>
								<input type='password' name='mdp2' id='mdp2' placeholder='Votre mot de passe'>
							</td>
						</tr>
						<tr>
							<td align='right'>
								<label for='PIN'> Entrer un mot de passe à 4 chiffres pour le boitier : </label>
							</td>
							<td>
								<input type='number' name='PIN' id='PIN' value='<?php if (isset($PIN)) { echo $PIN; } ?>' placeholder='Votre PIN'>
							</td>
						</tr>
						
					</table> <br>

					<div align='center' class='g-recaptcha' data-sitekey='6LctZxgUAAAAADaot9-cPm8nJnpmsMqHP_BMSz_9'> </div> 
					<br>
					<input type='submit' class='btn' value="Je m'inscris !" name='form_inscription'> <br> <br>
				</form>
<?php
		if (isset($erreur) AND !empty($erreur)) // Vérifie qu'il y a une erreur
		{
			echo '<p class=\'important\'>' . $erreur . '</p> <br> <br>';
		}

	} //fin du try

	//Traitement et affichage des erreur MYSQL
	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error-> getMessage());
	}
?>
			</div> <!-- fin div form -->
		</div> <!-- fin div global-->

		<div id='footer'>
			<?php include 'footer.html'; ?>
		</div>

		</div> <!-- fin div superglobal -->
	</body>
</html>