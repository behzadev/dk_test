<?php

namespace App\Service\Validator;

use Symfony\Component\Validator\Validation;
use App\Service\Validator\AppValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ValidateSendSMS implements AppValidatorInterface
{
    /**
     * main validate method
     *
     * @param array $args
     * @return array
     */
    public function validate(array $args): array
    {
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
                'number' => $args['number'],
                'body' => $args['body'],
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
