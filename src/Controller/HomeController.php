<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Service\Dashboard;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function init(Dashboard $dashboard)
    {
        $data = [
        'fotos' => $dashboard->getPhotos(),
        'usuarios' => $dashboard->getUsers(),
        'total' => $dashboard->getResume()
      ];

        return $this->render('home/index.html.twig', $data);
    }

    /**
     * @Route("/user/{name}", name="user")
     */
    public function user(Dashboard $dashboard, string $name)
    {
        $data = ['name' => $name, 'photos' => $dashboard->getUserUpload($name)];
        return $this->render('home/user.html.twig', $data);
    }

    /**
     * @Route("/day/{date}", name="day", requirements={"date" = "\d{4}(-\d{2}){2}"})
     */
    public function day(Dashboard $dashboard, string $date)
    {
        $data = ['date' => $date, 'photos' => $dashboard->getDateUpload($date)];
        return $this->render('home/date.html.twig', $data);
    }
}
