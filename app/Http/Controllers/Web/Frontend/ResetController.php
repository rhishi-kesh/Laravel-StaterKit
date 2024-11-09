<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use App\Traits\ApiResponse;

class ResetController extends Controller
{
    use ApiResponse;
    /**
     * Reset Database and Optimize Clear
     *
     * @return JsonResponse
     */
    public function RunMigrations(): JsonResponse {
        Artisan::call('migrate:fresh --seed');
        Artisan::call('optimize:clear');

        return $this->success([], 'Migrations have been Refreshed, Seeded, and Cache Cleared!', 200);
    }
}
