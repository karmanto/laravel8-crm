<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditFieldOnEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->after('id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->dropColumn('total_order');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
            $table->integer('total_order')->nullable()->after('status');
        });
    }
}
