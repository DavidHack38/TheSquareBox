<?php

function head()
{
	echo '<meta charset="UTF-8">';
	//<link rel="stylesheet" type="text/css" href="fichiers/mise en page/perso/css/style_liam.css">

//________________________________________________________________________________________________________________________________

	//penser à créer (ou modifier le path ci-dessous) un fichier compressé pour le css et javasript/Jquery

//________________________________________________________________________________________________________________________________

    echo '<link rel="stylesheet" type="text/css" href="fichiers/mise en page/perso/css/style.css">';
	echo '<link rel="stylesheet" type="text/css" href="fichiers/mise en page/perso/css/buttonLoader.css "';
	echo '<link rel="stylesheet" type="text/css" href="fichiers/mise en page/font-awesome/font-awesome.css">';
	
	echo '<script src="mise en page/perso/javascript/jquery-3.1.1.js"> </script>'; // charge la bibliothèque Jquery (version 3.1.1) 
	echo '<script src="mise en page/javascript/jquery.buttonLoader.js"> </script>'; //utilise Jquery
	

	echo '<link rel="icon" type="image/ico" href="fichiers/images/favicon2.ico">';
	echo '<meta name="description" content="Insérer ici la description de la page">';
	echo '<meta name="category" content="Lycée, projet SIN, the square box">';
	echo '<meta name="language" content="fr">';
}

function test($var1)
{
	
}
