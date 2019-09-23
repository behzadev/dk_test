<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportController extends AbstractController
{
    /**
     * @Route("/reports", methods={"GET"}, name="report")
     */
    public function index(EntityManagerInterface $entityManager)
    {
        return $this->render('reports/index.twig.html');
    }
}
