<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAwbIdFieldOnEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('awb_id')->nullable()->after('id'); 
            $table->foreign('awb_id')->references('id')->on('awbs')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['awb_id']);
            $table->dropColumn('awb_id');
        });
    }
}
