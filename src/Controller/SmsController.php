<?php

namespace App\Controller;

use App\Service\SMS\SMSComposer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SmsController extends AbstractController
{
    /**
     * @Route("/sms/send", methods={"POST"}, name="sms_send")
     */
    public function send(Request $request, SMSComposer $sms)
    {
        $number = $request->query->get("number");
        $body = $request->query->get("body");

        // TODO: make validation

        $sms->send($number, $body);
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SmsController.php',
        ]);
    }
}
