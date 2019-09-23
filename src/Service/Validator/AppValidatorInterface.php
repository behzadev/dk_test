<?php

namespace App\Service\Validator;

use Symfony\Component\HttpFoundation\Request;

interface AppValidatorInterface
{
    /**
     * main validate method
     *
     * @param array $args
     * @return array
     */
    public static function performOn(Request $request): array;
}