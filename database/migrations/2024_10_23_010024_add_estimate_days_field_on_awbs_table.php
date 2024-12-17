<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstimateDaysFieldOnAwbsTable extends Migration
{
    public function up()
    {
        Schema::table('awbs', function (Blueprint $table) {
            $table->integer('estimate_days')->nullable()->after('last_awb_status_date'); 
            $table->dateTime('shipment_received_date')->nullable()->after('estimate_days'); 
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('estimate_days');
            $table->dropColumn('shipment_received_date');
        });
    }
}
