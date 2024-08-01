<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Repository\PackRepository;
use App\Repository\OptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PackController extends AbstractController
{
    #[Route('/pack', name: 'app_pack')]
    public function index(Request $request, CarRepository $carRepository, PackRepository $packRepository, OptionRepository $optionRepository)
    {
        $carId = $request->query->get('id');
        $total = $request->query->get('total');


        // Récupérer les informations de la voiture depuis la base de données
        $car = $carRepository->find($carId);

        // Si la voiture n'existe pas, lever une exception ou rediriger vers une autre page
        if (!$car) {
            throw $this->createNotFoundException('The car does not exist');
        }

        // Récupérer les packs de protection et les options depuis la base de données
        $packs = $packRepository->findAll();
        $options = $optionRepository->findAll();

        return $this->render('pack/index.html.twig', [
            'car' => $car,
            'total' => $total,
            'packs' => $packs,
            'options' => $options,
        ]);
    }
}
