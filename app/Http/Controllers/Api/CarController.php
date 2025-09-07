<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AvailableCarsRequest;
use App\Http\Resources\CarResource;
use App\Services\CarAvailabilityService;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    public function __construct(private CarAvailabilityService $carAvailabilityService) {

    }

    public function getAvailableCars(AvailableCarsRequest $request):JsonResponse {
        $availableCars = $this->carAvailabilityService->getAvailableCars(
            auth()->user()->employee,
            $request->date('start_time'),
            $request->date('end_time'),
            $request->only(['model','comfort_category', 'brand'])
        );

        return response()->json([
            'data' => CarResource::collection($availableCars)
        ]);
    }
}
