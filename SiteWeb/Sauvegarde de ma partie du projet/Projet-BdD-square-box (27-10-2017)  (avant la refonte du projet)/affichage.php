<?php
	session_start();

	include('fonction.php');

	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options); // Connex à la BdD par PDO

//____________________________________________________________________________________________________

	Try
	{
		$user = $bdd-> query('SELECT * FROM membres ORDER BY id_user');
		//$user = $bdd-> query("SELECT * FROM membres ORDER BY id_user DESC LIMIT 0,5"); // Sert à afficher uniquement les derniers membres créés
		
		if (isset($_SESSION['id_user']))
		{
			$profil_php = "profil.php?id_user=" . $_SESSION['id_user'];

			$req_user = $bdd -> prepare('SELECT * FROM membres WHERE id_user = ? ');
			$req_user-> execute(array($_SESSION['id_user']));
			$user_info = $req_user-> Fetch(PDO::FETCH_ASSOC);

			$req_infos_apart = $bdd-> prepare('SELECT * FROM informations WHERE id_of_user = ? ');
			$req_infos_apart-> execute(array($_SESSION['id_user']));
			
//____________________________________________________________________________________________________

?>

<!doctype html>

<html>
	<head>
		<?php
			head(); // fonction qui regroupe tout le head
		?>

		<meta charset="utf-8">
		<title> Affichage des infos </title>

	</head>
	<body>

		<div class="moncadre">

			<p id="title"> Bienvenue sur le site du projet "The Square Box" </p>
				
			<a href="index.php"> <img class="zoom" src="fichiers/images/favicon2_no-process.png"/> </a>
					
				<nav id="navigation">
				
					<li> <a href="index.php"> Accueil </a> </li>
					<li> <a href="register.php"> Inscription au site </a> </li>
					<?php if (!isset($_SESSION['id_user'])) { echo '<li> <a href=\'login.php\'> Connexion </a> </li>';} ?>						
					<?php if (isset($_SESSION['id_user'])) { echo '<li> <a href=\'' . $profil_php .'\'> Profil </a> </li>';} ?>
					<li> <a href="admin.php"> Panel Admin (pas secure) </a> </li>
					<li> <a href="android.php"> Android </a> </li>
						
				</nav>
					
		</div>

		<br><br><br><br><br><br><br><br><br><br>
		<?php 
			if (isset($_SESSION['erreur']))
			{
				echo '<br> <font color=\'blue\' size=\'6\'> <div align=\'center\'>' . $_SESSION['erreur'] . '</div> </font> <br>';
				unset($_SESSION['erreur']);
			}
			else
			{
				echo '<br><br>';
			}
		?>
		
		<div id="superglobal">
		<div id="global">

		<div align="center"> <!-- div tableau -->
		<h2 class="explic"> Affichage des informations de vos logements : </h2>

		<?php

			echo '<font color="red" size="4"> Vous êtes connecté sous le compte de ' . $user_info['pseudo'] . '</font> <br> --> <a class=\'link\' href="disconnect.php"> Se déconnecter </a> <br> <br> <hr> <br>';
			

			if (isset($_GET['mode']) AND $_GET['mode'] == 'photo')
			{
				$req_pic_path = $bdd->prepare('SELECT adresse1, pic_path FROM informations WHERE id_logement = ?');
				$req_pic_path-> execute(array($_GET['idl']));
				$path_info = $req_pic_path-> Fetch(PDO::FETCH_ASSOC);

				$path_tab = explode('&#&', $path_info['pic_path']);
				//var_dump($path_tab);
				$path = 'C:/wamp64/www/Projet-BdD-square-box/fichiers/membres/photo_apart/';

				if (isset($_GET['del_img']) AND !empty($_GET['del_img']))
				{
					$img_del = trim(htmlspecialchars($_GET['del_img']));
					$key_del = array_search($img_del, $path_tab);
					unset($path_tab[$key_del]);	
					var_dump($path_tab);

					$nbr_row = count($path_tab);
					$req_upload_path = $bdd-> prepare('UPDATE informations SET pic_path = ? WHERE id_logement = ?');
					switch ($nbr_row) 
					{
						case '0':
							$req_upload_path-> execute(array(null, $_GET['idl']));
							//unlink($path . $img_del);
							$erreur = 'La photo a bien été supprimée !';
							header('location: affichage.php?mode=photo&idl=' . $_GET['idl']);
							break;

						case '1':
							if (isset($path_tab['0']))
							{
								$for_rename = substr($path_tab['0'], 0, -5);
								$old_target_path = $path . $path_tab['0'];
							}
							elseif (isset($path_tab['1']))
							{
								$for_rename = substr($path_tab['1'], 0, -5);
								$old_target_path = $path . $path_tab['1'];
							}

							$img_path = $for_rename . '1.png';
							$new_target_path = $path . $img_path;
							echo $old_target_path, $new_target_path;
							unlink($path . $img_del);
							rename($old_target_path, $new_target_path);
							
							$req_upload_path-> execute(array($img_path, $_GET['idl']));
							$_SESSION['erreur'] = 'La photo a bien été supprimée !';
							header('location: affichage.php?mode=photo&idl=' . $_GET['idl']);
							break;

						case '2': //si y'a deux img qui reste (après la suppression)
							for ($i=0; $i <= 2; $i++) 
							{
								$ii=1;
								if (isset($path_tab[$i]))
								{
									$for_rename = substr($path_tab[$i], 0, -5);
									$old_target_path = $path . $path_tab[$i];

									$img_path = $for_rename . $ii . '.png';
									$new_target_path = $path . $img_path;
									echo $img_path;
								}
								$ii++;

							}

							/*if (isset($path_tab['0']))
							{
								$for_rename_0 = substr($path_tab['0'], 0, -5);
								$old_target_path_0 = $path . $path_tab['0'];
							}
							if (isset($path_tab['1']))
							{
								$for_rename_1 = substr($path_tab['1'], 0, -5);
								$old_target_path_1 = $path . $path_tab['1'];
							}
							if (isset($path_tab['2']))
							{
								$for_rename_2 = substr($path_tab['2'], 0, -5);
								$old_target_path_2 = $path . $path_tab['2'];
							}*/




							/*$img_path = 'id=' . $pic_info['pic_id_user'] . ',idl=' . $pic_info['pic_idl'] . '--n3.png';
							$path_sql = $pic_info['pic_path'] . '&#&' . $img_path;

							$req_upload_path-> execute(array($path_sql, $_GET['idl']));*/
							break;
										
						case '3': //si y'a 3 img qui reste
							$img_path = 'id=' . $pic_info['pic_id_user'] . ',idl=' . $pic_info['pic_idl'] . '--n4.png';
							$path_sql = $pic_info['pic_path'] . '&#&' . $img_path;

							$req_upload_path-> execute(array($path_sql, $_GET['idl']));
							break;

						default:
							$erreur = 'Erreur ! Contacter l\'admin ';
							break;
					} //fin switch $nbr_row
				} //fin du if del_img

				$path = 'fichiers/membres/photo_apart/';

				echo '<div> <a class=\'btn\' href=\'affichage.php?mode=aff\'> <-- Retour </a> &nbsp; &nbsp; <h class=\'important\'> Affichage des photos du logement à l\'adresse : ' . $path_info['adresse1'] . ' </h> </div>';
				echo '<br> <a class=\'btn\' href=\'affichage.php?mode=add_photo&idl=' . $_GET['idl'] . '\'> Ajouter des photos </a> <hr>';

				
				var_dump($path_tab);
				$nbr_img = count($path_tab);
				var_dump($nbr_img);
				switch ($nbr_img)
				{
					case '0': // Vérifie que nbr_img est égal a 1 (obligatoire)
						if (isset($path_tab['0']) AND $path_tab['0'] == '') //Vérifie aussi qu'il n'y a pas de photo
						{
							echo '<br> Aucune photo ! <br> Vous pouvez cependant en rajouter en cliquant ici : <a class=\'link\' href=\'affichage.php?mode=add_photo&idl=' . $_GET['idl'] . '\'> Ajouter des photos </a>';
							break;
						}
					
					case '1':
						echo '<br> 1° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['0'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['0'] . '\'> Supprimer la photo </a>';
						break;

					case '2':
						echo '<br> 1° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['0'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['0'] . '\'> Supprimer la photo </a> <hr> <br>';

						echo '<br> 2° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['1'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['1'] . '\'> Supprimer la photo </a>';
						break;

					case '3':
						echo '<br> 1° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['0'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['0'] . '\'> Supprimer la photo </a> <hr> <br>';

						echo '<br> 2° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['1'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['1'] . '\'> Supprimer la photo </a> <hr> <br>';

						echo '<br> 3° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['2'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['2'] . '\'> Supprimer la photo </a>';
						break;

					case '4':
						echo '<br> 1° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['0'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['0'] . '\'> Supprimer la photo </a> <hr> <br>';

						echo '<br> 2° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['1'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['1'] . '\'> Supprimer la photo </a> <hr> <br>';

						echo '<br> 3° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['2'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['2'] . '\'> Supprimer la photo </a> <hr> <br>';

						echo '<br> 4° image : <br> <br>';
						echo '<img class=\'aff_photo\' src=\'' . $path . $path_tab['3'] . '\'> </img> <br> <br>';
						echo '<a class=\'btn\' href=\'affichage.php?mode=photo&idl=' . $_GET['idl'] . '&del_img=' . $path_tab['3'] . '\'> Supprimer la photo </a>';
						break;
					
					default:
						$erreur = 'Erreur ! Contacter l\'admin ';
						break;
				}

			}
//___________________________________________________________________________________________________________________________________________________________
			elseif (isset($_GET['mode']) AND $_GET['mode'] == 'add_photo')
			{
				$req_path = $bdd-> prepare("SELECT id_logement, adresse1, ville, pic_id_user, pic_idl, pic_path FROM informations WHERE id_logement = ?");
				$req_path-> execute(array($_GET['idl']));
				$pic_info = $req_path-> fetch(PDO::FETCH_ASSOC);
				//var_dump($pic_info);

				if (isset($_POST['validation']) AND isset($_FILES['photo']) AND !empty($_FILES['photo']['name']))
				{
					$taille_max = 20971520;
					$extension_valid = array('jpg', 'jpeg', 'gif', 'png');
					if ($_FILES['photo']['size'] <= $taille_max)
					{
						$extension_upload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
						//strtolower permet de mettre tous les caractères en minuscule //substr permet d'ignorer le n caractère (ici n=1 à cause du 1 à la fin) du nom du fichier 'photo'
						//strrchr permet de renvoyer l'extension du nom du fichier 'photo' avec un point devant (ex: .jpeg)
						if (in_array($extension_upload, $extension_valid))
						{
							$path  = "C:/wamp64/www/Projet-BdD-square-box/fichiers/membres/photo_apart/";
							$old_target_path = $_FILES['photo']['tmp_name'];
							$default = 'pic_not_found.png';


							$expl_path = explode('&#&', $pic_info['pic_path']);
							$nb_row = count($expl_path);

			
							switch ($nb_row)
							{
								case '1':
									if ($expl_path['0'] == '') //si aucune photo (egal à null)
									{
										$img_path = 'id=' . $pic_info['pic_id_user'] . ',idl=' . $pic_info['pic_idl'] . '--n1.png';
										$path_sql = $img_path;
										break;
									}
									elseif ($expl_path['0'] != '') //si qqch dans première ligne 
									{
										$img_path = 'id=' . $pic_info['pic_id_user'] . ',idl=' . $pic_info['pic_idl'] . '--n2.png';
										$path_sql = $pic_info['pic_path'] . '&#&' . $img_path;
										break;
									}

								case '2': //si y'a deux img
									$img_path = 'id=' . $pic_info['pic_id_user'] . ',idl=' . $pic_info['pic_idl'] . '--n3.png';
									$path_sql = $pic_info['pic_path'] . '&#&' . $img_path;
									break;
										
								case '3': //si y'a 3 img
									$img_path = 'id=' . $pic_info['pic_id_user'] . ',idl=' . $pic_info['pic_idl'] . '--n4.png';
									$path_sql = $pic_info['pic_path'] . '&#&' . $img_path;
									break;

								case '4': //si y'a 4 img
									$img_path = 'id=' . $pic_info['pic_id_user'] . ',idl=' . $pic_info['pic_idl'] . '--n_2manyphoto.png';
									$path_sql = $pic_info['pic_path'];
									break;
							}

//__________________________________________________________________________________________________________________________________

							var_dump($img_path, $path_sql);

							$new_target_path = $path . $img_path;
							$result = move_uploaded_file($old_target_path, $new_target_path);

							if ($result)
							{
								$insert_photo = $bdd-> prepare("UPDATE informations SET pic_path = ? WHERE id_logement = ?");
								$insert_photo-> execute(array($path_sql, $_GET['idl']));
								$erreur = 'Vous avez correctement uploader la photo ! <br> Vous aller être redirigé ...';
								header('Refresh: 2;URL = affichage.php?mode=photo&idl=' . $_GET['idl']);
							}
							else
							{
								$erreur = "Il y a eu une erreur pendant l'upload de la photo !";
							}
						}
						else
						{
							$erreur = "La photo doit être au format : jpg, jpeg, gif ou png !";
						}
					}
					else
					{
						$erreur = "La photo doit être inférieur à 2 Mo !";    //PB : QUAND LIMAGE EST > A 2Mo, SA AFFICHE "IL Y A EU UNE ERREUR PENDANT LUPLOAD ..." Voir GitHub
					}
				
				} //fin if vérif isset et validation ?>
				<font color='red'> Upload d'une photo pour le logement situé au : <?php echo $pic_info['adresse1'] . ' (id : ' . $pic_info['id_logement'] . ')' ?> <br><br> </font>
				<form method="POST" action="" enctype="multipart/form-data">
					<table>
						<tr>
							<td align="right">
								<label for='photo'> Photo du logement : </label>
							</td>
							<td>
								<input type="file" name="photo" id="photo">
							</td>
						</tr>
					</table> <br>

					<input class='btn' type="submit" name='validation'>
				</form> <?php

	 		}
//_________________________________________________________________________________________________________________________
			elseif (isset($_GET['mode']) AND $_GET['mode'] == 'aff')
			{
				while ($nfo = $req_infos_apart-> fetch(PDO::FETCH_ASSOC))
				{  
					//var_dump($nfo);
					echo '<caption> <p class=\'important\'> Infos sur le logement situé au : ' . $nfo['adresse1'] . ' à ' . $nfo['ville'] . ' </p> </caption>';// tr = nouvelle ligne
		?>
					<table id='affichage'>
						<tr> 
							<th> Id_user </th>
							<th> Id_logement </th>
							<th> Adresse1 </th>
							<th> Adresse2 </th>
							<th> Ville </th>
							<th> Code_postal </th>
							<th> Dimensions </th>
							<th> Prix </th>
							<th> Commentaire </th>
							<th> Date </th>
							<th> Heure </th>
							<th> Images du logement </th>
							<th> Chemin de la photo </th>
						</tr>
						<tr>
							<th bgcolor='green'> <?php echo 'id -> ' . $nfo['id_of_user']; ?> </th>
							<td> <?php echo $nfo['id_logement']; ?> </td>
							<td> <?php echo $nfo['adresse1']; ?> </td>
							<td> <?php echo $nfo['adresse2']; ?> </td>
							<td> <?php echo $nfo['ville']; ?> </td>
							<td> <?php echo $nfo['code_postal']; ?> </td>
							<td> <?php echo $nfo['dimension']; ?> </td>
							<td> <?php echo $nfo['prix']; ?> </td>
							<td> <?php echo $nfo['commentaire']; ?> </td>
							<td> <?php echo $nfo['date']; ?> </td>
							<td> <?php echo $nfo['heure']; ?> </td>
							<?php echo '<td> <a class=\'link\' href=\'affichage.php?mode=photo&idl=' . $nfo['id_logement'] . '\'> Voir les photos </a>'; ?>
							<td> <?php echo $nfo['pic_path']; ?> </td>
						</tr>
					</table>

<?php 				echo '<a class=\'link\' href="modify_logement.php?id_l=' . $nfo['id_logement'] . '"> Modifier ce logement </a> <br> <br> <hr> <br> <br>';
				} // fin boucle while
			} // fin if pour gérer le mode affichage et add_photo
		} // fin if session
		else
		{
			$profil_php = "profil.php";
			$erreur = "Vous n'êtes pas connecté ! <br> <br> Il faut être connecté pour voir ses apartements! <br> <br> <br> Redirection ...";
			header('Refresh: 2;URL=login.php');
		}

		if (isset($erreur))
		{
			echo '<div align=\'center\'> <font color=\'red\' size=\'5\'> <br> <br>' . $erreur . '</font> </div>';
		}

	} // Fin du try

	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error-> getMessage());
	}			

?>
			</div> <!-- fin div tableau -->
		</div> <!-- fin du div global -->

		<div id="footer">
			<?php include 'footer.html'; ?>
		</div>

		</div> <!-- fin div superglobal -->
	</body>
</html>