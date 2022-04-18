<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/', name: 'app_main')]
    #[Route('/{path}', name: 'app_main_all', requirements: ["path" => '^(?!api).*$'])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }


}
