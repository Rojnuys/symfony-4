<?php

namespace App\Controller;

use App\Entity\UrlCode;
use App\Services\Shortener\UrlCodeService;
use App\Url\Interfaces\IUrlEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shortener', name: 'app_shortener_')]
class ShortenerController extends AbstractController
{
    #[Route('/encode', name: 'encode', methods: ['POST'])]
    public function encode(Request $request, IUrlEncoder $encoder): Response
    {
        $url = $request->get('url');
        $code = $encoder->encode($url);

        return $this->redirectToRoute('app_shortener_url_code_statistic', ['code' => $code]);
    }

    #[Route('/{code}/statistic', name: 'url_code_statistic', requirements: ['code' => '\w{1,10}'], methods: ['GET'])]
    public function urlCodeStatistic(UrlCode $urlCode): Response
    {
        return $this->render('url_code/url_code.html.twig', [
            'url_code' => $urlCode
        ]);
    }

    #[Route('/statistic', name: 'user_statistic', methods: ['GET'])]
    public function userStatistic(Request $request, UrlCodeService $service)
    {
        $page = $request->query->getInt('page', 1);
        $pageSize = $request->query->getInt('pageSize', 3);

        return $this->render('url_code/url_codes.html.twig', [
            'pagination' => $service->getAllByUserWithPaginate($page, $pageSize)
        ]);
    }

    #[Route('/r/{code}', name: 'redirect', requirements: ['code' => '\w{1,10}'], methods: ['GET'])]
    public function redirectUrl(UrlCode $urlCode, UrlCodeService $service)
    {
        $service->incrementStatistic($urlCode);
        return $this->redirect($urlCode->getUrl());
    }
}
