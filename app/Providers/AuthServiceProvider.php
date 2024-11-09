<?php

namespace App\Providers;

use App\Models\AwbAdder;
use App\Models\AwbNotifier;
use App\Models\ChatbotSchedule;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\ChatbotWhatsappPolicy;
use App\Models\ChatbotWhatsapp;
use App\Policies\CustomerPolicy;
use App\Models\Customer;
use App\Models\CustomerAdder;
use App\Policies\AwbAdderPolicy;
use App\Policies\AwbNotifierPolicy;
use App\Policies\ChatbotSchedulePolicy;
use App\Policies\CustomerAdderPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        ChatbotWhatsapp::class => ChatbotWhatsappPolicy::class,
        Customer::class => CustomerPolicy::class,
        CustomerAdder::class => CustomerAdderPolicy::class,
        AwbNotifier::class => AwbNotifierPolicy::class,
        ChatbotSchedule::class => ChatbotSchedulePolicy::class,
        AwbAdder::class => AwbAdderPolicy::class,
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
