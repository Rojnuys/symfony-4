<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_home_')]
class HomeController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('sum/{a}/{b}', name: 'sum', methods: ['GET'])]
    public function sum(float $a, float $b): Response
    {
        $c = $a + $b;
        return $this->render('home/sum.html.twig', [
            'a' => $a,
            'b' => $b,
            'c' => $c
        ]);
    }
}