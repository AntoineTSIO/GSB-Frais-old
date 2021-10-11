<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use PDO;
use PDOException;
use App\Entity;

class VisiteurController extends AbstractController {
    public function index(): Response
    {
        return $this->render('visiteur/index.html.twig', [
            'controller_name' => 'VisiteurController',
        ]);
    }

    public function consulterFicheFrais(Request $request): Response
    {

        try{
            $dbName = 'gsbFrais';
            $host = 'localhost';
            $utilisateur = 'gsb';
            $motDePasse = 'azerty';
            $port = '3306';
            $dns = 'mysql:host='.$host.';dbname='.$dbName.';port='.$port;
            $connection = new PDO( $dns, $utilisateur, $motDePasse);
        } catch (PDOException $e) {
            echo "connection impossible : " . $e;
            die();
        }
        
        $mois = $request->request->get('mois');
        $annee = $request->request->get('annee');
        $dateFiche = $mois . $annee;

        $requete = $connection->query('SELECT * FROM FicheFrais where mois = ' . $dateFiche );
        $FicheFrais = $requete->fetchall();

        return $this->render('visiteur/consulterFicheFrais.html.twig', [
            'ficheFrais' => $FicheFrais
        ]);
    }

    public function renseignerFicheFrais(): Response {

        $em = $this->getDoctrine()->getManager();
        $repositoryFicheFrais = $em->getRepository(Entity\Fichefrais::class);

        return $this->render('visiteur/renseignerFicheFrais.html.twig', [
            'controller_name' => 'VisiteurController',
        ]);
    }
}
