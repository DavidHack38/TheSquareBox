//MODIFICATION A FAIRE :
//MODIFICATION : AJOUT CLAVIER.
//MODIFICATION : NE PAS OUBLIER AJOUTER PLUSIEURS VARIABLE POUR CALCUL SURFACE.
//MODIFICATION : PENSER A REGLER LE PROBLEME D'OPTIMISATION DU PROGRAMME,
//MODIFICATION : POUR EVITER LES PROBLEME DE RALENTISSEMENT DE L'ARDUINO,
//MODIFICATION : AVEC TOUT LES TRAITEMENTS DE CHOIX CAUSANT LES RALENTISSEMENT.
#include <stdint.h>
#include <TFTv2.h>
#include <SPI.h>
#include <SeeedTouchScreen.h>

#define PAGE_INCONNUE       -1
#define PAGE_ACCEUIL        0
#define PAGE_SALON          1
#define PAGE_CUISINE        2
#define PAGE_SALLE_DE_BAIN  3
#define PAGE_CHAMBRE        4
#define PAGE_ID             5

const int capteur = A5; 
TouchScreen ts = TouchScreen(XP, YP, XM, YM);

int PagePrecedente = PAGE_INCONNUE;
int PageCourante = PAGE_ACCEUIL;

float MesureLargeurSalon = 0;
float MesureLongueurSalon=0;
float ValeurSurfaceSalon=0;

void setup()
{
  TFT_BL_ON;
  Tft.TFTinit(); 
  Serial.begin(9600);
}

void loop()
{ 
  
   if(PageCourante != PagePrecedente)
    {
      PagePrecedente = PageCourante;
      Tft.fillRectangle(0,0,240,340,BLACK); //Nettoyage écran
      
      switch(PageCourante)
        {
          case PAGE_ACCEUIL :
            AffichagePageAcceuil();
          break;
          
          case PAGE_SALON :
            AffichagePageSalon();
          break;
          
          case PAGE_CUISINE :
            AffichagePageCuisine();
          break;
          
          case PAGE_SALLE_DE_BAIN :
            AffichagePageSalleDeBain();
          break;
          
          case PAGE_CHAMBRE :
            AffichagePageChambre();
          break;
        }
     }
     
  switch(PageCourante)
      {
        case PAGE_ACCEUIL :
          PageCourante = TraitementPageAcceuil();
        break;
        
        case PAGE_SALON :
          PageCourante = TraitementPageSalon();
        break;
        
        case PAGE_CUISINE :
          PageCourante = TraitementPageCuisine();
        break;
        
        case PAGE_SALLE_DE_BAIN :
          PageCourante = TraitementPageSalleDeBain();
        break;
        
        case PAGE_CHAMBRE :
          PageCourante = TraitementPageChambre();
        break;
      }
      
   delay(100);
   
} //Fin de Loop      
      

float microsecondsToCentimeters(long microseconds)
{
  return microseconds / 29.0 / 2.0;  
} 

float mesureDistance()
{
     long duration;
     float mesure;
     
     pinMode(capteur, OUTPUT); 
     digitalWrite(capteur, LOW);
     delayMicroseconds(2);
     digitalWrite(capteur, HIGH);
     delayMicroseconds(5);
     digitalWrite(capteur, LOW);
     pinMode(capteur, INPUT); // 
     duration = pulseIn(capteur, HIGH); //Lit la durée d'une impulsion
     
     mesure = microsecondsToCentimeters(duration);

     return mesure;
}


void AffichagePageAcceuil() /*-----------------Partie Graphique Page Aceeuil-----------------*/
{     
      Tft.drawString("Mesurer votre maison",0,5,2,YELLOW); //Intitulé
      Tft.drawHorizontalLine(0,25,240,WHITE);
      
      Tft.drawString("Mesure Salon",0,30,2,WHITE); 
      Tft.fillRectangle(10,50,50,25, GREEN); //Bouton Salon
      Tft.drawString("->",20,55,2,BLACK);
      
      Tft.drawString("Mesure Cuisine",0,80,2,WHITE);
      Tft.fillRectangle(10,100,50,25,GREEN); //Bouton Cuisine
      Tft.drawString("->",20,105,2,BLACK);
      
      Tft.drawString("Mesure Salle de bain",0,135,2,WHITE);
      Tft.fillRectangle(10,160,50,25,GREEN); //Bouton Sale de bain
      Tft.drawString("->",20,165,2,BLACK);
      
      Tft.drawString("Mesure Chambre",0,193,2,WHITE);
      Tft.fillRectangle(10,213,50,25,GREEN); //Bouton Chambre
      Tft.drawString("->",20,218,2,BLACK);  
}

int TraitementPageAcceuil()
{
  int nouvellePage = PAGE_ACCEUIL;
   
  Point ZoneTact = ts.getPoint();
  ZoneTact.x = map(ZoneTact.x, TS_MINX, TS_MAXX, 0, 240); //Zone tactile ecran
  ZoneTact.y = map(ZoneTact.y, TS_MINY, TS_MAXY, 0, 340);  

  if(ZoneTact.z > __PRESURE) //Si écran pressé alors :
    {
      if((ZoneTact.y > 50) && (ZoneTact.y < 75) && (ZoneTact.x > 10) && (ZoneTact.x < 60)) //Zone tactile Bouton Salon
        {
          nouvellePage = PAGE_SALON;
        }
      else if((ZoneTact.y > 100) && (ZoneTact.y < 125) && (ZoneTact.x > 10) && (ZoneTact.x < 60)) //Zone tactile Bouton Cuisine
        {
          nouvellePage = PAGE_CUISINE;
        }
      else if((ZoneTact.y > 160) && (ZoneTact.y < 185) && (ZoneTact.x > 10) && (ZoneTact.x < 60)) //Zone tactile Bouton Sale de Bain
        {
           nouvellePage = PAGE_SALLE_DE_BAIN;
        }
      else if((ZoneTact.y > 213) && (ZoneTact.y < 238) && (ZoneTact.x > 10) && (ZoneTact.x < 60)) //Zone tactile Bouton Chambre
        {
          nouvellePage = PAGE_CHAMBRE;
        }
    }

  return nouvellePage;
}

void AffichagePageSalon() /*-----------------Partie Graphique Page Salon-----------------*/
{
      Tft.drawString("Mesure Salon",20,15,2,YELLOW); //Intitulé
      Tft.drawHorizontalLine(0,40,240,WHITE);
      
      Tft.fillRectangle(205,10,25,25,RED); // Bouton Acceuil
      Tft.drawString("<-",205,16,2,BLACK);
      
      Tft.fillRectangle(5,75,100,30,GRAY2); //Bouton Mesure Longueur
      Tft.drawString("Mesurer",10,80,2,YELLOW);
        
      Tft.fillRectangle(5,140,100,30,GRAY2); //Bouton Mesure Largeur
      Tft.drawString("Mesurer",10,145,2,YELLOW);
      
      Tft.fillRectangle(5,200,30,30,GREEN); //Bouton Valider Surface
      Tft.drawString("->",7,207,2,BLACK);
      
      Tft.drawString("Taille Longueur :",0,50,2,WHITE);
      Tft.drawString("Taille Largeur :",0,115,2,WHITE);
      Tft.drawString("Surface total:",0,175,2,WHITE);  

      Tft.fillRectangle(120,85,160,20,BLACK);
      Tft.drawNumber(MesureLongueurSalon ,120,85,2, WHITE); //Mesure Prise Longueur
      Tft.drawString("Cm",160,85,2,WHITE); 

      Tft.fillRectangle(120,145,160,20,BLACK);
      Tft.drawNumber(MesureLargeurSalon ,120,145,2, WHITE); //Mesure Prise Largeur
      Tft.drawString("Cm",160,145,2,WHITE); 

      Tft.fillRectangle(42,209,100,20,BLACK);
      Tft.drawFloat( ValeurSurfaceSalon ,43,210,2,WHITE); 
      Tft.drawString("m",150,210,2,WHITE);
      Tft.drawNumber(2,162,205,1,WHITE);

}

int TraitementPageSalon()
{
    int nouvellePage = PAGE_SALON;

    Point ZoneTact = ts.getPoint();
    ZoneTact.x = map(ZoneTact.x, TS_MINX, TS_MAXX, 0, 240); //Zone tactile ecran
    ZoneTact.y = map(ZoneTact.y, TS_MINY, TS_MAXY, 0, 340);  

    if(ZoneTact.z > __PRESURE) //Si écran pressé :
    {
      if((ZoneTact.y > 75) && (ZoneTact.y < 105) && (ZoneTact.x > 5) && (ZoneTact.x < 105)) //Zone Bouton Mesure Longueur
        {
           Tft.drawString("Mesurer",10,80,2,GREEN);
           float MesureLongueur = mesureDistance();
           MesureLongueurSalon = MesureLongueur;

           Tft.fillRectangle(120,85,160,20,BLACK);
           Tft.drawNumber(MesureLongueur ,120,85,2, WHITE); //Mesure Prise Longueur
           Tft.drawString("Cm",160,85,2,WHITE); 
        } 

      if((ZoneTact.y > 140) && (ZoneTact.y < 170) && (ZoneTact.x > 5) && (ZoneTact.x < 105)) //Zone Bouton Mesure Largeur
        {
           Tft.drawString("Mesurer",10,145,2,GREEN);
           float MesureLargeur = mesureDistance();
           MesureLargeurSalon = MesureLargeur;

           Tft.fillRectangle(120,145,160,20,BLACK);
           Tft.drawNumber(MesureLargeurSalon ,120,145,2, WHITE); //Mesure Prise Largeur
           Tft.drawString("Cm",160,145,2,WHITE); 
         } 
         
       if((ZoneTact.y > 200) && (ZoneTact.y < 230) && (ZoneTact.x > 5) && (ZoneTact.x < 35))
         {
           Serial.println(MesureLargeurSalon);
           Serial.println(MesureLongueurSalon);
           ValeurSurfaceSalon =(((MesureLargeurSalon) * (MesureLongueurSalon))/10000);
           Tft.fillRectangle(42,209,100,20,BLACK);
           Tft.drawFloat( ValeurSurfaceSalon ,43,210,2,WHITE); 
           Tft.drawString("m",150,210,2,WHITE);
           Tft.drawNumber(2,162,205,1,WHITE);
         }

      if((ZoneTact.y > 10) && (ZoneTact.y < 35) && (ZoneTact.x > 210) && (ZoneTact.x < 235)) //Zone Bouton Acceuil
        {
          nouvellePage = PAGE_ACCEUIL;
          Tft.fillRectangle(0,0,240,340,BLACK);
        }
    }

    return nouvellePage;
  }

void AffichagePageCuisine() /*-----------------Partie Graphique Page Cuisine-----------------*/
{
      Tft.drawString("Mesure Cuisine",15,15,2,YELLOW); //Intitulé
      Tft.drawHorizontalLine(0,40,240,WHITE);
      
      Tft.fillRectangle(205,10,25,25,RED); // Bouton Acceuil
      Tft.drawString("<-",205,16,2,BLACK);
      
      Tft.fillRectangle(5,75,100,30,GRAY2); //Bouton Mesure Longueur
      Tft.drawString("Mesurer",10,80,2,YELLOW);
      
      Tft.fillRectangle(5,140,100,30,GRAY2); //Bouton Mesure Largeur
      Tft.drawString("Mesurer",10,145,2,YELLOW);
      
      Tft.fillRectangle(5,200,30,30,GREEN); //Bouton Valider Surface
      Tft.drawString("->",7,207,2,BLACK);
      
      Tft.drawString("Taille Longueur :",0,50,2,WHITE);
      Tft.drawString("Taille Largeur :",0,115,2,WHITE);
      Tft.drawString("Surface total:",0,175,2,WHITE);  
}

int TraitementPageCuisine()
{
   int nouvellePage = PAGE_CUISINE;

   return nouvellePage;
  
}

void AffichagePageSalleDeBain() /*-----------------Partie Graphique Page Salle de bain-----------------*/
{
      Tft.drawString("Mesure Salle Bain",0,14,2,YELLOW); //Intitulé
      Tft.drawHorizontalLine(0,40,240,WHITE);
      
      Tft.fillRectangle(205,10,25,25,RED); // Bouton Acceuil
      Tft.drawString("<-",205,16,2,BLACK);
      
      Tft.fillRectangle(5,75,100,30,GRAY2); //Bouton Mesure Longueur
      Tft.drawString("Mesurer",10,80,2,YELLOW);
      
      Tft.fillRectangle(5,140,100,30,GRAY2); //Bouton Mesure Largeur
      Tft.drawString("Mesurer",10,145,2,YELLOW);
      
      Tft.fillRectangle(5,200,30,30,GREEN); //Bouton Valider Surface
      Tft.drawString("->",7,207,2,BLACK);
      
      Tft.drawString("Taille Longueur :",0,50,2,WHITE);
      Tft.drawString("Taille Largeur :",0,115,2,WHITE);
      Tft.drawString("Surface total:",0,175,2,WHITE);  
}

int TraitementPageSalleDeBain()
{
   int nouvellePage = PAGE_SALLE_DE_BAIN;

    return nouvellePage;
  
}

void AffichagePageChambre() /*-----------------Partie Graphique Page Chambre-----------------*/
{
      Tft.drawString("Mesure Chambre",18,15,2,YELLOW); //Intitulé
      Tft.drawHorizontalLine(0,40,240,WHITE);
      
      Tft.fillRectangle(205,10,25,25,RED); // Bouton Acceuil
      Tft.drawString("<-",205,16,2,BLACK);
      
      Tft.fillRectangle(5,75,100,30,GRAY2); //Bouton Mesure Longueur
      Tft.drawString("Mesurer",10,80,2,YELLOW);
      
      Tft.fillRectangle(5,140,100,30,GRAY2); //Bouton Mesure Largeur
      Tft.drawString("Mesurer",10,145,2,YELLOW);
      
      Tft.fillRectangle(5,200,30,30,GREEN); //Bouton Valider Surface
      Tft.drawString("->",7,207,2,BLACK);
      
      Tft.drawString("Taille Longueur :",0,50,2,WHITE);
      Tft.drawString("Taille Largeur :",0,115,2,WHITE);
      Tft.drawString("Surface total:",0,175,2,WHITE);  
}

int TraitementPageChambre()
{
   int nouvellePage = PAGE_CHAMBRE;

    return nouvellePage;
  
}

  /*
      switch(PageCourante){
        /*----------------------PAGE ACCEUIL----------------------
        case 0 : //Page Acceuil
          AffichagePageAcceuil(); //Appel fonction partie graphique acceuil
          
          /*-----------------Partie Traitement Zone Tactile-----------------
          
          if(ZoneTact.z > __PRESURE) //Si écran pressé alors :
            {
              if((ZoneTact.y > 50) && (ZoneTact.y < 75) && (ZoneTact.x > 10) && (ZoneTact.x < 60)) //Zone tactile Bouton Salon
                {
                  PageCourante = 1;
                  Tft.fillRectangle(0,0,240,340,BLACK);
                }
              else if((ZoneTact.y > 100) && (ZoneTact.y < 125) && (ZoneTact.x > 10) && (ZoneTact.x < 60)) //Zone tactile Bouton Cuisine
                {
                  PageCourante = 2;
                  Tft.fillRectangle(0,0,240,340,BLACK);
                }
              else if((ZoneTact.y > 160) && (ZoneTact.y < 185) && (ZoneTact.x > 10) && (ZoneTact.x < 60)) //Zone tactile Bouton Sale de Bain
                {
                  PageCourante =  3;
                  Tft.fillRectangle(0,0,240,340,BLACK);
                }
              else if((ZoneTact.y > 213) && (ZoneTact.y < 238) && (ZoneTact.x > 10) && (ZoneTact.x < 60)) //Zone tactile Bouton Chambre
                {
                  PageCourante = 4;
                  Tft.fillRectangle(0,0,240,340,BLACK);
                }
            }
        break; 
        /*----------------------PAGE MESURE SALON----------------------   
        case 1 : 
          /*-----------------Partie Variable-----------------
          
          int MesureLongueurSalon;
          int MesureLargeurSalon;
          int ValeurSurfaceSalon;
          
          
          AffichagePageSalon(); //Appel fonction partie graphique salon
          
          /*-----------------Partie Mesure/Calcul/Traitement-----------------
          
          if(ZoneTact.z > __PRESURE) //Si écran pressé :
            {
              if((ZoneTact.y > 75) && (ZoneTact.y < 105) && (ZoneTact.x > 5) && (ZoneTact.x < 105)) //Zone Bouton Mesure Longueur
                {
                   Tft.drawString("Mesurer",10,80,2,GREEN);
                   long duration, MesureLongueur;
                   pinMode(capteur, OUTPUT); 
                   digitalWrite(capteur, LOW);
                   delayMicroseconds(2);
                   digitalWrite(capteur, HIGH);
                   delayMicroseconds(5);
                   digitalWrite(capteur, LOW);
                   pinMode(capteur, INPUT); // 
                   duration = pulseIn(capteur, HIGH); //Lit la durée d'une impulsion
                   MesureLongueur = microsecondsToCentimeters(duration);
                   
                   if(MesureLongueur != 0)
                     {
                       Tft.fillRectangle(120,85,160,20,BLACK);
                     }
                   Tft.drawNumber(MesureLongueur ,120,85,2, WHITE); //Mesure Prise Longueur
                   Tft.drawString("Cm",160,85,2,WHITE); 
                   MesureLongueurSalon = MesureLongueur;
                } 
    
              if((ZoneTact.y > 140) && (ZoneTact.y < 170) && (ZoneTact.x > 5) && (ZoneTact.x < 105)) //Zone Bouton Mesure Largeur
                {
                   Tft.drawString("Mesurer",10,145,2,GREEN);
                   long duration, MesureLargeur;
                   pinMode(capteur, OUTPUT); 
                   digitalWrite(capteur, LOW);
                   delayMicroseconds(2);
                   digitalWrite(capteur, HIGH);
                   delayMicroseconds(5);
                   digitalWrite(capteur, LOW);
                   pinMode(capteur, INPUT); // 
                   duration = pulseIn(capteur, HIGH); //Lit la durée d'une impulsion
                   MesureLargeur = microsecondsToCentimeters(duration);
                   
                   if(MesureLargeur != 0)
                     {
                       Tft.fillRectangle(120,145,160,20,BLACK);
                     }
                   Tft.drawNumber(MesureLargeur ,120,145,2, WHITE); //Mesure Prise Largeur
                   Tft.drawString("Cm",160,145,2,WHITE); 
                   MesureLargeurSalon = MesureLargeur;
                 } 
               if((ZoneTact.y > 200) && (ZoneTact.y < 230) && (ZoneTact.x > 5) && (ZoneTact.x < 35))
                 {
                   Serial.println(MesureLargeurSalon);
                   Serial.println(MesureLongueurSalon);
                   ValeurSurfaceSalon =(((MesureLargeurSalon) * (MesureLongueurSalon))/100);
                   if(ValeurSurfaceSalon != 0)
                      {
                        Tft.fillRectangle(42,209,40,20,BLACK);
                      }
                   Tft.drawNumber(ValeurSurfaceSalon,43,210,2,WHITE); 
                   Tft.drawString("m",75,210,2,WHITE);
                   Tft.drawNumber(2,87,205,1,WHITE);
                 }
    
              if((ZoneTact.y > 10) && (ZoneTact.y < 35) && (ZoneTact.x > 210) && (ZoneTact.x < 235)) //Zone Bouton Acceuil
                {
                  PageCourante =0;
                  Tft.fillRectangle(0,0,240,340,BLACK);
                }
            }
        break;
        /*----------------------PAGE MESURE CUISINE----------------------
        case 2 :
          
          AffichagePageCuisine(); //Appel partie graphique Cuisine
          
          Tft.fillRectangle(205,10,25,25,RED); // Bouton Acceuil
          Tft.drawString("<-",205,16,2,BLACK);
          if(ZoneTact.z > __PRESURE) //Si écran pressé alors:
            {
              if((ZoneTact.y > 10) && (ZoneTact.y < 35) && (ZoneTact.x > 210) && (ZoneTact.x < 235)) //Zone Bouton Acceuil
              {
                PageCourante =0;
                Tft.fillRectangle(0,0,240,340,BLACK);
              }
            }
        break;
        /*----------------------PAGE MESURE SALLE DE BAIN----------------------
        case 3 : 
    
          AffichagePageSalleDeBain(); //Appel partie graphique Sale De Bain
          
          Tft.fillRectangle(205,10,25,25,RED); // Bouton Acceuil
          Tft.drawString("<-",205,16,2,BLACK);
          if(ZoneTact.z > __PRESURE) //Si écran pressé alors:
            {
              if((ZoneTact.y > 10) && (ZoneTact.y < 35) && (ZoneTact.x > 210) && (ZoneTact.x < 235)) //Zone Bouton Acceuil
              {
                PageCourante =0;
                Tft.fillRectangle(0,0,240,340,BLACK);
              }
            }
        break;
        /*----------------------PAGE MESURE CHAMBRE----------------------
        case 4 :
    
          AffichagePageChambre(); //Appel partie graphique chambre
          
          Tft.fillRectangle(205,10,25,25,RED); // Bouton Acceuil
          Tft.drawString("<-",205,16,2,BLACK);
          if(ZoneTact.z > __PRESURE) //Si écran pressé alors:
            {
              if((ZoneTact.y > 10) && (ZoneTact.y < 35) && (ZoneTact.x > 210) && (ZoneTact.x < 235)) //Zone Bouton Acceuil
              {
                PageCourante =0;
                Tft.fillRectangle(0,0,240,340,BLACK);
              }
            }
        break;
       }
    }
}

*/

