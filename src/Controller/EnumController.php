<?php

namespace App\Controller;

use App\Enum\EnumAllergy;
use App\Enum\EnumGender;
use App\Enum\EnumInventory;
use App\Enum\EnumLevelOfTraining;
use App\Enum\EnumTarget;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/enums')]
class EnumController extends AbstractController
{
    #[Route('/genders', methods: ['GET'])]
    public function genders(): JsonResponse
    {
        $genders = [];
        foreach (EnumGender::cases() as $case) {
            $genders[] = [
                'value' => $case->value,
                'label' => $case->label(),
            ];
        }
        return $this->json($genders);
    }

    #[Route('/levels', methods: ['GET'])]
    public function levels(): JsonResponse
    {
        $levels = [];
        foreach (EnumLevelOfTraining::cases() as $case) {
            $levels[] = [
                'value' => $case->value,
                'label' => $case->getLabel(),
            ];
        }
        return $this->json($levels);
    }



    #[Route('/inventories', methods: ['GET'])]
    public function inventories(): JsonResponse
    {
        $inventories = [];
        foreach (EnumInventory::cases() as $case) {
            $inventories[] = [
                'value' => $case->value,
                'label' => $case->getLabel(),
            ];
        }
        return $this->json($inventories);
    }

    #[Route('/targets', methods: ['GET'])]
    public function targets(): JsonResponse
    {
        $targets = [];
        foreach (EnumTarget::cases() as $case) {
            $targets[] = [
                'value' => $case->value,
                'label' => $case->getLabel(),
            ];
        }
        return $this->json($targets);
    }
}