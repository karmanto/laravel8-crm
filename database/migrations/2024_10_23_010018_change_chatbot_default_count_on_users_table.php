<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeChatbotDefaultCountOnUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('chatbot_whatsapp_count')->default(2)->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('chatbot_whatsapp_count')->default(3)->change();
        });
    }
}
