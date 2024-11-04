<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwbAddersTable extends Migration
{
    public function up()
    {
        Schema::create('awb_adders', function (Blueprint $table) {
            $table->id();
            $table->text('trigger_message');
            $table->text('awb_field');
            $table->text('logistic_field');
            $table->integer('trigger_from')->comment('user,customer');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('awb');
    }
}
