<?php
	session_start();

	include('fonction.php');

	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options); // Connex à la BdD par PDO

	Try
	{
		if (isset($_SESSION['id_user'])) // fais le test pour renvoyer vers le bon profil (dans le html ligne 48)
		{
			$profil_php = "profil.php?id_user=" . $_SESSION['id_user'];
		}
		else
		{
			$profil_php = "profil.php";
		}

//____________________________________________________________________________________________________

		if (isset($_GET['id_user']) AND $_GET['id_user'] > 0)
		{
			$get_id = intval($_GET['id_user']);
			$req_user = $bdd -> prepare('SELECT * FROM membres WHERE id_user = ? ');
			$req_user -> execute(array($get_id));
			$user_info = $req_user-> Fetch();

//____________________________________________________________________________________________________
?>

<!doctype html>

<html>
	<head>
		<?php
			head(); // fonction qui regroupe tout le head
		?>

		<meta charset="utf-8">
		<title> page de profil </title>

	</head>
	<body>

			<div class="moncadre">

				<p id="title"> Bienvenue sur le site du projet "The Square Box" </p>
				
				<a href="index.php"> <img class="zoom" src="fichiers/images/favicon2_no-process.png"/> </a>
					
					<nav id="navigation">
					
						<li> <a href="index.php"> Accueil </a> </li>
						<li> <a href="register.php"> Inscription au site </a> </li>
						<li> <a href="login.php"> Connexion </a> </li>
						<li> <a id="active" href="<?php echo $profil_php ?> "> Profil </a> </li>
						<li> <a href="admin.php"> Panel Admin (pas secure) </a> </li>
						<li> <a href="android.php"> Android.php </a> </li>
						
					</nav>
					
			</div>

			<br><br><br><br><br><br><br><br><br><br><br><br>

			<div id="superglobal">
			<div id="global">

			<div align="center">
				<h2 class="explic"> Profil de : <?php echo $user_info['pseudo'] ?> </h2>
				<br><br>
				
<?php
			$req_acc_valid = $bdd-> prepare('SELECT confirm_by_mail FROM membres WHERE id_user = ?');
			$req_acc_valid-> execute(array($get_id));
			$acc_valid = $req_acc_valid-> Fetch(PDO::FETCH_ASSOC);

			if ($acc_valid['confirm_by_mail'] == 'FALSE')
			{
				echo '<div class="message">
				Votre compte n\'est pas valide ! Vérifier vos mails ! <br> 
				<a href=\'#\'> Me renvoyer le mail </a>
				</div> <br>';
			}

			if (isset($user_info['avatar']))
			{
				if ($user_info['avatar'] == "default_profil.png")
				{
					$path = "fichiers/images/default_profil.png";
				}
				else
				{
					$path = "fichiers/membres/avatar/" . $user_info['avatar'];
				}
			}

			echo '<img src="' . $path . '" width="150" alt="Aucune image"> <br>';

			echo '<h4> Votre mail est : ' . $user_info['mail'] . '</h4>';
			//echo '<p> Votre mdp est : ' . $user_info['motdepasse'] . ' (encodé en sha1) </p>';
			

			if (isset($_SESSION['id_user']) AND $user_info['id_user'] == $_SESSION['id_user'])
			{
				echo '<li> <a class=\'link\' href="edition_profil.php"> Editer mon profil </a> </li> <br>';
				echo '<li> <a class=\'link\' href="affichage.php"> Voir mes logements </a> </li> <br>';
				echo '<li> <a class=\'link\' href="disconnect.php"> Se déconnecter </a> </li> <br>';
				echo '</div>'; //fin div profil
			}
		} // fin du if (isset $_SESSION['id_user'])
		else
		{
			echo '<br><br><br><br><br>';
			echo '<div align="center"> <font size="5" color="red"> Vous n\'êtes pas connecté !';
			echo '<br>';
			echo ' Redirection en cours ... </font> </div>';
			header("Refresh: 1; URL = login.php");
		}
	}

	//Traitement et affichage des erreur MYSQL
	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error-> getMessage());
	}

?>
		</div> <!-- fin div global -->

		<div id="footer">
			<?php include 'footer.html'; ?>
		</div>

		</div> <!-- fin div superglobal -->
	</body>
</html>