<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatbotSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('chatbot_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->text('message');
            $table->text('trigger_message');
            $table->integer('trigger_from')->comment('user,customer');
            $table->integer('send_after')->comment('after second');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_schedules');
    }
}
