<?php

namespace App\Service\Validator;

use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\Request;
use App\Service\Validator\AppValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ValidateSearch implements AppValidatorInterface
{
    /**
     * static property to hold $number
     *
     * @var string
     */
    protected static $number;

    /**
     * main validate method
     *
     * @param Request $request
     * @return array
     */
    public static function performOn(Request $request): array
    {
        self::$number = $request->query->get("number");

        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'number' => [
                new Assert\Regex("/^(?:98|\+98|0098|0)?9[0-9]{9}$/"),
                new Assert\NotBlank()
            ]
        ]);

        $validationResult = $validator->validate(
            [
                'number' => self::$number
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
