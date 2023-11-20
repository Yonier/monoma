<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Formatos por defecto respuestas JSON
        Response::macro('error', function ($status = 400, $error = []) {
            return Response::json([
                'meta' => [
                  'success' => false,
                  'errors' => $error
                ],
                'data' => []
            ], $status);
        });
        Response::macro('success', function ($status = 200, $data = []) {
            return Response::json([
                'meta' => [
                  'success' => true,
                  'errors' => []
                ],
                'data' => $data
            ], $status);
        });
    }
}
