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
            $table->string('awb_number', 255);
            $table->text('last_awb_status')->nullable();
            $table->dateTime('last_awb_status_date')->nullable();
            $table->boolean('has_closed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('awbs');
    }
}
