<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AgreementResource;
use App\Http\Responses\ApiResponse;
use App\Models\Agreement;

class AgreementController extends Controller
{
    public function __construct(private \App\Services\AgreementService $agreementService)
    {
    }

    public function show($slug)
    {
        try {
            $agreement = $this->agreementService->findBySlug($slug);
            return ApiResponse::success(new AgreementResource($agreement));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return ApiResponse::error('Agreement not found.', 404);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve agreement.', 500);
        }
    }
}
