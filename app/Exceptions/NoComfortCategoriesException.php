<?php

namespace App\Exceptions;

use Exception;

class NoComfortCategoriesException extends Exception
{
    public function render($request) {
        return response()->json([
            'message' => 'Нет категорий комфорта для этой должности',
            'error' => $this->getMessage()
        ],403);
    }
}
