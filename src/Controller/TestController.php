<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/test', methods: ['GET'])]
    public function test(): JsonResponse
    {
        return $this->json([
            'message' => 'test',
        ], Response::HTTP_OK);
    }
}