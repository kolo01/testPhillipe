<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferentielSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = 
        [
         "10.1.1-Politique d'utilisation des mesures cryptographiques",
         "10.1.2-Gestion des clés ",
         "11.1.1-Périmètre de sécurité physique ",
         "11.1.2-Contrôles physiques des accès",
         "11.1.3-Sécurisation des bureaux, des salles et des équipements",
         "11.1.4-Protection contre les menaces extérieures et environnementales",
         "11.1.5-Travail dans les zones sécurisées",
         "11.1.6-Zones de livraison et de chargement",
         "11.2.1-Emplacement et protection du matériel",
         "11.2.2-Services généraux", 
         "11.2.3-Sécurité du câblage",
         "11.2.4-Maintenance du matériel ",
         "11.2.5-Sortie des actifs ",
         "11.2.6-Sécurité du matériel et des actifs hors des locaux ",
         "11.2.7-Mise au rebut ou recyclage sécurisé(e) du matériel ",
         "11.2.8-Matériel utilisateur laissé sans surveillance ",
         "11.2.9-Politique du bureau propre et de l'écran vide",
         "12.1.1-Procédures d'exploitation documentées", 
         "12.1.2-Gestion des changements ",
         "12.1.3-Dimensionnement ",
         "12.1.4-Séparation des environnements de développement, de test et d'exploitation ",
         "12.2.1-Mesures contre les logiciels malveillants ",
         "12.3.1-Sauvegarde des informations ",
         "12.4.1-Journalisation des événements ",
         "12.4.2-Protection de l'information journalisée",
         "12.4.3-Journaux administrateur et opérateur ",
         "12.4.4-Synchronisation des horloges ",
         "12.5.1-Installation de logiciels sur des systèmes en exploitation",
         "12.6.1-Gestion des vulnérabilités techniques", 
         "12.6.2-Restrictions liées à l'installation de logiciels ", 
         "12.7.1-Mesures relatives à l'audit des systèmes d'information ",
         "13.1.1-Contrôle des réseaux ",
         "13.1.2-Sécurité des services de réseau ",
         "13.1.3-Cloisonnement des réseaux ",
         "13.2.1-Politiques et procédures de transfert de l'information ",
         "13.2.2-Accords en matière de transfert d'information ",
         "13.2.3-Messagerie électronique ",
         "13.2.4-Engagements de confidentialité ou de non-divulgation ",
         "14.1.1-Analyse et spécification des exigences de sécurité de l'information ",
         "14.1.2-Sécurisation des services d'application sur les réseaux publics ",
         "14.1.3-Protection des transactions liées aux services d'application ",
         "14.2.1-Politique de développement sécurisé ",
         "14.2.2-Procédures de contrôle des changements apportés au système",
         "14.2.3-Revue technique des applications après changement apporté à la plateforme d'exploitation ",
         "14.2.4-Restrictions relatives aux changements apportés aux progiciels",
         "14.2.5-Principes d'ingénierie de la sécurité des systèmes ",
         "14.2.6-Environnement de développement sécurisé ",
         "14.2.7-Développement externalisé ",
         "14.2.8-Phase de test de la sécurité du système",
         "14.2.9-Test de conformité du système ",
         "14.3.1-Protection des données de test ",
         "15.1.1-Politique de sécurité de l'information dans les relations avec les fournisseurs ",
         "15.1.2-La sécurité dans les accords conclus avec les fournisseurs",
         "15.1.3-Chaine d'approvisionnement informatique",
         "15.2.1-Surveillance et revue des services des fournisseurs ",
         "15.2.2-Gestion des changements apportés dans les services des fournisseurs ",
         "16.1.1-Responsabilités et procédures ",
         "16.1.2-Signalement des événements liés à la sécurité de l'information ",
         "16.1.3-Signalement des failles liées à la sécurité de l'information ",
         "16.1.4-Appréciation des événements liés à la sécurité de l'information et prise de décision ",
         "16.1.5-Réponse aux incidents liés à la sécurité de l'information ",
         "16.1.6-Tirer des enseignements des incidents liés à la sécurité de l'information ",
         "16.1.7-Recueil de preuves",
         "17.1.1-Organisation de la continuité de la sécurité de l'information ",
         "17.1.2-Mise en œuvre de la continuité de la sécurité de l'information",
         "17.1.3-Vérifier, revoir et évaluer la continuité de la sécurité de l'information ",
         "17.2.1-Disponibilité des moyens de traitement de l'information ",
         "18.1.1-Identification de la législation et des exigences contractuelles applicables ",
         "18.1.2-Droits de propriété intellectuelle ",
         "18.1.3-Protection des enregistrements",
         "18.1.4-Protection de la vie privée et protection des données à caractère personnel ",
         "18.1.5-Réglementation relative aux mesures cryptographiques ",
         "18.2.1-Revue indépendante de la sécurité de l'information ", 
         "18.2.2-Conformité avec les politiques et les normes de sécurité ",
         "18.2.3-Examen de la conformité technique ",
         "5.1.1-Politiques de sécurité de l'information", 
         "5.1.2-Revue des politiques de sécurité de l'information", 
         "6.1.1-Fonctions et responsabilités liées à la sécurité de l'information", 
         "6.1.2-Séparation des tâches",
         "6.1.3-Relations avec les autorités",
         "6.1.4-Relations avec des groupes de travail spécialisés",
         "6.1.5-La sécurité de l'information dans la gestion de projet",
         "6.2.1-Politique en matière d'appareils mobiles",
         "6.2.2-Télétravail",
         "7.1.1-Sélection des candidats",
         "7.1.2-Termes et conditions d'embauche", 
         "7.2.1-Responsabilités de la direction",
         "7.2.2-Sensibilisation, apprentissage et formation à la sécurité de l'information",
         "7.2.3-Processus disciplinaire",
         "7.3.1-Achèvement ou modification des responsabilités associées au contrat de travail",
         "8.1.1-Inventaire des actifs",
         "8.1.2-Propriété des actifs",
         "8.1.3-Utilisation correcte des actifs", 
         "8.1.4-Restitution des actifs",
         "8.2.1-Classification des informations",
         "8.2.2-Marquage des informations",
         "8.2.3-Manipulation des actifs", 
         "8.3.1-Gestion des supports amovibles", 
         "8.3.2-Mise au rebut des supports",
         "8.3.3-Transfert physique des supports",
         "9.1.1-Politique de contrôle d'accès", 
         "9.1.2-Accès aux réseaux et aux services en réseau",
         "9.2.1-Enregistrement et désinscription des utilisateurs",
         "9.2.2-Maîtrise de la gestion des accès utilisateur",
         "9.2.3-Gestion des privilèges d'accès", 
         "9.2.4-Gestion des informations secrètes d'authentification des utilisateurs",
         "9.2.5-Revue des droits d'accès utilisateur", 
         "9.2.6-Suppression ou adaptation des droits d'accès", 
         "9.3.1-Utilisation d'informations secrètes d'authentification",
         "9.4.1-Restriction d'accès à l'information", 
         "9.4.2-Sécuriser les procédures de connexion",
         "9.4.3-Système de gestion des mots de passe", 
         "9.4.4-Utilisation de programmes utilitaires à privilèges", 
         "9.4.5-Contrôle d'accès au code source des programmes"
       ];

            $mydatas = [ "ISO 27001",
             "ISO 27002" ,
             "DUR-AD" ,
             "Hygiène 40" ,
             "PDIS",
             "CIS-C" ,
            "PSSI ETA",
            "II901"];
  
       foreach ($mydatas as $mydata) {

         //  $res = explode('-', $datas[$i]);

           DB::table('type_referentiels')->insert([

             // "num_control" => $res[0],

             // "lib_referentiel" => $res[1],
             "libelle" => $mydata,
              
             "created_at" => date('Y-m-d H:i:s')

           ]);
       }
  
    
    }
}
