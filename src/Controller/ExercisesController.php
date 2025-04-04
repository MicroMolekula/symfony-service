<?php

namespace App\Controller;

use App\Entity\Exercises;
use App\Repository\ExercisesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/exercises')]
class ExercisesController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SerializerInterface $serializer
    ) {}

    #[Route('', methods: ['GET'])]
    public function index(ExercisesRepository $repo): JsonResponse
    {
        $exercises = $repo->findAll();
        return $this->json($exercises, 200, [], ['groups' => ['exercise:read']]);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Exercises $exercise): JsonResponse
    {
        return $this->json($exercise, 200, [], ['groups' => ['exercise:read']]);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $exercise = $this->serializer->deserialize(
            $request->getContent(),
            Exercises::class,
            'json',
            ['groups' => ['exercise:write']]
        );

        $this->em->persist($exercise);
        $this->em->flush();

        return $this->json($exercise, 201, [], ['groups' => ['exercise:read']]);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Exercises $exercise, Request $request): JsonResponse
    {
        $this->serializer->deserialize(
            $request->getContent(),
            Exercises::class,
            'json',
            [
                'object_to_populate' => $exercise,
                'groups' => ['exercise:write']
            ]
        );

        $this->em->flush();

        return $this->json($exercise, 200, [], ['groups' => ['exercise:read']]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Exercises $exercise): JsonResponse
    {
        $this->em->remove($exercise);
        $this->em->flush();

        return $this->json(null, 204);
    }
}