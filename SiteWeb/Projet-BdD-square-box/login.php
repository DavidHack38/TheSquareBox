<?php
	session_start();

	include('fonction.php');
	
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options); // Connex à la BdD par PDO

	Try
	{
		if (isset($_SESSION['id_user'])) // fais le test pour renvoyer vers le bon profil (dans le html ligne 68)
		{
			$profil_php = 'profil.php?id_user=' . $_SESSION['id_user'];
			$deja_co = (int) 1;
		}
		else
		{
			$profil_php = 'profil.php';
		}
		
//__________________________________________________________________________________________________________________________________________________________________________________________


		// S'execute uniquement après un click sur le bouton "Connecte moi !"
		if (isset($_POST['form_connex']))
		{
			$pseudo_connex = htmlspecialchars(trim($_POST['pseudo_connex']));
			$mdp_connex = sha1(trim($_POST['mdp_connex']));

			if (!empty($pseudo_connex) AND !empty($mdp_connex) AND isset($mdp_connex) AND isset($pseudo_connex))
			{
				$req_user = $bdd-> prepare('SELECT * FROM membres WHERE pseudo = ? AND motdepasse = ? ');
				$req_user-> execute(array($pseudo_connex, $mdp_connex));
				$user_exist = $req_user-> rowcount();

				if ($user_exist == 1)
				{
					$user_info = $req_user-> Fetch();
					$_SESSION['id_user'] = $user_info['id_user'];
					$_SESSION['pseudo'] = $user_info['pseudo'];
					$_SESSION['admin'] = $user_info['admin'];
					header('location: profil.php?id_user=' . $_SESSION['id_user']);
				}
				else
				{
				$erreur = 'Le pseudo ou le mot de passe est erroné. ';
				}
			}
			else
			{
				$erreur = 'Tous les champs doivent être complétés';
			}
		}
?>

<!doctype html>

<html>
	<head>
		<?php
			head(); // fonction qui regroupe tout le head
		?>

		<meta charset='utf-8'>
		<title> Connexion à votre compte </title>

	</head>
	<body>

			<div class='moncadre'>

				<p id='title'> Bienvenue sur le site du projet "The Square Box" </p>
				
				<a href='index.php'> <img class='zoom' src='fichiers/images/favicon2_no-process.png'/> </a>
					
					<nav id='navigation'>
					
						<li> <a href='index.php'> Accueil </a> </li>
						<li> <a href='register.php'> Inscription au site </a> </li>
						<li> <a id='active' href='login.php'> Connexion </a> </li>
						<?php if (isset($_SESSION['id_user'])) { echo '<li> <a href=\'' . $profil_php .'\'> Profil </a> </li>';} ?>
						<li> <a href='admin.php'> Panel Admin (pas secure) </a> </li>
						<li> <a href='android.php'> Android.php </a> </li>
						
					</nav>
					
			</div>

			<br><br><br><br><br><br><br><br><br><br><br><br>

			<div id='superglobal'>
			<div id='global'>

			<div align='center'>
				<h2 class="explic"> Connexion </h2>
				<form method='POST' action=''>
					
					<table>
						<tr>
							<td align='right'>
								<label for='pseudo_connex'> Pseudo : </label>
							</td>
							<td>
								<input type='text' name='pseudo_connex' id='pseudo_connex' value="<?php if (isset($pseudo_connex)) { echo  $pseudo_connex; } ?>" placeholder='Votre pseudo' autofocus >
							</td>
						</tr>
						<tr>
							<td align='right'>
								<label for='mdp_connex'> Mot de passe : </label>
							</td>
							<td>
								<input type='password' name='mdp_connex' id='mdp_connex' placeholder='Votre Mot de passe'>
							</td>
						</tr>

					</table> <br>
					<input type='submit' class='btn' value='Connecte moi !' name='form_connex'>
				</form> <br>
<?php
		if (isset($erreur) AND !empty($erreur)) // Vérifie qu'il y a une erreur
		{
			if ($erreur == 'Votre compte a bien été créé') // Truc à la con qui bug (faire des variables $_SESSION)
			{
				echo $erreur; // de même
				sleep(3); // de même
				header('Location: index.php'); // de même
			}
			else
			{
				echo '<p class=\'important\'>' . $erreur . '</p>';
	 		}
		}

		if (isset($deja_co) AND $deja_co == '1')
		{
			header('Location: ' . $profil_php);
		}
	} //fin du try

	//Traitement et affichage des erreur MYSQL
	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error ->getMessage());
	}

?>
			</div> <!-- fin div form -->
		</div> <!-- fin div global -->

		<div id='footer'>
			<?php include 'footer.html'; ?>
		</div>

		</div> <!-- fin div superglobal -->
	</body>
</html>