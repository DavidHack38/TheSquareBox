<?php

	Try
	{   
		//Connex  à la BdD
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options);


		$path = "C:/wamp64/www/Projet-BdD-square-box/fichiers/arduino/";
		$scan_dir = scandir($path);
		echo 'Liste des fichiers : <br>';
		var_dump($scan_dir); // récupère et affiche tout le dossier
		$file_name = $scan_dir['0']; //prend le fichier
		echo 'fichier séléctionné : ' . $file_name;

		$contenu_file = file($path . $file_name); // renvoi un tableau de toutes les lignes du fichier
		echo '<br> <br> Contenu du fichier : <br>' . $contenu_file['0']; // affiche la première ligne du document

		$data_file = explode(' ', $contenu_file['0']);
		$tab_info = json_decode($data_file['1'], true); // décode le json
		echo '<br> <br> Variables du fichier : ';
		var_dump($tab_info);

		$id_of_user = $tab_info['id'];
		$pin = $tab_info['motdepasse'];
		$longueur_salon = $tab_info['mesurelongueursalon'] / 100; //longueur_salon en m et mesurelongueursalon en cm
		$largeur_salon = $tab_info['mesurelargeursalon'] / 100;
		$surface_salon = $tab_info['valeursurfacesalon'];

		$longueur_cuisine = $tab_info['mesurelongueurcuisine'] / 100;
		$largeur_cuisine = $tab_info['mesurelargeurcuisine'] / 100;
		$surface_cuisine = $tab_info['valeursurfacecuisine'];

		$longueur_sdb = $tab_info['mesurelongueursalledebain'] / 100;
		$largeur_sdb = $tab_info['mesurelargeursalledebain'] / 100;
		$surface_sdb = $tab_info['valeursurfacesalledebain'];

		$longueur_chambre = $tab_info['mesurelongueurchambre'] / 100;
		$largeur_chambre = $tab_info['mesurelargeurchambre'] / 100;
		$surface_chambre = $tab_info['valeursurfacechambre'];

		

//__augmenter l'incrémentation pour l'idl_________________________________________________________________________________________

		$req_num_save = $bdd-> prepare("SELECT increm_name_backup FROM mesures WHERE id_of_user = '$id_of_user'");
		$req_num_save-> execute();
		$increm_save = $req_num_save-> Fetch(PDO::FETCH_ASSOC);
		$num_file = $increm_save['increm_name_backup'] + 1;

		$req_up_num = $bdd-> prepare("UPDATE mesures SET increm_name_backup = '$num_file' WHERE id_of_user = '$id_of_user'");
		$req_up_num-> execute();

//__création de l'id de logement + le chemin de save_____________________________________________________________________________________________
		$id_logement = 'ard_' . $id_of_user;

		$id_l = $id_logement . '&n:' . $num_file;
		$path_save = $path . 'save_files/' . $file_name . '--n=' . $num_file;
		
		echo 'nom du fichier une fois archivé = ', $id_logement;

//_Requête bdd :________________________________________________________________________________________________________________________


//--Vérification du nombre d'entrées dans la bdd---------

		$req_info = $bdd-> prepare("SELECT id_of_user, id_logement FROM mesures WHERE id_of_user = '$id_of_user'");  
		$req_info-> execute();
		$info_logement = $req_info-> Fetch(PDO::FETCH_ASSOC);
		$nb_entry = $req_info-> rowcount();
		echo '<br> nombre d\'entrée dans la base de données : ' . $nb_entry;

//-- Récupération du pin du user ------------------------

		$req_pin = $bdd-> prepare("SELECT id_user, PIN, admin FROM membres WHERE id_user = '$id_of_user'");
		$req_pin-> execute();
		$pin_user = $req_pin-> Fetch(PDO::FETCH_ASSOC);

//--Comptage du nombre d'user  (s'il existe)-------------

		$req_user_exist = $bdd-> prepare("SELECT id_user FROM membres WHERE id_user = '$id_of_user'");
		$req_user_exist-> execute();
		$user_exist = $req_user_exist-> rowcount();
		echo '<br> Nombre d\'user existant dans la bdd : ' . $user_exist;


//__Vérification et upload dans la bdd ____________________________________________________________________________________________

		if ($user_exist == 1) //si l'user existe
		{
			if ($pin_user['PIN'] == $pin) //si les 2 pin correspond
			{
				if ($nb_entry == 0) // nouveau logement
				{
					$req_info_ard = $bdd-> prepare("INSERT INTO mesures (id_of_user, id_logement, longueur_salon, largeur_salon, surface_salon, longueur_cuisine, largeur_cuisine, surface_cuisine, longueur_sdb, largeur_sdb, surface_sdb, longueur_chambre, largeur_chambre, surface_chambre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$req_info_ard-> execute(array($id_of_user, $id_logement, $longueur_salon, $largeur_salon, $surface_salon, $longueur_cuisine, $largeur_cuisine, $surface_cuisine, $longueur_sdb, $largeur_sdb, $surface_sdb, $longueur_chambre, $largeur_chambre, $surface_salon));
					if ($req_info_ard)
					{
						$ren_ok = rename($path . $file_name, $path_save);
						if ($ren_ok) {$erreur =  'Création effectuée !';}
					}
				}
				elseif ($nb_entry >= 1) //logement existant
				{
					$req_info_ard = $bdd-> prepare("UPDATE mesures 
						SET 
						longueur_salon = '$longueur_salon',
						largeur_salon = '$largeur_salon',
						surface_salon = '$surface_salon',
						longueur_cuisine = '$longueur_cuisine',
						largeur_cuisine = '$largeur_cuisine',
						surface_cuisine = '$surface_cuisine',
						longueur_sdb = '$longueur_sdb',
						largeur_sdb = '$largeur_sdb',
						surface_sdb = '$surface_sdb',
						longueur_chambre = '$longueur_chambre',
						largeur_chambre = '$largeur_chambre',
						surface_chambre = '$surface_chambre'
						WHERE id_logement = '$id_l'");
					$req_info_ard-> execute();

					if ($req_info_ard) 
					{
						$ren_ok = rename($path . $file_name, $path_save);
						if ($ren_ok) {$erreur = 'modification réussie !';}
					}
				}
			}
			else
			{
				$erreur = 'Mauvais PIN !';
			}
		}
		elseif ($user_exist == 0)
		{
			$path_incorrect = $path . 'incorrect_files/';
			rename($path . $file_name, $path_incorrect);
			$erreur = 'Cet id n\'existe pas ! Le fichier a été déplacé dans le dossier "incorrect_files"';
		}


//__Traitement des erreurs________________________________________________________________________________________

		if (isset($erreur) AND !empty($erreur))
		{
			echo '<br> <br> <font color="red">' . $erreur . '</font>';
		}
	}

	//Traitement des erreurs SQL
	catch (Exception $error)
	{
		die ('Erreur MYSQL : ' . $error-> getMessage());
	}

?>