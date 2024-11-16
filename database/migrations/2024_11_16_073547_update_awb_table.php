<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAwbTable extends Migration
{
    public function up()
    {
        Schema::table('awbs', function (Blueprint $table) {
            $table->dateTime('last_awb_status_date')->nullable()->after('awb_status')->comment('fill by last status update date');
            $table->renameColumn('awb_status', 'last_awb_status');
        });
    }

    public function down()
    {
        Schema::table('awbs', function (Blueprint $table) {
            $table->renameColumn('last_awb_status', 'awb_status');
            $table->dropColumn('last_awb_status_date');
        });
    }
}
