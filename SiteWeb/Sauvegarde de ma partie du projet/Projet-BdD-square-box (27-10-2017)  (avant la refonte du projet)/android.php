<?php

	Try
	{   
		session_start();
		//Connex  à la BdD
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options);

		/*

		$req_user = $bdd-> prepare("SELECT * FROM membres");
		$req_user-> execute();
		$user_info = $req_user-> fetchAll(PDO::FETCH_ASSOC);
		//var_dump($user_info);

		$req_infos = $bdd-> prepare("SELECT * FROM informations");
		$req_infos-> execute();
		$data_info = $req_infos-> fetchAll(PDO::FETCH_ASSOC);
		//var_dump($data_info);
		
		*/

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
					unset($value);
					break;
				}
				else
				{
					echo 'ça marche pas !';
					unset($value);
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

			/*$arraytest = array(
				array('1' => 'id','2' => 'id_of_user'),
				array('1' => 'idl','2' => 'id_logement'),
				array('1' => 'adresse1','2' => 'adresse1'),
				array('1' => 'adresse2','2' => 'adresse2'),
				array('1' => 'ville','2' => 'ville'),
				array('1' => 'codepostal','2' => 'code_postal'),
				array('1' => 'date','2' => 'date'),
				array('1' => 'heure','2' => 'heure'),
				array('1' => 'prix','2' => 'prix'),
				array('1' => 'commentaire','2' => 'commentaire') //                     faire un test avec each() (sert a renvoyer la paire clé->valeur de chque tableau ET avance le curseur d'une case)
			);

			var_dump($arraytest);
			$test_tab = array();
			foreach ($arraytest as $actual_key => $value) // utiliser un foreach (voir deux !!) a la place d'un for
			{
				global $test_var;
				$GLOBALS['test_var'] = '';
				if ($actual_key < '10')
				{
					$test_var = array();
					echo 'devrai marcher ';

					if ($infos[$value['1']] == 'null')
					{
						$actual_key['2'] = $var4['id_of_user'];
						echo $actual_key['2'];
						array_push($$GLOBALS['test_var'], $actual_key['2']);
						each($GLOBALS['test_var']);
					}
					elseif ($infos[$value['1']] != 'null')
					{
						$actual_key['2'] = $infos[$value['1']];
						echo $actual_key['2'];
						array_push($GLOBALS['test_var'], $actual_key['2']);
						each($GLOBALS['test_var']);
					}
				}
				else
				{
					echo 'break';
					break;
				}
			}
			var_dump($GLOBALS['test_var']);
			var_dump($arraytest);

			/*

			for (; $search_arr == false ; $arraytest['0']++, $arraytest['1']++) //1° instructions toujours exec au début;; 2° instru testé a chaque passage;; 3° instru exec toujours exec a la fin
			{
				
				echo 'test';

				if ($infos["'" . $arraytest['0'] . "'"] == 'null')
				{
					$arraytest['1'] = $var4['id_of_user'];
					echo $arraytest['1'] . ' ,,, ' . $arraytest['0'];
				}
				elseif ($infos[$arraytest['0']] != 'null')
				{
					$arraytest['1'] = $infos[$arraytest['0']];
					echo $arraytest['1'] . ' ,,, ' . $arraytest['0'];
				}
			
			}*/



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
			//var_dump($idl_info);

			if ($infoss == 'modifier')
			{
				if ($idl_exist > 0) // si id_logement est supérieur à 0
				{
					if ($id_of_user == $idl_info['id_of_user'] OR $if_admin['admin'] == 'TRUE')
					{
						$dimension = $infos['dimension'];
						$envoi_data = $bdd-> prepare("UPDATE informations AS i 
							SET 
							id_logement = '$id_logement', 
							adresse1 = '$adresse1', 
							adresse2 = '$adresse2', 
							ville = '$ville', 
							code_postal = '$code_postal', 
							dimension = '$dimension', 
							prix = '$prix', 
							commentaire = '$commentaire', 
							i.date = '$date', 
							i.heure = '$heure' 
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
					$envoi_data = $bdd-> prepare("INSERT INTO informations (id_of_user, id_logement, adresse1, adresse2, ville, code_postal, dimension, prix, commentaire, informations.date, informations.heure) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
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
				if ($idl_exist > 0) // si le logement existe
				{					
					$req_pic = $bdd-> prepare("SELECT pic_id_user, pic_idl, pic_path FROM informations WHERE id_of_user = ?/* AND pic_path != null*/");
					$req_pic-> execute(array($_GET['id']));
					$pic = $req_pic-> fetchAll(PDO::FETCH_ASSOC);
					//echo $nb_pic = $req_pic-> rowcount();
					//var_dump($pic);

					$envoi_data = $bdd-> prepare("UPDATE informations SET pic_id_user = '$id_of_user', pic_idl = '$id_logement' WHERE id_logement = '$id_logement' ");
					$envoi_data-> execute();
					$erreur = "Modification des infos de l'image réussie !";
				}
				elseif ($idl_exist == 0) // Si le logement n'existe pas
				{
					$dimension = $infos['dimension'];
					$envoi_data = $bdd-> prepare("INSERT INTO informations (id_of_user, id_logement, adresse1, adresse2, ville, code_postal, dimension, prix, commentaire, informations.date, informations.heure, pic_id_user, pic_idl) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$envoi_data-> execute(array($id_of_user, $id_logement, $adresse1, $adresse2, $ville, $code_postal, $dimension, $prix, $commentaire, $date, $heure, $id_of_user, $id_logement));
					$erreur = "Création des infos de l'image réussie !";
				}
			}
		}

//___Envoi des données à liam__________________________________________________________________________________________

		if (isset($_REQUEST['call'])) // android.php?call={"data":"send"}  OU ?call={"data":""}
		{
			$call_liam = json_decode($_REQUEST['call'], TRUE);
			$data_liam = $call_liam['data'];

			if ($data_liam == 'send')
			{
				$var = $bdd-> query("SELECT id_logement, pseudo, ville, adresse1, adresse2, code_postal, dimension, prix, commentaire, i.date, i.heure FROM membres AS m INNER JOIN informations AS i WHERE m.id_user = i.id_of_user ORDER BY primary_key_pls_ignore");

				$var2 = $var-> fetchAll(PDO::FETCH_ASSOC);
				$var3 = json_encode($var2);

				$req_pic = $bdd-> prepare("SELECT pic_id_user, pic_idl, pic_path FROM informations");
				$req_pic-> execute();
				$photo_path = $req_pic-> fetchAll(PDO::FETCH_ASSOC);
				$nb_of_pics = $req_pic-> rowcount();
				var_dump($photo_path);
				//var_dump($nb_of_pics);

				//$path = "http://90.42.115.48/Projet-BdD-square-box/fichiers/membres/photo_apart/";
				$path = "http://192.168.43.199/Projet-BdD-square-box/fichiers/membres/photo_apart/";
				$default = $path . 'pic_not_found.png';

				foreach ($photo_path as $actual_key => $value)
				{
					if ($actual_key < $nb_of_pics)
					{
						$str_path = explode('&#&', $value['pic_path']);
						$nb_row = count($str_path);
						//var_dump($str_path);
						//var_dump($nb_row);

						$send_img = array();
						$name_img_1 = 'url_img1_' . $actual_key;
						$name_img_2 = 'url_img2_' . $actual_key;
						$name_img_3 = 'url_img3_' . $actual_key;
						$name_img_4 = 'url_img4_' . $actual_key;

						switch ($nb_row)
						{
							case '1':
								if ($str_path['0'] == '') //si aucune photo (egal à null)
								{
									array_push($send_img, array(				//utiliser array_merge()
										$name_img_1 => $default,
										$name_img_2 => $default,
										$name_img_3 => $default,
										$name_img_4 => $default,
									));
									next($send_img);
									break;
								}
								else //si qqch dans première ligne 
								{
									array_push($send_img, array(
										$name_img_1 => $path . $str_path['0'],
										$name_img_2 => $default,
										$name_img_3 => $default,
										$name_img_4 => $default,
									));
									next($send_img);
									break;
								}

							case '2': //si y'a 2 img
								array_push($send_img, array(
									$name_img_1 => $path . $str_path['0'],
									$name_img_2 => $path . $str_path['1'],
									$name_img_3 => $default,
									$name_img_4 => $default,
								));
								next($send_img);
								break;
								
							case '3': //si y'a 3 img
								array_push($send_img, array(
									$name_img_1 => $path . $str_path['0'],
									$name_img_2 => $path . $str_path['1'],
									$name_img_3 => $path . $str_path['2'],
									$name_img_4 => $default,
								));
								next($send_img);
								break;

							case '4': //si y'a 4 img
								array_push($send_img, array(
									$name_img_1 => $path . $str_path['0'],
									$name_img_2 => $path . $str_path['1'],
									$name_img_3 => $path . $str_path['2'],
									$name_img_4 => $path . $str_path['3'],
								));
								next($send_img);
								break;
						}
					}
					else
					{
						break;
					}
					var_dump($send_img);
				}				

				/*$arr_test = array(
					array(
						'url_img1' => 'http://www.google.fr/intl/en_com/images/srpr/logo1w.png&https://upload.wikimedia.org/wikipedia/commons/7/7c/Aspect_ratio_16_9_example.jpg&http://www.google.fr/intl/en_com/images/srpr/logo1w.png&http://www.google.fr/intl/en_com/images/srpr/logo1w.png&http://www.google.fr/intl/en_com/images/srpr/logo1w.png', 
						'url_img2' => 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Aspect_ratio_16_9_example.jpg',
						'url_img3' => '' . $path . 'Contenu_BdD.png',
						'url_img4' => '' . $path . 'contenu_table_informlations.png',
						'url_img5' => '' . $path . 'favicon_no-process.png'
					),
					array(
						'url_img1' => 'http://www.google.fr/intl/en_com/images/srpr/logo1w.png',
						'url_img2' => 'http://www.google.fr/intl/en_com/images/srpr/logo1w.png',
						'url_img3' => 'http://www.google.fr/intl/en_com/images/srpr/logo1w.png',
						'url_img4' => 'http://www.google.fr/intl/en_com/images/srpr/logo1w.png',
						'url_img5' => 'http://www.google.fr/intl/en_com/images/srpr/logo1w.png',
					)
				); */

				if (!isset($send_img))
				{
					$send_img = array(
						$name_img_1 => $default,
						$name_img_2 => $default,
						$name_img_3 => $default,
						$name_img_4 => $default,
					);
				}

				$arr_json = json_encode($send_img);

				echo '{"tabuser":' . $var3 . ',"url_img":' . $arr_json . '}';
				//-------------------------------------------------------------------------
				
			}
		}

//___Récupération de la photo de l'apart pour stockage dans info__________________________________________________________________________________________________________________

		if (isset($_FILES['uploaded_file']))
		{	
			$reqme = $bdd-> prepare("SELECT pic_id_user, pic_idl, pic_path FROM informations WHERE id_logement = ?");
			$reqme-> execute(array($_GET['idl']));
			$pic_info = $reqme-> fetch(PDO::FETCH_ASSOC);

			$path  = "C:/wamp/www/Projet-BdD-square-box/fichiers/membres/photo_apart/";
			$old_target_path = $_FILES['uploaded_file']['tmp_name'];
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

			$new_target_path = $path . $img_path;
			rename($old_target_path, $new_target_path);
			$result = move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $new_target_path);


			$insert_photo = $bdd-> prepare("UPDATE informations SET pic_path = '$path_sql' WHERE id_logement = ?");
			$insert_photo-> execute(array($_GET['idl']));
			
		}
			
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