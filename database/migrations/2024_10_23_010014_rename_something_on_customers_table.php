<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSomethingOnCustomersTable extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['last_event_id']);
            $table->renameColumn('last_event_id', 'last_event_trigger_id');
            $table->foreign('last_event_trigger_id')
                  ->references('id')->on('events')
                  ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign(['last_event_trigger_id']);
            $table->renameColumn('last_event_trigger_id', 'last_event_id');
            $table->foreign('last_event_id')
                  ->references('id')->on('events')
                  ->onDelete('restrict');
        });
    }
}
