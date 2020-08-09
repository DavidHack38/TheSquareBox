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
			$id_user = $_GET['id_user'];

//____________________________________________________________________________________________________
?>

<!doctype html>

<html>
	<head>
		<?php
			head(); // fonction qui regroupe tout le head
		?>

		<title> page de profil </title>

	</head>
	<body>

		

		<div class="moncadre">

			<p class="title"> Bienvenue sur le site du projet "The Square Box" </p>
			
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

		<div align="center">
			<h2> Profil de : <?php echo $user_info['pseudo'] ?> </h2>
			<br><br>

			<?php
//____________________________________________________________________________________________________
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

				echo '<p> Votre mail est : ' . $user_info['mail'] . '</p>';
				//echo '<p> Votre mdp est : ' . $user_info['motdepasse'] . ' (encodé en sha1) </p>';
			

				if(isset($_SESSION['id_user']) AND $user_info['id_user'] == $_SESSION['id_user'])
				{
					echo '<li> <a href="edition_profil.php"> Editer mon profil </a> </li> <br>';
					echo '<li> <a href="affichage.php"> Voir mes logements </a> </li> <br>';
					echo '<li> <a href="disconnect.php"> Se déconnecter </a> </li>';
				}
			?>

		</div>
	</body>

<?php

		}
		else
		{		
			echo "<br><br><br><br><br>";
			echo "<div align=\"center\"> <font size=\"3\" color=\"red\"> Vous n'êtes pas connecté ! </font> </div>";
			echo "<br>";
			echo "<div align=\"center\"> <font size=\"3\" color=\"red\"> Redirection en cours ... </font> </div>";
			header("Refresh: 1; URL = login.php");
		}
	}

	//Traitement et affichage des erreur MYSQL
	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error-> getMessage());
	}

?>
</html>