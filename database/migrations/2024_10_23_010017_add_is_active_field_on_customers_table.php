<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveFieldOnCustomersTable extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->integer('is_active')->nullable()->after('is_exception');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
