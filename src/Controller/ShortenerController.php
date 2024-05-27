<?php

namespace App\Controller;

use App\Url\Interfaces\IUrlDecoder;
use App\Url\Interfaces\IUrlEncoder;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/shortener', name: 'app_shortener_')]
class ShortenerController extends AbstractController
{
    #[Route('/encode/{url}', name: 'encode', requirements: ['url' => '.+'], methods: ['GET'])]
    public function encode(string $url, IUrlEncoder $encoder): Response
    {
        try {
            $content = 'Code: ' . $encoder->encode($url);
            $statusCode = 200;
        } catch (InvalidArgumentException $e) {
            $content = $e->getMessage();
            $statusCode = 404;
        }

        return new Response($content, $statusCode);
    }

    #[Route('/decode/{code}', name: 'decode', requirements: ['code' => '\w{1,10}'], methods: ['GET'])]
    public function decode(string $code, IUrlDecoder $decoder): Response
    {
        try {
            $content = 'Url: ' . $decoder->decode($code);
            $statusCode = 200;
        } catch (InvalidArgumentException $e) {
            $content = $e->getMessage();
            $statusCode = 404;
        }

        return new Response($content, $statusCode);
    }
}
