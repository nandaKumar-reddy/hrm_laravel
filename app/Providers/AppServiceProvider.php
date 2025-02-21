<?php

namespace App\Providers;

use App\Models\Attendance;
use App\Models\Payroll;
use App\Observers\AttendanceObserver;
use App\Observers\PayrollObserver;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
    }
}
