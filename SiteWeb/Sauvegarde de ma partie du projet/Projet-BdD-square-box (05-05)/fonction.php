<?php

function head()
{

//________________________________________________________________________________________________________________________________

	//penser à créer (ou modifier le path ci-dessous) un fichier compressé pour le css et javasript/Jquery

//________________________________________________________________________________________________________________________________

	echo '<link rel="stylesheet" type="text/css" href="fichiers/mise_en_page/perso/css/style.css">';
	echo '<link rel="stylesheet" type="text/css" href="fichiers/mise_en_page/perso/css/loader.css">';

	echo '<link rel="stylesheet" type="text/css" href="fichiers/mise_en_page/perso/css/buttonLoader.css>"';
	echo '<link rel="stylesheet" type="text/css" href="fichiers/mise_en_page/font-awesome/css/font-awesome.min.css">';
	
	echo '<script src="mise en page/perso/javascript/jquery-3.1.1.js"> </script>'; // charge la bibliothèque Jquery (version 3.1.1) 
	echo '<script src="mise en page/perso/javascript/jquery.buttonLoader.min.js"> </script>'; //utilise Jquery
	

	echo '<link rel="icon" type="image/ico" href="fichiers/images/favicon2.ico">';
	echo '<meta name="description" content="Insérer ici la description de la page">';
	echo '<meta name="category" content="Lycée, projet SIN, the square box">';
	echo '<meta name="language" content="fr">';
}