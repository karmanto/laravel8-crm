<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('chatbot_schedule_id')->nullable()->comment('when trigger from chatbot_schedules has been reach, this field change by that chatbot_schedule_id.');
            $table->foreignId('chatbot_whatsapp_id')->nullable();
            $table->string('name', 255);
            $table->string('whatsapp_number', 15)->unique();
            $table->boolean('is_exception')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}