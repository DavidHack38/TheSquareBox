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


		if (isset($_GET['key'], $_GET['pseudo']) AND !empty($_GET['key'], $_GET['pseudo']))
		{
			$key = htmlspecialchars(trim($_GET['key']));
			$pseudo = htmlspecialchars(trim($_GET['pseudo']));

			$req_acc_valid = $bdd-> prepare('SELECT confirm_by_mail FROM membres WHERE mail_key = ? AND pseudo = ? ');
			$req_acc_valid-> execute(array($key, $pseudo));
			$acc_valid = $req_acc_valid-> Fetch(PDO::FETCH_ASSOC);

			if ($acc_valid != 'false')
			{
				if ($acc_valid['confirm_by_mail'] == 'FALSE')
				{
					$req_validation_acc = $bdd-> prepare('UPDATE membres SET confirm_by_mail = \'TRUE\' WHERE mail_key = ? AND pseudo = ? ');
					$req_validation_acc-> execute(array($key, $pseudo));
					if ($req_validation_acc) {$erreur = 'Votre compte : ' . $pseudo . ' a bien été validé !';}
				}
				else
				{
					$erreur = 'Votre compte est déjà validé !!';
				}
			}
			else
			{
				$erreur = 'Votre clé (ou votre pseudo) ne fonctionne pas. Vérifiez que vous êtes bien arrivé sur cette page via un email !';
			}
		}

?>

<!doctype html>

<html>
	<head>
		<?php
			head(); // fonction qui regroupe tout le head (UPDATE depuis le futur : c'est débile x)
		?>

		<meta charset='utf-8'>
		<title> Confirmation du compte </title>
		
	</head>
	<body>
			<div class='moncadre'>

				<p id='title'> Bienvenue sur le site du projet "The Square Box" </p>
				
				<a href='index.php'> <img class='zoom' src='fichiers/images/favicon2_no-process.png'/> </a>
					
					<nav id='navigation'>
					
						<li> <a href='index.php'> Accueil </a> </li>
						<li> <a href='register.php'> Inscription au site </a> </li>
						<?php if (!isset($_SESSION['id_user'])) { echo '<li> <a href=\'login.php\'> Connexion </a> </li>';} ?>
						<?php if (isset($_SESSION['id_user'])) { echo '<li> <a href=\'' . $profil_php .'\'> Profil </a> </li>';} ?>
						<li> <a href='admin.php'> Panel Admin (pas secure) </a> </li>
						<li> <a href='android.php'> Android.php </a> </li>
						
					</nav>
					
			</div>

			<br><br><br><br><br><br><br><br><br><br><br><br>

			<div id='superglobal'>
			<div id='global'>
<?php
			

			echo '<div align=\'center\'>
				<h2 class=\'explic\'> Confirmation de votre compte </h2>';

			if (isset($erreur) AND !empty($erreur)) // Vérifie qu'il y a une erreur
			{
				echo '<h2 class=\'title\'> <br> <br>' . $erreur . '</h2> <br> <br>';
			}

			echo '</div>';

	} //fin du try

	//Traitement et affichage des erreur MYSQL
	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error-> getMessage());
	}
?>

		</div> <!-- fin div global-->

		<div id='footer'>
			<?php include 'footer.html'; ?>
		</div>

		</div> <!-- fin div superglobal -->
	</body>
</html>