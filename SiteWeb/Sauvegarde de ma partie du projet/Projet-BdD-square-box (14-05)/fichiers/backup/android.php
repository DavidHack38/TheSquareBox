<?php

	Try
	{   
		session_start();
		//Connex  à la BdD
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options);

		$req_user = $bdd-> prepare("SELECT * FROM membres");
		$req_user-> execute();
		$user_info = $req_user-> fetchAll(PDO::FETCH_ASSOC);
		//var_dump($user_info);

		$req_infos = $bdd-> prepare("SELECT * FROM informations");
		$req_infos-> execute();
		$data_info = $req_infos-> fetchAll(PDO::FETCH_ASSOC);

//__Connex Android a la BdD___________________________________________________________________________________________

		if (isset($_REQUEST['user'])) // android.php?user={"pseudo":"ioio","motdepasse":"42"}
		{
			$connex_liam = json_decode($_REQUEST['user'], TRUE);

			$pseudo_liam = $connex_liam['pseudo']; //user = ioio

			$motdepasse_liam = $connex_liam['motdepasse']; // mdp = 42

			$motdepasse_liam_encod = sha1($motdepasse_liam); // mdp = 92cfceb39d57d914ed8b14d0e37643de0797ae56


//-----------------------------------------------------------------------------------------------------

			$req_user = $bdd-> prepare("SELECT id_user, pseudo, motdepasse FROM membres");
			$req_user-> execute();
			$data_bdd = $req_user-> fetchAll(PDO::FETCH_ASSOC);


			foreach ($data_bdd as $value)
			{
				if ($value['pseudo'] == $pseudo_liam AND $value['motdepasse'] == $motdepasse_liam_encod)
				{
					$verif_connex_pseudo = $value['pseudo'];
					$verif_connex_id = $value['id_user'];

					echo "{\"id\":\"" . $verif_connex_id . "\"}";
					break;
				}
				else
				{
					echo 'ça marche pas !';
					break;
				}
			}
		}

//__Récupération des infos de l'apart___________________________________________________________________________________________

		if (isset($_REQUEST['infos'])) // android.php?infos={"id":"102555","idl":"A1","adresse1":"458","adresse2":"5896","ville":"apprieu","codepostal":"25896","date":"10/02/0255","heure":"12:10","prix":"55","commentaire":"srgfdg", "info":"modifier","dimension":"123"}
		{
			$infos = json_decode($_REQUEST['infos'], TRUE);

			//var_dump($infos);
			$req = $bdd-> prepare("SELECT * FROM informations WHERE id_logement = ? ");
			$req-> execute(array($infos['idl']));
			$var4 = $req-> fetch(PDO::FETCH_ASSOC);
			//var_dump($var4);

			if ($infos['id'] == 'null')
			{
				$id_of_user = $var4['id_of_user'];
			}
			elseif ($infos['id'] != 'null')
			{
				$id_of_user = $infos['id'];
			}


			if ($infos['idl'] == 'null')
			{
				$id_logement = $var4['id_logement'];
			}
			elseif ($infos['idl'] != 'null')
			{
				$id_logement = $infos['idl'];
			}


			if ($infos['adresse1'] == 'null') 
			{
				$adresse1 = $var4['adresse1'];
			}
			elseif ($infos['adresse1'] != 'null')
			{
				$adresse1 = $infos['adresse1'];
			}


			if ($infos['adresse2'] == 'null') 
			{
				$adresse2 = $var4['adresse2'];
			}
			elseif ($infos['adresse2'] != 'null')
			{
				$adresse2 = $infos['adresse2'];
			}

			if ($infos['ville'] == 'null') 
			{
				$ville = $var4['ville'];
			}
			elseif ($infos['ville'] != 'null')
			{
				$ville = $infos['ville'];
			}


			if ($infos['codepostal'] == 'null') 
			{
				$code_postal = $var4['code_postal'];
			}
			elseif ($infos['codepostal'] != 'null')
			{
				$code_postal = $infos['codepostal'];
			}


			if ($infos['date'] == 'null') 
			{
				$date = $var4['date'];
			}
			elseif ($infos['date'] != 'null')
			{
				$date = $infos['date'];
			}


			if ($infos['heure'] == 'null') 
			{
				$heure = $var4['heure'];
			}
			elseif ($infos['heure'] != 'null')
			{
				$heure = $infos['heure'];
			}


			if ($infos['prix'] == 'null') 
			{
				$prix = $var4['prix'];
			}
			elseif ($infos['prix'] != 'null')
			{
				$prix = $infos['prix'];
			}


			if ($infos['commentaire'] == 'null') 
			{
				$commentaire = $var4['commentaire'];
			}
			elseif ($infos['commentaire'] != 'null')
			{
				$commentaire = $infos['commentaire'];
			}

			$infoss = $infos['info'];
			
			/*$adresse1 = $infos['adresse1'];
			$adresse2 = $infos['adresse2'];
			$ville = $infos['ville'];
			$code_postal = $infos['codepostal'];

			$date = $infos['date'];
			$heure = $infos['heure'];
			$prix = $infos['prix'];
			$commentaire = $infos['commentaire'];
			$infoss = $infos['info'];*/
			
			$req_idl = $bdd-> prepare("SELECT * FROM informations WHERE id_logement = '$id_logement' ");
			$req_idl->execute();
			$idl_exist = $req_idl-> rowcount();
			//var_dump($req_idl-> fetchAll(PDO::FETCH_ASSOC));

			$req_admin = $bdd-> prepare("SELECT id_user, admin FROM membres WHERE id_user = '$id_of_user' ");
			$req_admin-> execute();
			$if_admin = $req_admin-> fetch(PDO::FETCH_ASSOC);
			//var_dump($if_admin);

			$req_user = $bdd-> prepare("SELECT id_of_user, id_logement FROM informations WHERE id_of_user = '$id_of_user' ");
			$req_user-> execute();
			$idl_info = $req_user-> fetch(PDO::FETCH_ASSOC);

			if ($infoss == 'modifier')
			{
				if ($idl_exist > 0) // si id_logement est supérieur à 0
				{
					if ($id_of_user == $idl_info['id_of_user'] OR $if_admin['admin'] == 'TRUE')
					{
						$dimension = $infos['dimension'];
						$envoi_data = $bdd-> prepare("UPDATE informations 
							SET 
							id_logement = '$id_logement', 
							adresse1 = '$adresse1', 
							adresse2 = '$adresse2', 
							ville = '$ville', 
							code_postal = '$code_postal', 
							dimension = '$dimension',
							prix = '$prix', 
							commentaire = '$commentaire', 
							date = '$date', 
							heure = '$heure' 
							WHERE id_logement = '$id_logement'");
						$envoi_data-> execute();

						$erreur = "La modification a bien été apportée !";
						
					}
					elseif ($id_of_user != $idl_info['id_of_user']) 
					{
						$erreur = "Vous n'êtes pas le créateur de ce logement !";
					}
					elseif ($if_admin['admin'] == 'FALSE')
					{
						$erreur = "Vous n'êtes pas admin !";
					}
				}
				else
				{
					$erreur = "Ce logement n'existe pas encore ! Utilisez la fonction 'envoyer' pour la créer !";
				}
			}
			elseif ($infoss == 'envoyer')
			{
				if ($idl_exist == 0)
				{
					$dimension = $infos['dimension'];
					$envoi_data = $bdd-> prepare("INSERT INTO informations (id_of_user, id_logement, adresse1, adresse2, ville, code_postal, dimension, prix, commentaire, date, heure) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$envoi_data-> execute(array($id_of_user, $id_logement, $adresse1, $adresse2, $ville, $code_postal, $dimension, $prix, $commentaire, $date, $heure));
					$erreur = "Envoi réussi !";
				}
				else
				{
					$erreur = "Ce logement existe déjà ! Utilisez la fonction 'modifier' pour modifier ce logement";
				}
			}
			elseif ($infoss == 'photo')
			{
				if ($idl_exist > 0) // si id_logement existe
				{
					$erreur = "test";
					$envoi_data = $bdd-> prepare("UPDATE informations SET pic_id_user = '$id_of_user', pic_idl = '$id_logement' WHERE id_logement = '$id_logement' ");
					$envoi_data-> execute();
					$_SESSION['envoi_photo'] = 'TRUE';
					$erreur = "Modification des infos de l'image réussie !";

				}
				elseif ($idl_exist == 0) //Si id_logement n'existe pas
				{
					$erreur = 'entrée';
					$dimension = $infos['dimension'];
					$envoi_data = $bdd-> prepare("INSERT INTO informations (id_of_user, id_logement, adresse1, adresse2, ville, code_postal, dimension, prix, commentaire, date, heure) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$envoi_data-> execute(array($id_of_user, $id_logement, $adresse1, $adresse2, $ville, $code_postal, $dimension, $prix, $commentaire, $date, $heure));
					$_SESSION['envoi_photo'] = 'TRUE';
					$erreur = "Création des infos de l'image réussie !";

				}
			}
		}

//___Envoie des données à liam__________________________________________________________________________________________

		if (isset($_REQUEST['call'])) // android.php?call={"data":"send"}  OU ?call={"data":""}
		{
			$call_liam = json_decode($_REQUEST['call'], TRUE);
			$data_liam = $call_liam['data'];

			if ($data_liam == 'send')
			{
				$var = $bdd-> query("SELECT id_logement, pseudo, ville, adresse1, adresse2, code_postal, dimension, prix, commentaire, date, heure FROM membres AS m INNER JOIN informations AS i WHERE m.id_user = i.id_of_user ORDER BY primary_key_pls_ignore");

				$var2 = $var-> fetchAll(PDO::FETCH_ASSOC);
				$var3 = json_encode($var2);
				echo '{"tabuser":' . $var3 . '}'; // utiliser substr pour enlever les crochets si besoin
			}
		}

//___Récupération de la photo de l'apart pour stockage dans info__________________________________________________________________________________________________________________

		if (isset($_FILES['uploaded_file']))
		{
			$path  = "C:/wamp64/www/Projet-BdD-square-box/fichiers/membres/photo-apart/";

			$old_target_path = $path . basename($_FILES['uploaded_file']['name']);

			$reqme = $bdd-> prepare("SELECT pic_id_user, pic_idl FROM informations AS i WHERE i.id_of_user = '$id_of_user'");
			$reqme-> execute();
			$pic_info = $reqme-> fetch(PDO::FETCH_ASSOC);
			
			$pic_id_user = $pic_info['pic_id_user'];
			$pic_idl = $pic_info['pic_idl'];

			if (isset($_SESSION['envoi_photo']) AND $_SESSION['envoi_photo'] == 'TRUE')
			{
				$new_target_path = $path . 'id:'. $pic_id_user . ' -- idl:' . $pic_idl;
				$pic_path = rename($old_target_path, $new_target_path);

				$result = move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $pic_path);
				if ($result)
				{
					$erreur = "Le fichier " . basename($_FILES['uploaded_file']['name'])." a bien été envoyé !";

					$insert_photo = $bdd-> prepare("UPDATE informations SET pic_path = '$pic_path' WHERE pic_id_user = '$pic_id'");
					$insert_photo-> execute();
					if ($insert_photo)
					{
						$erreur =  'Le chemin de la photo a bien été enrengistré !';
					}
					else
					{
						$erreur =  'Erreur dans l\'enrengistement du chemin de la photo !';
					}
				}
				else
				{
					$erreur = "Erreur dans l'envoi de la photo";
				}
				unset($_SESSION['envoi_photo']); // Détruit la variable session envoi_photo
			}			
		}

			//faire un truc pour gérer larrivée des infos : id, idl, nomfichier 
			/*$var1 = explode(" ", $_FILES['uploaded_file']['name']);

			$pic_id_user = $var1['0'];
			$pic_id_logement = $var1['1'];
			$pic_nomfichier = $var1['2'];*/
			
//__Traitement des erreurs________________________________________________________________________________________

		if (isset($erreur) AND !empty($erreur))
		{
			echo '{"erreur":"' . $erreur . '"}';
		}
	}

	//Traitement des erreurs SQL
	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error-> getMessage());
	}

?>