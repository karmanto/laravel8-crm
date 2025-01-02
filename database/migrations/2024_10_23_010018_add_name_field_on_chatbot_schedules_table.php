<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameFieldOnChatbotSchedulesTable extends Migration
{
    public function up()
    {
        Schema::table('chatbot_schedules', function (Blueprint $table) {
            $table->text('name_pattern')->nullable()->after('address_pattern');
        });
    }

    public function down()
    {
        Schema::table('chatbot_schedules', function (Blueprint $table) {
            $table->dropColumn('name_pattern');
        });
    }
}