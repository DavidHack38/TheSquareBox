<?php
	$arr1 = array(array(
		'url_img1' => 'img1',
		'url_img2' => 'img2',
		'url_img3' => 'img3',
		'url_img4' => 'img4'
		));
	$arr2 = array(array(
		'url_img1_1' => 'img5',
		'url_img2_2' => 'img6',
		'url_img3_3' => 'img7',
		'url_img4_4' => 'img8'
		));
	
	$final_array = array_merge($arr1, $arr2);
	var_dump($final_array);
	echo '<hr>';
?>




<?php 
				session_start();
				//Connex  à la BdD
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO('mysql:host=127.0.0.1;dbname=Projet_Square_Box', 'Square-Box', 'raspberry', $pdo_options);

				$req_pic = $bdd-> prepare("SELECT pic_id_user, pic_idl, pic_path FROM informations");
				$req_pic-> execute();
				$photo_path = $req_pic-> fetchAll(PDO::FETCH_ASSOC);
				$nb_of_pics = $req_pic-> rowcount();

				$path = "http://192.168.43.199/Projet-BdD-square-box/fichiers/membres/photo_apart/";
				$default = $path . 'pic_not_found.png';
				$send_img = array();

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

						echo $name_img_1, $name_img_2, $name_img_3, $name_img_4;

						switch ($nb_row)
						{
							case '1':
								if ($str_path['0'] == '') //si aucune photo (egal à null)
								{
									$send_img_z = array_merge_recursive($send_img, array(				//utiliser array_merge()
										$name_img_1 => $default,
										$name_img_2 => $default,
										$name_img_3 => $default,
										$name_img_4 => $default,
									));
									next($send_img_z);
									break;
								}
								else //si qqch dans première ligne 
								{
									$send_img_z = array_merge_recursive($send_img, array(
										$name_img_1 => $path . $str_path['0'],
										$name_img_2 => $default,
										$name_img_3 => $default,
										$name_img_4 => $default,
									));
									next($send_img_z);
									break;
								}

							case '2': //si y'a 2 img
								$send_img_z = array_merge_recursive($send_img, array(
									$name_img_1 => $path . $str_path['0'],
									$name_img_2 => $path . $str_path['1'],
									$name_img_3 => $default,
									$name_img_4 => $default,
								));
								next($send_img_z);
								break;
								
							case '3': //si y'a 3 img
								$send_img_z = array_merge_recursive($send_img, array(
									$name_img_1 => $path . $str_path['0'],
									$name_img_2 => $path . $str_path['1'],
									$name_img_3 => $path . $str_path['2'],
									$name_img_4 => $default,
								));
								next($send_img_z);
								break;

							case '4': //si y'a 4 img
								$send_img_z = array_merge_recursive($send_img, array(
									$name_img_1 => $path . $str_path['0'],
									$name_img_2 => $path . $str_path['1'],
									$name_img_3 => $path . $str_path['2'],
									$name_img_4 => $path . $str_path['3'],
								));
								next($send_img_z);
								break;
						}
					}
					else
					{
						break;
					}
					var_dump($send_img_z); 
				}
				echo '<hr>';	
				var_dump($send_img_z);			



?>