<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;
use App\Repository\PackRepository;
use App\Repository\OptionRepository;
use App\Repository\UserRepository;

class PackController extends AbstractController
{
    #[Route('/pack', name: 'app_pack')]
    public function index(Request $request,UserRepository $userRepository, CarRepository $carRepository, PackRepository $packRepository, OptionRepository $optionRepository): Response
    {
        $carId = $request->query->get('id');
        $total = $request->query->get('total');
        $userId = $request->query->get('userId');
   

      
        // Récupérer les informations de la voiture depuis la base de données
        $car = $carRepository->find($carId);
        $user = $userRepository->find($userId);



        if (!$car) {
            throw $this->createNotFoundException('The car does not exist');
        }
  
        if (!$user) {
            throw $this->createNotFoundException('The user does not exist');
        }
        

        // Récupérer les packs de protection et les options depuis la base de données
        $packs = $packRepository->findAll();
        $options = $optionRepository->findAll();

        return $this->render('pack/index.html.twig', [
            'car' => $car,
            'total' => $total,
            'packs' => $packs,
            'options' => $options,
            'user' => $user,

        ]);
    }
}
