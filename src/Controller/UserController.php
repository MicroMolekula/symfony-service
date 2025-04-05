<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use \App\Enum\EnumGender;
use \App\Enum\EnumLevelOfTraining;
use \App\Enum\EnumInventory;
use \App\Enum\EnumTarget;
#[Route('/user')]
class UserController extends AbstractController
{
    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    #[Route('/', name: 'get_user', methods: ['GET'])]
    public function getUserData(Request $request, UsersRepository $usersRepository): JsonResponse
    {
        $userId = $request->headers->get('x-user-id');

        if (!$userId) {
            return new JsonResponse(['error' => 'x-user-id header is required'], 400);
        }

        $user = $usersRepository->find($userId);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        return $this->json($user, 200, [], ['groups' => ['user_details']]);
    }

    #[Route('/', name: 'update_user', methods: ['PUT'])]
    public function updateUser(Request $request, UsersRepository $usersRepository): JsonResponse
    {
        // Получаем userId из заголовка
        $userId = $request->headers->get('x-user-id');

        if (!$userId) {
            return new JsonResponse(['error' => 'x-user-id header is required'], 400);
        }

        if (!is_numeric($userId)) {
            return new JsonResponse(['error' => 'x-user-id must be a numeric value'], 400);
        }

        // Получаем пользователя
        $user = $usersRepository->find((int)$userId);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }

        // Базовые строковые поля
        $stringFields = ['name', 'email', 'password', 'details'];
        foreach ($stringFields as $field) {
            if (isset($data[$field])) {
                $setter = 'set' . ucfirst($field);
                $user->$setter($data[$field]);
            }
        }

        // Числовые поля
        $numericFields = ['yandex_id', 'weight', 'age'];
        foreach ($numericFields as $field) {
            if (isset($data[$field])) {
                $setter = 'set' . str_replace('_', '', ucwords($field, '_'));
                $user->$setter((int)$data[$field]);
            }
        }
        if (isset($data['targetWeight'])) {
            $user->setDesiredWeight((int)$data['targetWeight']);
        }
        if (isset($data['other'])) {
            $user->setDetails((string)$data['other']);
        }
        // Поля с плавающей точкой
        if (isset($data['height'])) {
            $user->setHeight((float)$data['height']);
        }

        // Булево поле

        $user->setFilledInData((bool)"true");


        // Обработка enum полей
//        $enumFields = [
//            'sex' => EnumGender::class,
//            'form' => EnumLevelOfTraining::class,
//            'type' => EnumTarget::class,
//            'equipment' => EnumInventory::class,
//        ];
//
//        foreach ($enumFields as $field => $enumClass) {
//            if (isset($data[$field])) {
//                try {
//                    $enumValue = $enumClass::from($data[$field]);
//                    $setter = 'set' . str_replace('_', '', ucwords($field, '_'));
//                    $user->$setter($enumValue);
//                } catch (\ValueError $e) {
//                    $validValues = implode(', ', array_column($enumClass::cases(), 'value'));
//                    return new JsonResponse([
//                        'error' => "Invalid $field value",
//                        'valid_values' => $validValues
//                    ], 400);
//                }
//            }
//        }
        // Обработка enum полей
        if (isset($data['sex'])) {
            try {
                $user->setGender(EnumGender::from($data['sex']));
            } catch (\ValueError $e) {
                return $this->jsonError('gender', EnumGender::cases());
            }
        }

        if (isset($data['form'])) {
            try {
                $user->setLevelOfTraining(EnumLevelOfTraining::from($data['form']));
            } catch (\ValueError $e) {
                return $this->jsonError('level_of_training', EnumLevelOfTraining::cases());
            }
        }

        if (isset($data['type'])) {
            try {
                $user->setTarget(EnumTarget::from($data['type']));
            } catch (\ValueError $e) {
                return $this->jsonError('target', EnumTarget::cases());
            }
        }
        if (isset($data['equipment'])) {
            try {
                $user->setInventory(EnumInventory::from($data['equipment']));
            } catch (\ValueError $e) {
                return $this->jsonError('inventory', EnumInventory::cases());
            }
        }
        // Обработка массива enum'ов (inventory)
//        if (array_key_exists('inventory', $data)) {
//            if ($data['inventory'] === null) {
//                $user->setInventory(null);
//            } elseif (is_array($data['inventory'])) {
//                $inventory = [];
//                foreach ($data['inventory'] as $item) {
//                    try {
//                        $inventory[] = EnumInventory::from($item);
//                    } catch (\ValueError $e) {
//                        $validItems = implode(', ', array_column(EnumInventory::cases(), 'value'));
//                        return new JsonResponse([
//                            'error' => 'Invalid inventory value: ' . $item,
//                            'valid_values' => $validItems
//                        ], 400);
//                    }
//                }
//                $user->setInventory($inventory);
//            }
//        }

        // Валидация
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorsArray], 400);
        }

        try {
            $this->entityManager->flush();
            return new JsonResponse(true);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Failed to update user: ' . $e->getMessage()], 500);
        }
    }

    #[Route('/plans', name: 'get_user_plans', methods: ['GET'])]
    public function getUserPlans(Request $request, UsersRepository $usersRepository): JsonResponse
    {
        $userId = $request->headers->get('x-user-id');

        if (!$userId) {
            return new JsonResponse(['error' => 'x-user-id header is required'], 400);
        }

        $user = $usersRepository->find($userId);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $plans = $user->getPlans();

        return $this->json($plans, 200, [], ['groups' => ['user_plans']]);
    }

    #[Route('/messages', name: 'get_user_messages', methods: ['GET'])]
    public function getUserMessages(Request $request, UsersRepository $usersRepository): JsonResponse
    {
        $userId = $request->headers->get('x-user-id');

        if (!$userId) {
            return new JsonResponse(['error' => 'x-user-id header is required'], 400);
        }

        $user = $usersRepository->find($userId);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $messages = $user->getMessages();

        return $this->json($messages, 200, [], ['groups' => ['user_messages']]);
    }
    #[Route('/', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request, UsersRepository $usersRepository): JsonResponse
    {
        $userId = $request->headers->get('x-user-id');

        if (!$userId) {
            return new JsonResponse(['error' => 'x-user-id header is required'], 400);
        }

        $existingUser = $usersRepository->findOneBy(['id' => $userId]);
        if ($existingUser) {
            return new JsonResponse(['error' => 'User already exists'], 409);
        }

        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return new JsonResponse(['error' => 'Invalid JSON'], 400);
        }

        // Валидация обязательных полей
        $requiredFields = ['name', 'email', 'password', 'gender'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return new JsonResponse(['error' => sprintf('%s is required', $field)], 400);
            }
        }

        // Создаем пользователя
        $user = new Users();
        $user->setId($userId);
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

        // Устанавливаем yandex_id, если он предоставлен
        if (isset($data['yandex_id'])) {
            $user->setYandexId($data['yandex_id']);
        }

        try {
            // Преобразуем строку в EnumGender
            $gender = EnumGender::from($data['gender']);
            $user->setGender($gender);
        } catch (\ValueError $e) {
            $validGenders = implode(', ', array_column(EnumGender::cases(), 'value'));
            return new JsonResponse([
                'error' => 'Invalid gender value',
                'valid_values' => $validGenders
            ], 400);
        }

        // Опциональные поля
        if (isset($data['weight'])) {
            $user->setWeight($data['weight']);
        }
        if (isset($data['age'])) {
            $user->setAge($data['age']);
        }

        // Валидация
        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorsArray], 400);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json($user, 201, [], ['groups' => ['user_details']]);
    }
}
