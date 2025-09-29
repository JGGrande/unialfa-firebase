<?php

namespace App\Providers;

use Google\Cloud\Firestore\FirestoreClient;
use Illuminate\Support\ServiceProvider;

class FirestoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FirestoreClient::class, function () {
            return new FirestoreClient([
                'keyFilePath' => config('services.firestore.credentials'),
                'projectId'   => config('services.firestore.project_id'),
            ]);
        });
    }

    public function boot(): void {}
}
