<?php
	session_start();

	include('fonction.php');

	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options); // Connex à la BdD par PDO

//____________________________________________________________________________________________________

	Try
	{
		if (isset($_SESSION['id_user'])) 
		{
			$profil_php = "profil.php?id_user=" . $_SESSION['id_user']; // Si connecté alors renvoit vers la page profil avec l'id du user

			$req_user = $bdd -> prepare('SELECT * FROM membres WHERE id_user = ? ');
			$req_user -> execute(array($_SESSION['id_user']));
			$user_info = $req_user-> Fetch(PDO::FETCH_ASSOC);


			if (isset($_SESSION['admin']) AND $_SESSION['admin'] == 'TRUE') // Si user est admin
			{
				if (isset($_GET['type']) AND $_GET['type'] == 'membres') // Si le type de l'entrée est membres
				{
					if (isset($_GET['id_confirm']) AND !empty($_GET['id_confirm'])) // Confirmer un compte (mail)
					{
						$id_confirm = (int) $_GET['id_confirm'];
						$req_confirm = $bdd-> prepare("UPDATE membres SET confirm_by_mail = 'TRUE' WHERE id_user = ? ");
						$req_confirm-> execute(array($id_confirm));
						//header("location: admin.php");
					}

					if (isset($_GET['id_admin']) AND !empty($_GET['id_admin'])) // Passer admin un user
					{
						$id_admin = (int) $_GET['id_admin'];
						$req_admin = $bdd-> prepare("UPDATE membres SET admin = 'TRUE' WHERE id_user = ? ");
						$req_admin-> execute(array($id_admin));
						//header("location: admin.php");
					}

					if (isset($_GET['id_revoq_admin']) AND !empty($_GET['id_revoq_admin'])) // Enlever les droits admin à un user
					{
						$id_revoq_admin = (int) $_GET['id_revoq_admin'];
						$req_admin = $bdd-> prepare("UPDATE membres SET admin = 'FALSE' WHERE id_user = ? ");
						$req_admin-> execute(array($id_revoq_admin));
						//header("location: admin.php");
					}

					//Marche pas encore :'(
					if (isset($_REQUEST['id_suppr']) AND !empty($_REQUEST['id_suppr'])) // Supprimer un compte
					{
						$id_suppr = (int) $_GET['id_suppr'];
						$req_suppr = $bdd-> query("DELETE FROM membres WHERE id_user = ?");
						$req_suppr->execute($id_suppr);
						//header('location: admin.php');
					}
				}
		
				$user = $bdd-> query("SELECT * FROM membres ORDER BY id_user");
				//$user = $bdd-> query("SELECT * FROM membres ORDER BY id_user DESC LIMIT 0,5"); // Sert à afficher uniquement les derniers membres créés
//____________________________________________________________________________________________________

?>

<!doctype html>

<html>
	<head>
		<?php
			head(); // fonction qui regroupe tout le head
		?>

		<title> Espace d'administration </title>

	</head>
	<body>

		

		<div class="moncadre">

			<p class="title"> Bienvenue sur le site du projet "The Square Box" </p>
			
			<a href="index.php"> <img class="zoom" src="fichiers/images/favicon2_no-process.png"/> </a>
				
				<nav id="navigation">
				
					<li> <a href="index.php"> Accueil </a> </li>
					<li> <a href="register.php"> Inscription au site </a> </li>
					<li> <a href="login.php"> Connexion </a> </li>
					<li> <a href="<?php echo $profil_php ?> "> Profil </a> </li>
					<li> <a id="active" href="admin.php"> Panel Admin (pas secure) </a> </li>
					<li> <a href="android.php"> Android </a> </li>
					
				</nav>
				
		</div>

		<br><br><br><br><br><br><br><br><br><br><br><br>

		<div align="center"> <br>
			<h2> Espace d'administration : </h2>

			<?php

				echo ' <font color="red" size="4"> Vous êtes connecté sous le compte de ' . $user_info['pseudo'] . '</font> <br> --> <a href="disconnect.php"> Se déconnecter </a>';

				echo '</div> <ul>';
 
//____________________________________________________________________________________________________
				while ($u = $user->fetch())
				{
					echo '<li>' . $u['id_user'] . '<br> Pseudo : ' . $u['pseudo'] . '<br>'; 

					if ($u['confirm_by_mail'] == 'FALSE') 
					{
						echo '&nbsp;&nbsp; -> <a id="link" href="admin.php?type=membres&id_confirm=' . $u['id_user'] . '"> Confirmer</a> <br>';
					}
					elseif ($u['confirm_by_mail'] == 'TRUE')
					{
						echo '<font color=red> &nbsp;&nbsp; Compte confirmé ! </font> <br>';
					}

					if ($u['admin'] == 'FALSE')
					{
						echo '&nbsp;&nbsp;&nbsp; -> <a id="link" href="admin.php?type=membres&id_admin=' . $u['id_user'] . '"> Passer admin</a> <br>';
					}
					elseif ($u['admin'] == 'TRUE')
					{
						echo ' <font color=blue> &nbsp;&nbsp; Compte admin ! </font>';
						echo '&nbsp;&nbsp;&nbsp; ==> <a id="link" href="admin.php?type=membres&id_revoq_admin=' . $u['id_user'] . '"> Révoquer les droits Admin</a> <br>';
					}
					
					echo '&nbsp;&nbsp; -> <a href="admin.php?type=membre&id_suppr=' . $u['id_user'] . '" onclick="return(confirm(\'Vous allez supprimer ce membre. Attention, cette action est irréversible ! \'));"> Supprimer </a> </li> <br>';

				}

//____________________________________________________________________________________________________
			
			echo '</ul>';


			} // fin du if pour vérif si admin
			else
			{
				$erreur = "Vous n'êtes pas admin ! <br> <br> Il faut être administrateur pour accéder à cette page !!";
				header('Refresh: 2;URL=profil.php?id_user=' . $_SESSION['id_user'] . '');
			}
		}
		else
		{
			$profil_php = "profil.php"; // si pas connecté alors renvoit vers la page de profil simple
			$erreur = "Vous n'êtes pas connecté ! Il faut être connecté en temps qu'admin pour accéder à cette page !";
			header('Refresh: 2;URL=login.php');
		}


		if (isset($erreur))
		{
			echo "<div align=\"center\"> <font color=\"red\" size=\"5\"> <br> <br> <br> <br>" . $erreur . "</font> </div>";
		}

	} // Fin du try

//___________________________________________________________________________________________________________________

	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error-> getMessage());
	}			

?>

	</body>

</html>