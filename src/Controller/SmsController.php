<?php

namespace App\Controller;

use App\Service\SMS\SMSComposer;
use App\Service\Validator\ValidateSendSMS;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SmsController extends AbstractController
{
    /**
     * @Route("/sms/send", methods={"POST"}, name="sms_send")
     */
    public function send(Request $request, SMSComposer $sms): JsonResponse
    {
        $number = $request->query->get("number");
        $body = $request->query->get("body");

        $validate = (new ValidateSendSMS())->validate(['number' => $number, 'body' => $body]);

        if (!$validate['status'])
            return new JsonResponse($validate['body'], Response::HTTP_UNPROCESSABLE_ENTITY);

        $send = $sms->send($number, $body);

        return $this->json([
            'status' => $send ? 'success' : 'queued',
        ]);
    }
}
