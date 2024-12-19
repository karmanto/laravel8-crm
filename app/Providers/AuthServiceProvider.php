<?php

namespace App\Providers;

use App\Models\Awb;
use App\Models\Order;
use App\Models\ChatbotSchedule;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\ChatbotWhatsappPolicy;
use App\Models\ChatbotWhatsapp;
use App\Policies\CustomerPolicy;
use App\Models\Customer;
use App\Policies\AwbPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ChatbotSchedulePolicy;

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
        ChatbotSchedule::class => ChatbotSchedulePolicy::class,
        Awb::class => AwbPolicy::class,
        Order::class => OrderPolicy::class,
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
