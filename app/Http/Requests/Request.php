<?php
/**
 * Clase base para validación de requests
 */

namespace App\Http\Requests;

use App\Http\Request as HttpRequest;
use App\Exceptions\ValidationException;

abstract class Request
{
    protected $rules = [];
    protected $messages = [];

    /**
     * Reglas de validación
     */
    abstract protected function rules(): array;

    /**
     * Mensajes de error personalizados
     */
    protected function messages(): array
    {
        return [];
    }

    /**
     * Valida el request
     */
    public function validate(HttpRequest $request): array
    {
        $rules = $this->rules();
        $data = $request->all();
        $errors = [];

        foreach ($rules as $field => $rule) {
            $fieldRules = is_array($rule) ? $rule : explode('|', $rule);
            $value = $data[$field] ?? null;

            foreach ($fieldRules as $singleRule) {
                if (is_string($singleRule)) {
                    $this->validateRule($field, $value, $singleRule, $errors);
                }
            }
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        return $data;
    }

    /**
     * Valida una regla individual
     */
    private function validateRule(string $field, $value, string $rule, array &$errors): void
    {
        if (strpos($rule, ':') !== false) {
            [$ruleName, $ruleValue] = explode(':', $rule, 2);
        } else {
            $ruleName = $rule;
            $ruleValue = null;
        }

        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    $errors[$field][] = $this->getMessage($field, 'required') ?? "El campo {$field} es requerido";
                }
                break;

            case 'email':
                if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = $this->getMessage($field, 'email') ?? "El campo {$field} debe ser un email válido";
                }
                break;

            case 'min':
                if (!empty($value) && strlen($value) < (int)$ruleValue) {
                    $errors[$field][] = $this->getMessage($field, 'min') ?? "El campo {$field} debe tener al menos {$ruleValue} caracteres";
                }
                break;

            case 'max':
                if (!empty($value) && strlen($value) > (int)$ruleValue) {
                    $errors[$field][] = $this->getMessage($field, 'max') ?? "El campo {$field} no puede tener más de {$ruleValue} caracteres";
                }
                break;

            case 'numeric':
                if (!empty($value) && !is_numeric($value)) {
                    $errors[$field][] = $this->getMessage($field, 'numeric') ?? "El campo {$field} debe ser numérico";
                }
                break;
        }
    }

    /**
     * Obtiene un mensaje personalizado
     */
    private function getMessage(string $field, string $rule): ?string
    {
        $messages = $this->messages();
        $key = "{$field}.{$rule}";
        return $messages[$key] ?? null;
    }
}

