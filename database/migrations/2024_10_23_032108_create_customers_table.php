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
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('chatbot_schedule_id')->nullable()->constrained()->onDelete('restrict')->comment('when trigger from chatbot_schedules has been reach, this field change by that chatbot_schedule_id.');
            $table->foreignId('chatbot_whatsapp_id')->nullable()->constrained()->onDelete('restrict');
            $table->string('name', 255);
            $table->string('whatsapp_number', 15)->unique();
            $table->dateTime('schedule_send_after')->nullable();
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