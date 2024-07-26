<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pay;

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
    public function boot()
    {
        // Escucha el evento created del modelo Pay
        Pay::created(function ($pay) {
            // Actualiza el campo saldo del evento correspondiente
            $event = $pay->event;
            $event->saldo -= $pay->amount;
            $event->save();
        });
    }
}
