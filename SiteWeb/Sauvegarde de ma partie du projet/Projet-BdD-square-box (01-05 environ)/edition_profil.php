<?php
	session_start();

	include('fonction.php');

	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options); // Connex à la BdD par PDO

	Try
	{

		if (isset($_SESSION['id_user'])) // fais le test pour renvoyer vers le bon profil (dans le html ligne 78)
		{
			$profil_php = "profil.php?id_user=" . $_SESSION['id_user'];
		}
		else
		{
			$profil_php = "profil.php";
		}

//____________________________________________________________________________________________________

		if (isset($_SESSION['id_user']))
		{
			
			$req_user = $bdd-> prepare("SELECT * FROM membres WHERE id_user = ? ");
			$req_user-> execute(array($_SESSION['id_user']));
			$user = $req_user-> Fetch();

//- pseudo -------------------------------------------------------------------------------------------
		
			if (isset($_POST['new_pseudo']) AND !empty($_POST['new_pseudo']) AND $_POST['new_pseudo'] != $user['pseudo'])
			{
				$new_pseudo = htmlspecialchars(trim($_POST['new_pseudo']));

				$req_pseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ? ");
				$req_pseudo->execute(array($new_pseudo));
				$pseudo_exist = $req_pseudo->rowcount();
				if ($pseudo_exist == 0)
				{
					$insert_pseudo = $bdd-> prepare("UPDATE membres SET pseudo = ? WHERE id_user = ? ");
					$insert_pseudo-> execute(array($new_pseudo, $_SESSION['id_user']));
					$erreur = "Votre pseudo a bien été modifié !";
					header('Refresh: 2;URL = profil.php?id_user=' . $_SESSION['id_user']);
				}
				else
				{
					$erreur = "Ce pseudo est déjà utilisé !";
				}
			}

//- mail ---------------------------------------------------------------------------------------------

			if (isset($_POST['new_mail']) AND !empty($_POST['new_mail']) AND $_POST['new_mail'] != $user['mail'])
			{
				$new_mail = htmlspecialchars(trim($_POST['new_mail']));

				$req_mail = $bdd->prepare("SELECT * FROM membres WHERE mail = ? ");
				$req_mail->execute(array($new_mail));
				$mail_exist = $req_mail->rowcount();
				if ($mail_exist == 0)
				{
					if (filter_var($mail, FILTER_VALIDATE_EMAIL))
					{
						$insert_mail = $bdd-> prepare("UPDATE membres SET mail = ? WHERE id_user = ? ");
						$insert_mail-> execute(array($new_mail, $_SESSION['id_user']));
						$erreur = "Votre mail a bien été modifié !";
						header('Refresh: 2;URL = profil.php?id_user=' . $_SESSION['id_user']);					
					}
					else
					{

						$erreur = "Cette adresse mail n'est pas correcte !";
					}
				}
				else
				{
					$erreur = "Ce mail est déjà utilisé !";
				}
			}

//- mdp ----------------------------------------------------------------------------------------------

			if (isset($_POST['new_mdp']) AND !empty($_POST['new_mdp']) AND isset($_POST['new_mdp2']) AND !empty($_POST['new_mdp2']))
			{
				$mdp = sha1($_POST['new_mdp']);
				$mdp2 = sha1($_POST['new_mdp2']);
				if ($mdp == $mdp2)
				{
					if ($mdp != $user['motdepasse'])
					{
						$insert_mdp = $bdd-> prepare("UPDATE membres SET motdepasse = ? WHERE id_user = ? ");
						$insert_mdp-> execute(array($mdp, $_SESSION['id_user']));
						$erreur = "Votre mot de passe a bien été modifié !";
						header('Refresh: 2;URL = profil.php?id_user=' . $_SESSION['id_user']);
					}
					else
					{
						$erreur = "Ce mot de passe est déjà le votre !";
					}
				}
				else
				{
					$erreur = "Vos deux mots de passe ne correspondent pas !";
				}
			}

//- avatar -------------------------------------------------------------------------------------------

			if (isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name']))
			{
				$taille_max = 20971520;
				$extension_valid = array('jpg', 'jpeg', 'gif', 'png');
				if ($_FILES['avatar']['size'] <= $taille_max)
				{
					$extension_upload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
					//strtolower permet de mettre tous les caractères en minuscule //substr permet d'ignorer le n caractère (ici n=1 à cause du 1 à la fin) du nom du fichier 'avatar'
					//strrchr permet de renvoyer l'extension du nom du fichier 'avatar' avec un point devant (ex: .jpeg)
					if (in_array($extension_upload, $extension_valid))
					{
						$path = "fichiers/membres/avatar/" . $_SESSION['pseudo'] . "." . $extension_upload;
						$result = move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
						if ($result)
						{
							$insert_avatar = $bdd-> prepare("UPDATE membres SET avatar = :avatar WHERE id_user = :id_user "); // :avatar et :id_user permettent d'utiliser la concaténation dans array
							$insert_avatar-> execute(array(
								'avatar' => $_SESSION['pseudo'] . "." . $extension_upload,
								'id_user' => $_SESSION['id_user']
								));
							$erreur = 'Vous avez bien modifié votre photo de profil Utilisez la combinaison Control + F5 pour afficher votre photo dans votre profil !';
							header('Refresh: 2;URL = profil.php?id_user=' . $_SESSION['id_user']);
						}
						else
						{
							$erreur = "Il y a eu une erreur pendant l'upload de votre image de profil !";
						}
					}
					else
					{
						$erreur = "Votre photo de profil doit être au format : jpg, jpeg, gif ou png !";
					}
				}
				else
				{
					$erreur = "Votre photo de profil doit être inférieur à 2 Mo !";    //PB : QUAND LIMAGE EST > A 2Mo, SA AFFICHE "IL Y A EU UNE ERREUR PENDANT LUPLOAD ..." Voir GitHub
				}
			}
//____________________________________________________________________________________________________

			if (isset($_POST['new_pseudo']) AND $_POST['new_pseudo'] == $user['pseudo'])
			{
				//header('location: profil.php?id_user=' . $_SESSION['id_user']);
			}

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
					<li> <a href="<?php echo $profil_php ?> "> Profil </a> </li>
					<li> <a href="admin.php"> Panel Admin (pas secure) </a> </li>
					<li> <a href="android.php"> Android.php </a> </li>
					
				</nav>
				
		</div>

		<br><br><br><br><br><br><br><br><br><br><br><br>

		<div align="center">
			<h2> Edition de mon profil </h2>
			<br>
			<div align="center">
				<form method="POST" action="" enctype="multipart/form-data">
					<table>
						<tr>
							<td align ="right">
								<label for="new_pseudo"> Insérer ici votre nouveau pseudo : </label>
							</td>
							<td>
								<input type="text" name="new_pseudo" id="new_pseudo" placeholder="Nouveau pseudo" value="<?php echo $user['pseudo']; ?>" autofocus > <br>
							</td>
						</tr>
								<tr> </tr>
						<tr>
							<td align ="right">
								<label for="new_mail"> Insérer ici votre nouveau mail : </label>
							</td>
							<td>
								<input type="text" name="new_mail" id="new_mail" placeholder="Nouveau mail" value="<?php echo $user['mail']; ?>"> <br>
							</td>
						</tr>
								<tr> </tr>
						<tr>
							<td align ="right">
								<label for="new_mdp"> Insérer ici votre nouveau mot de passe : </label>
							</td>
							<td>
								<input type="password" name="new_mdp" id="new_mdp" placeholder="Nouveau mot de passe"> <br>
							</td>
						</tr>
								<tr> </tr>
						<tr>
							<td align ="right">
								<label for="new_mdp2">Confirmation du mot de passe : </label>
							</td>
							<td>
								<input type="password" name="new_mdp2" id="new_mdp2" placeholder="Confirmation mot de passe"> <br>
							</td>
						</tr>
								<tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> <tr></tr> 
						<tr>
							<td align="right">
								<label> Photo de profil : </label>
							</td>
							<td>
								<input type="file" name="avatar" id="avatar">
							</td>
						</tr>
					</table> <br>
					<input type="submit" value="Enrengistrer les modifications !">

				</form>
			</div>

			<?php
				if (isset($erreur) AND !empty($erreur))
				{
					echo '<br>';
					echo '<font color = "red">' . $erreur . '</font>';

				}
			?>

		</div>
	</body>

<?php

		} // Fermeture du "if (isset $_SESSION['id_user'])"
		else
		{
			header("location: connexion.php");
		}

	} // fermeture du "Try"

	//Traitement et affichage des erreurs MYSQL
	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error ->getMessage());
	}

?>

</html>