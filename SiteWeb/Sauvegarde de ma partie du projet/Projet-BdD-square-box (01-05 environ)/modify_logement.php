<?php
	session_start();

	include('fonction.php');

	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options); // Connex à la BdD par PDO

//____________________________________________________________________________________________________

	Try
	{
		$user = $bdd-> query("SELECT * FROM membres ORDER BY id_user");
		//$user = $bdd-> query("SELECT * FROM membres ORDER BY id_user DESC LIMIT 0,5"); // Sert à afficher uniquement les derniers membres créés
		
		if (isset($_SESSION['id_user']))
		{
			if (isset($_GET['id_l']))
			{
				$id_logement_prev_page = $_GET['id_l'];
				$req_idl = $bdd-> prepare("SELECT * FROM informations WHERE id_logement = ?");
 				$req_idl-> execute(array($id_logement_prev_page));
 				$logement_info = $req_idl-> Fetch(PDO::FETCH_ASSOC);
 				//var_dump($logement_info);
			}

			$profil_php = "profil.php?id_user=" . $_SESSION['id_user'];

			$req_user = $bdd -> prepare('SELECT * FROM membres WHERE id_user = ? ');
			$req_user-> execute(array($_SESSION['id_user']));
			$user_info = $req_user-> Fetch(PDO::FETCH_ASSOC);

			
		
			if (isset($_POST['form_inscription']))
			{
				if ($logement_info['id_of_user'] == $_SESSION['id_user'])
				{

				}
				//vérifier si le user a bien créé le logement, 
			}
//____________________________________________________________________________________________________

?>

<!doctype html>

<html>
	<head>
		<?php
			head(); // fonction qui regroupe tout le head
		?>

		<title> Affichage des infos </title>
		
		<!--<script>
		alert("<?php //echo 'Vous entrez dans l\'espace admin !'; ?>")
		</script>
		-->

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
					<li> <a href="android.php"> Android </a> </li>
					
				</nav>
				
		</div>

		<br><br><br><br><br><br><br><br><br><br><br><br>

		<div align="center"> <br>
		<h2> Modifier ce logement : </h2>

		<?php

			echo ' <font color="red" size="4"> Vous êtes connecté sous le compte de ' . $user_info['pseudo'] . '</font> <br> --> <a href="disconnect.php"> Se déconnecter </a> <br> <br>';

 			echo '<caption> Modification des données du logement </caption>';// tr = nouvelle ligne

//____________________________________________________________________________________________________
			?>

			<form>
				<table>
					<tr>
						<td align="right">
							<label for="adresse1"> Adresse1 : </label>
						</td>
						<td>
							<input type="text" name="adresse1" id="adresse1" value="<?php if (isset($logement_info['adresse1'])) { echo  $logement_info['adresse1']; } ?>" placeholder="Adresse1" autofocus>
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="adresse2"> Adresse2 : </label>
						</td>
						<td>
							<input type="text" name="adresse2" id="adresse2" value="<?php if (isset($logement_info['adresse2'])) { echo  $logement_info['adresse2']; } ?>" placeholder="Adresse2">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="ville"> Ville : </label>
						</td >
						<td>
							<input type="text" name="ville" id="ville" value="<?php if (isset($logement_info['ville'])) { echo  $logement_info['ville']; } ?>" placeholder="Ville">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="code_postal"> Code Postal : </label>
						</td>
						<td>
							<input type="text" name="code_postal" id="code_postal" value="<?php if (isset($logement_info['code_postal'])) { echo  $logement_info['code_postal']; } ?>" placeholder="Code Postal">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="dimension"> Dimension : </label>
						</td>
						<td>
							<input type="text" name="dimension" id="dimension" value="<?php if (isset($logement_info['dimension'])) { echo  $logement_info['dimension']; } ?>" placeholder="Dimension" >
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="commentaire"> Commentaire : </label>
						</td>
						<td>
							<input type="text" name="commentaire" id="commentaire" value="<?php if (isset($logement_info['commentaire'])) { echo  $logement_info['commentaire']; } ?>" placeholder="Commentaire">
						</td>
					</tr>
				</table> <br>
					<input type="submit" class="btn" value="Validation des informations" name="validation"> <br> <br>
			</form>
		<?php 

		}
		else
		{
			$profil_php = "profil.php";
			$erreur = "Vous n'êtes pas connecté ! <br> <br> Il faut être connecté pour voir ses apartements! <br> <br> <br> Redirection ...";
			header('Refresh: 2;URL=login.php');
		}

		if (isset($erreur))
		{
			echo "<div align=\"center\"> <font color=\"red\" size=\"5\"> <br> <br> <br> <br>" . $erreur . "</font> </div>";
		}

	} // Fin du try

	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error-> getMessage());
	}			

?>

	</body>

</html>