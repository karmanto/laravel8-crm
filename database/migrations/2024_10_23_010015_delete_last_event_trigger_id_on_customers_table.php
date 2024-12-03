<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteLastEventTriggerIdOnCustomersTable extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['last_event_trigger_id']);
            $table->dropColumn('last_event_trigger_id');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('last_event_trigger_id')->nullable();
            $table->foreign('last_event_trigger_id')
                  ->references('id')->on('events')
                  ->onDelete('restrict');
        });
    }
}