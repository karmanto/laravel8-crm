<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeFieldOnChatbotSchedulesTable extends Migration
{
    public function up()
    {
        Schema::table('chatbot_schedules', function (Blueprint $table) {
            $table->text('message_fu3ar')->nullable()->after('message_fu25ac');
            $table->text('message_fu7ar')->nullable()->after('message_fu3ar');    
            $table->text('message_fu21ar')->nullable()->after('message_fu14ar');         
            $table->text('awb_pattern')->nullable()->after('message_fu25ar');
            $table->text('logistic_pattern')->nullable()->after('awb_pattern');
            $table->text('age_pattern')->nullable()->after('logistic_pattern');
            $table->text('address_pattern')->nullable()->after('age_pattern');
        });
    }

    public function down()
    {
        Schema::table('chatbot_schedules', function (Blueprint $table) {
            $table->dropColumn('awb_pattern');
            $table->dropColumn('logistic_pattern');
            $table->dropColumn('age_pattern');
            $table->dropColumn('address_pattern');
        });
    }
}
