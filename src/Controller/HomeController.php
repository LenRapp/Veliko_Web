<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
    // Appel à la méthode getAllStations pour récupérer les données de l'API
        $stationData = $this->getAllStations();

    // Passer les données des stations au template Twig
        return $this->render('home/index.html.twig', [
            'stations' => $stationData['records'], // On suppose que l'API retourne 'records'
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/api/stations', name: 'api_stations')]
    public function getAllStations(): array
    {
    // Création du client HTTP
        $client = HttpClient::create();

    // Appel à l'API pour récupérer les données de disponibilité des stations Vélib
        $response = $client->request('GET', 'https://opendata.paris.fr/api/records/1.0/search/?dataset=velib-disponibilite-en-temps-reel&rows=1471');

    // Retourner les données sous forme de tableau (pas en JSON directement)
        return $response->toArray();
    }
}


