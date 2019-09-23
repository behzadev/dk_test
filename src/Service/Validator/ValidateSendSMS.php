<?php

namespace App\Service\Validator;

use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Validator\AppValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ValidateSendSMS implements AppValidatorInterface
{
    protected static $number;
    protected static $body;

    /**
     * main validate method
     *
     * @param array $args
     * @return array
     */
    public static function performOn(Request $request): array
    {
        self::$number = $request->query->get("number");
        self::$body = $request->query->get("body");

        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'number' => [
                new Assert\Regex("/^(?:98|\+98|0098|0)?9[0-9]{9}$/"),
                new Assert\NotBlank()
            ],
            'body' => [
                new Assert\Regex("/^\w+/"),
                new Assert\NotBlank()
            ]
        ]);

        $validationResult = $validator->validate(
            [
                'number' => self::$number,
                'body' => self::$body,
            ],
            $constraint
        );


        $errors = [];
        foreach ($validationResult as $res) {
            $errors[$res->getPropertyPath()] = $res->getMessage();
        }

        if (count($errors)) {
            return [
                'status' => false,
                'body' => $errors
            ];
        }

        return [
            'status' => true
        ];
    }
}
