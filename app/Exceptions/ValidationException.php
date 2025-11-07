<?php
/**
 * Excepción para errores de validación
 */

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    private $errors;

    public function __construct(array $errors = [], string $message = "Error de validación", int $code = 422)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

