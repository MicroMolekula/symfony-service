<?php

namespace App\Controller;

use App\Entity\Plans;
use App\Repository\PlansRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/plans')]
class PlanController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SerializerInterface $serializer
    ) {}
    #[Route('/user/{userId}', methods: ['GET'])]
    public function getUserPlans(int $userId, PlansRepository $repo): JsonResponse
    {
        $plans = $repo->findBy(['user' => $userId]);
        return $this->json($plans, 200, [], ['groups' => ['plan:read']]);
    }
    #[Route('', methods: ['GET'])]
    public function index(PlansRepository $repo): JsonResponse
    {
        $plans = $repo->findAll();
        return $this->json($plans, 200, [], ['groups' => ['plan:read']]);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Plans $plan): JsonResponse
    {
        return $this->json($plan, 200, [], ['groups' => ['plan:read']]);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $plan = $this->serializer->deserialize($request->getContent(), Plans::class, 'json');

        $this->em->persist($plan);
        $this->em->flush();

        return $this->json($plan, 201, [], ['groups' => ['plan:read']]);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Plans $plan, Request $request): JsonResponse
    {
        $this->serializer->deserialize(
            $request->getContent(),
            Plans::class,
            'json',
            ['object_to_populate' => $plan]
        );

        $this->em->flush();

        return $this->json($plan, 200, [], ['groups' => ['plan:read']]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Plans $plan): JsonResponse
    {
        $this->em->remove($plan);
        $this->em->flush();

        return $this->json(null, 204);
    }
}