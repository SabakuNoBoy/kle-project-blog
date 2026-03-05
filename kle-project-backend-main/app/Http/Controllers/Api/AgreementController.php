<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Agreement;
use App\Http\Resources\Api\AgreementResource;

class AgreementController extends Controller
{
    public function show($slug)
    {
        $agreement = Agreement::where('slug', $slug)->firstOrFail();

        return response()->json($agreement);
    }
}
