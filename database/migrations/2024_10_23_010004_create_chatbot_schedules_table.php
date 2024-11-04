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
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->text('message');
            $table->foreignId('document_id')->nullable()->constrained('documents')->onDelete('set null');
            $table->text('trigger_message');
            $table->integer('trigger_from')->comment('user,customer');
            $table->integer('send_after')->comment('after second');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_schedules');
    }
}
