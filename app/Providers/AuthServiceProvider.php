<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\ChatbotSchedulePolicy;
use App\Models\ChatbotSchedule;
use App\Policies\ChatbotWhatsappPolicy;
use App\Models\ChatbotWhatsapp;
use App\Policies\CustomerPolicy;
use App\Models\Customer;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        ChatbotSchedule::class => ChatbotSchedulePolicy::class,
        ChatbotWhatsapp::class => ChatbotWhatsappPolicy::class,
        Customer::class => CustomerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
