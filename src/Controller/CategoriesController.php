<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories', name: 'app_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/generate', name: 'generate', methods: ['GET'])]
    public function generate(EntityManagerInterface $em): Response
    {
        $categories = [
            ['name' => 'Comedy'],
            ['name' => 'Drama'],
            ['name' => 'Romance']
        ];
        foreach ($categories as $category) {
            $em->persist(new Category($category['name']));
        }
        $em->flush();
        return $this->redirectToRoute('app_categories_index');
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Category $category, EntityManagerInterface $em): Response
    {
        return $this->render('categories/show.html.twig', [
            'category' => $category,
        ]);
    }
}
