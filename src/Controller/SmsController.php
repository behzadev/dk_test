<?php

namespace App\Controller;

use App\Service\SMS\SMSComposer;
use App\Service\Validator\ValidateSendSMS;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SmsController extends AbstractController
{
    /**
     * @Route("/sms/send", methods={"POST"}, name="sms_send")
     */
    public function send(Request $request, SMSComposer $sms): JsonResponse
    {
        $validate = ValidateSendSMS::performOn($request);

        if (!$validate['status']) {
            return new JsonResponse($validate['body'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $send = $sms->send(
            $request->query->get("number"),
            $request->query->get("body")
        );

        return $this->json([
            'status' => $send ? 'success' : 'queued',
        ]);
    }
}
