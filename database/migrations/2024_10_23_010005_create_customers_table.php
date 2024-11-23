<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->string('name', 255);
            $table->string('whatsapp_number', 15);
            $table->integer('age');
            $table->text('address');
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
                closing, 
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
                fu14 after repeat,
                fu25 after repeat');
            $table->dateTime('status_date')->nullable();
            $table->boolean('is_exception')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}