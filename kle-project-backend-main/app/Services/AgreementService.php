<?php

namespace App\Services;

use App\Models\Agreement;

class AgreementService
{
    /**
     * Get a single agreement by slug.
     */
    public function findBySlug(string $slug): Agreement
    {
        try {
            return Agreement::where('slug', $slug)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to retrieve agreement: ' . $e->getMessage());
        }
    }
}
