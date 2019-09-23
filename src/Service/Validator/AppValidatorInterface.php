<?php

namespace App\Service\Validator;

interface AppValidatorInterface
{
    /**
     * main validate method
     *
     * @param array $args
     * @return array
     */
    public function validate(array $args): array;
}