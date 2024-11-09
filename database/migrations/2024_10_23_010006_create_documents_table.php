<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chatbot_schedule_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('awb_notifier_id')->nullable()->constrained()->onDelete('restrict');
            $table->string('name', 255);
            $table->text('filepath');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
