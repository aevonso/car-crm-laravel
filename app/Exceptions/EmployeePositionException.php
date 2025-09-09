<?php

namespace App\Exceptions;

use Exception;

class EmployeePositionException extends Exception
{
    public function render($request) {
        return response()->json([
            'message' => 'должность сотрудника не назначена или недействительна',
            'error' => $this->getMessage()
        ], 400);
    }
}
