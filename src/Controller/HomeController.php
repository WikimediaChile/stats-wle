<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\Dashboard;

class HomeController extends Controller
{
    /**
     * @Route("/", name="stats")
     */
    public function init(Dashboard $dashboard)
    {
        $data = [
        'fotos' => $dashboard->getPhotos(),
        'total' => $dashboard->getResume()
      ];

        return $this->render('home/index.html.twig', $data);
    }
}
