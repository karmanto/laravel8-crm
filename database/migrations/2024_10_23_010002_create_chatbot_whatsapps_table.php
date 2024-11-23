<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatbotWhatsappsTable extends Migration
{
    public function up()
    {
        Schema::create('chatbot_whatsapps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->string('qrcode', 255)->nullable();
            $table->boolean('is_connect')->default(false);
            $table->boolean('is_active')->default(false);
            $table->string('whatsapp_number', 15);
            $table->string('whatsapp_number_linked', 15)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_whatsapps');
    }
}
