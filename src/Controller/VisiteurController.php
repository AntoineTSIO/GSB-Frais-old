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

    public function consulter(Request $request): Response {
        
        try{
            $dbName = 'gsbFrais';
            $host = 'localhost';
            $utilisateur = 'gsb';
            $motDePasse = 'azerty';
            $port = '3306';
            $dns = 'mysql:host='.$host.';dbname='.$dbName.';port='.$port;
            $connexion = new PDO($dns,$utilisateur,$motDePasse);
        } catch (PDOException $e) {
            echo "Connexion Impossible :".$e;
            die();
        }

        $moisConsulté = $request->request->get('month');
        $requete = $connexion->query("SELECT * FROM FicheFrais WHERE mois='$moisConsulté'");
        $ficheFrais = $requete->fetchall();

        return $this->render('visiteur/consulter.html.twig', [
            'ficheFrais' => $ficheFrais
        ]);
    }

    public function renseigner(): Response {

        $em = $this->getDoctrine()->getManager();
        $repositoryFicheFrais = $em->getRepository(Entity\Fichefrais::class);

        return $this->render('visiteur/renseigner.html.twig', [
            'controller_name' => 'VisiteurController',
        ]);
    }
}
