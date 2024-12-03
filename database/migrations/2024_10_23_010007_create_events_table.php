<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('restrict');
            $table->string('status')->comment(
                'new customer, 
                fu3, 
                fu7,
                fu14, 
                fu21, 
                fu25, 
                order, 
                awb release, 
                update awb, 
                in kurir, 
                delivered, 
                retur,
                fu3 after closing, 
                fu7 after closing, 
                fu14 after closing, 
                fu21 after closing, 
                fu25 after closing,
                order repeat, 
                awb release repeat, 
                update awb repeat, 
                in kurir repeat, 
                repeat,
                fu3 after repeat, 
                fu7 after repeat, 
                fu14 after repeat, 
                fu21 after repeat, 
                fu25 after repeat,');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}