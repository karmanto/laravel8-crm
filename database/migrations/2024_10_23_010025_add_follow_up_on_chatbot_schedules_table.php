<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFollowUpOnChatbotSchedulesTable extends Migration
{
    public function up()
    {
        Schema::table('chatbot_schedules', function (Blueprint $table) {
            $table->text('message_fu1')->nullable()->after('trigger_new_customer');
            $table->text('message_fu2')->nullable()->after('message_fu1');
        });
    }

    public function down()
    {
        Schema::table('chatbot_schedules', function (Blueprint $table) {
            $table->dropColumn('message_fu1');
            $table->dropColumn('message_fu2');
        });
    }
}
