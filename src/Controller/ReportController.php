<?php

namespace App\Controller;

use App\Repository\SentRepository;
use App\Repository\ProviderLogRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportController extends AbstractController
{
    /**
     * @Route("/reports", methods={"GET"}, name="report")
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
}
