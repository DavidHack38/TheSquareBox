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
		if (isset($_SESSION['id_user'])) // fais le test pour renvoyer vers le bon profil (dans le html ligne 43)
		{
			$profil_php = 'profil.php?id_user=' . $_SESSION['id_user'];
		}
		else
		{
			$profil_php = 'profil.php';
		}
?>

<!DOCTYPE html>

<html>
	<head>
		<?php
			head(); // fonction qui regroupe tout le head
		?>
		<meta charset='utf-8'>
		<title> The Square Box </title>

	</head>
	<body>

			<div class='moncadre'>

				<p id='title'> Bienvenue sur le site du projet "The Square Box" </p>

				<a href='index.php'> <img class='zoom' src='fichiers/images/favicon2_no-process.png'/> </a>

					<nav id='nav'>

						<li> <a id='active' href='index.php'> Accueil </a> </li>
						<li> <a href='register.php'> Inscription au site </a> </li>
						<li> <a href='login.php'> Connexion </a> </li>
						<li> <a href="<?php echo $profil_php ?>"> Profil </a> </li>
						<li> <a href='admin.php'> Panel Admin (pas secure) </a> </li>
						<li> <a href='android.php'> Android.php </a> </li>

					</nav>
					
			</div>
			<br><br><br><br><br><br><br><br><br><br><br>

			<div id='superglobal'>
			<div id='global'>

			<!--<p> Mettre ici les mesures avec un tableau <br> Pour faire un tableau, faire des recherches sur "table" (avec des < >) </p> <br> <br>
			<p> <font color='red'> Voir ici pour les jointures entre deux tables <a name='link' href='https://openclassrooms.com/courses/concevez-votre-site-web-avec-php-et-mysql/les-jointures-entre-tables' > Les jointures </a> </font> </p> -->

			<div align='center'> 
				<h2> <p class='important'> Bonjour et bienvenue sur le site du projet "The Square Box !" </p> <br> <br> 
				Je vous invite à : <br> 
				- créer un compte dès maintenant pour profiter des fonctionnalités du site <br> 
				- Vous connecter si vous avez déjà un compte </h2> 
			</div>
		</div> <!-- fin div global -->

		<div id='footer'>
			<?php include 'footer.html'; ?>
		</div>

		</div> <!-- fin div superglobal-->
	</body>
</html>

<?php


	} //fin du try

	//Traitement et affichage des erreur MYSQL
	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error ->getMessage());
	}
?>
