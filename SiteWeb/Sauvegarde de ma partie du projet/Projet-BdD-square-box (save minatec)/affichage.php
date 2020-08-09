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
			$profil_php = "profil.php?id_user=" . $_SESSION['id_user'];

			$req_user = $bdd -> prepare('SELECT * FROM membres WHERE id_user = ? ');
			$req_user-> execute(array($_SESSION['id_user']));
			$user_info = $req_user-> Fetch(PDO::FETCH_ASSOC);

			$req_infos_apart = $bdd-> prepare("SELECT * FROM informations WHERE id_of_user = ? ");
			$req_infos_apart-> execute(array($_SESSION['id_user']));
		
			
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
		<h2> Affichage des informations de vos logements : </h2>

		<?php

			echo ' <font color="red" size="4"> Vous êtes connecté sous le compte de ' . $user_info['pseudo'] . '</font> <br> --> <a href="disconnect.php"> Se déconnecter </a> <br> <br>';

 			echo '<caption> Ceci est un tableau </caption>';// tr = nouvelle ligne
//____________________________________________________________________________________________________
			while ($nfo = $req_infos_apart-> fetch(PDO::FETCH_ASSOC))
			{  ?>
			<table id="affichage">
				<tr> 
					<th> id_user </th>
					<th> id_logement </th>
					<th> adresse1 </th>
					<th> adresse2 </th>
					<th> ville </th>
					<th> code_postal </th>
					<th> dimensions </th>
					<th> prix </th>
					<th> commentaire </th>
					<th> date </th>
					<th> heure </th>
					<th> mettre balise img </th>
				</tr>
				<tr>
					<th bgcolor="green"> <?php echo 'id -> ' . $nfo['id_of_user']; ?> </th>
					<td> <?php echo $nfo['id_logement'] ?> </td>
					<td> <?php echo $nfo['adresse1'] ?> </td>
					<td> <?php echo $nfo['adresse2'] ?> </td>
					<td> <?php echo $nfo['ville'] ?> </td>
					<td> <?php echo $nfo['code_postal'] ?> </td>
					<td> <?php echo $nfo['dimension'] ?> </td>
					<td> <?php echo $nfo['prix'] ?> </td>
					<td> <?php echo $nfo['commentaire'] ?> </td>
					<td> <?php echo $nfo['date'] ?> </td>
					<td> <?php echo $nfo['heure'] ?> </td>
					<td> <?php echo $nfo['pic_path'] ?> </td>
				</tr>	

			<?php echo '</table> <a href="modify_logement.php?id_l=' . $nfo['id_logement'] . '"> Modifier ce logement </a> <br> <br> <br>'; ?>
				
		<?php 
		//var_dump($nfo);
			}
			echo '</div>';

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