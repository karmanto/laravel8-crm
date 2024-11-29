<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMessageDeliveringFieldOnChatbotSchedulesTable extends Migration
{
    public function up()
    {
        Schema::table('chatbot_schedules', function (Blueprint $table) {
            $table->text('message_delivering')->nullable()->after('total_order_pattern');
        });
    }

    public function down()
    {
        Schema::table('chatbot_schedules', function (Blueprint $table) {
            $table->dropColumn('message_delivering');
        });
    }
}
