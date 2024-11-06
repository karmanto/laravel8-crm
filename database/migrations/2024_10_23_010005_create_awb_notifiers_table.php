<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwbNotifiersTable extends Migration
{
    public function up()
    {
        Schema::create('awb_notifiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('document_id')->nullable();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->text('message');
            $table->text('trigger_awb_status')->comment('trigger from recent status of awb');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_schedules');
    }
}
