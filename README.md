# TheSquareBox-Arduino
Projet de terminal STI2D-SIN 2017

![alt](</Présentation/schéma explicatif du projet.PNG>)

Qu'est-ce que c'est ?     Un télémètre (appareil de mesure de distance) connecté en wifi à un serveur web
A quoi ça sert ?          Les agents immobiliers peuvent l'utiliser pour mesurer une habitation. Ces mesures seront disponibles en ligne (voir après)

Projet composé de :
- Arduino (avec un écran tactile et un capteur de distance) : Mesurer les pièces de l'habitation et envoyer les informations sur le raspberry
- Raspberry PI : Connecté à l'arduino via une liaison série, il permet d'envoyer les mesures sur le serveur web
- Serveur web (WAMP) : Héberge un site web, afin de centraliser les mesures de plusieurs habitations (stocké sur une base de données). Le site permet de visualiser, ajouter, supprimer... les données.
- Application android : Permet de faire la même chose que le site, à quelques détails près (mais en version appli)

Le télémètre laser est une boite rectangulaire contenant l'arduino et le raspberry.
