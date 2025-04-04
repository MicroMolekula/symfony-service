<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/products')]
class ProductsController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SerializerInterface $serializer
    ) {}

    #[Route('', methods: ['GET'])]
    public function index(ProductsRepository $repo): JsonResponse
    {
        $products = $repo->findAll();
        return $this->json($products, 200, [], ['groups' => ['product:read']]);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Products $product): JsonResponse
    {
        return $this->json($product, 200, [], ['groups' => ['product:read']]);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $product = $this->serializer->deserialize(
            $request->getContent(),
            Products::class,
            'json'
        );

        $this->em->persist($product);
        $this->em->flush();

        return $this->json($product, 201, [], ['groups' => ['product:read']]);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Products $product, Request $request): JsonResponse
    {
        $this->serializer->deserialize(
            $request->getContent(),
            Products::class,
            'json',
            ['object_to_populate' => $product]
        );

        $this->em->flush();

        return $this->json($product, 200, [], ['groups' => ['product:read']]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Products $product): JsonResponse
    {
        $this->em->remove($product);
        $this->em->flush();

        return $this->json(null, 204);
    }
}