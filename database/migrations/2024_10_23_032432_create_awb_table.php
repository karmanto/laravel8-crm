<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwbTable extends Migration
{
    public function up()
    {
        Schema::create('awbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('restrict');
            $table->foreignId('logistic_id')->constrained()->onDelete('restrict');
            $table->foreignId('awb_notifier_status_id')->nullable()->constrained('awb_notifiers')->onDelete('restrict')->comment('fill by last awb_notifiers has been send to customer');
            $table->string('awb_number', 255);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('awbs');
    }
}
