<?php

namespace App\Controller;

use App\Repository\SentRepository;
use App\Repository\ProviderLogRepository;
use App\Service\Validator\ValidateSearch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportController extends AbstractController
{
    /**
     * @Route("/reports", methods={"GET"}, name="report")
     *
     * @param SentRepository $sentRepository
     * @param ProviderLogRepository $providerLogRepository
     * @return Response
     */
    public function index(SentRepository $sentRepository, ProviderLogRepository $providerLogRepository): Response
    {
        return $this->render('reports/index.html.twig', [
            'countAllSent' => $sentRepository->countAll(),
            'eachProviderUsage' => $sentRepository->countForProviders(),
            'providersLog' => $providerLogRepository->getAllLog(),
            'mostTenMessageReceivers' => $sentRepository->mostTenMessageReceivers(),
        ]);
    }

    /**
     * @Route("/reports/search", methods={"POST"}, name="search")
     *
     * @param Request $request
     * @param SentRepository $sentRepository
     * @return JsonResponse
     */
    public function search(Request $request, SentRepository $sentRepository): JsonResponse
    {
        $number = $request->request->get("number");

        // TODO: implement validation

        return $this->json([
            'results' => $sentRepository->searchForNumber($number)
        ]);
    }
}
