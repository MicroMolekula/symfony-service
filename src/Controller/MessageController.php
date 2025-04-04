<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/messages')]
class MessageController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SerializerInterface $serializer
    ) {}
    #[Route('/user/{userId}', methods: ['GET'])]
    public function getUserMessages(int $userId): JsonResponse
    {
        $messages = $this->repo->findBy(['user' => $userId]);
        return $this->json($messages, 200, [], ['groups' => ['message:read']]);
    }
    #[Route('', methods: ['GET'])]
    public function index(MessagesRepository $repo): JsonResponse
    {
        $messages = $repo->findAll();
        return $this->json($messages, 200, [], ['groups' => ['message:read']]);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Messages $message): JsonResponse
    {
        return $this->json($message, 200, [], ['groups' => ['message:read']]);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $message = $this->serializer->deserialize($request->getContent(), Messages::class, 'json');

        $this->em->persist($message);
        $this->em->flush();

        return $this->json($message, 201, [], ['groups' => ['message:read']]);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Messages $message, Request $request): JsonResponse
    {
        $this->serializer->deserialize(
            $request->getContent(),
            Messages::class,
            'json',
            ['object_to_populate' => $message]
        );

        $this->em->flush();

        return $this->json($message, 200, [], ['groups' => ['message:read']]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Messages $message): JsonResponse
    {
        $this->em->remove($message);
        $this->em->flush();

        return $this->json(null, 204);
    }
}