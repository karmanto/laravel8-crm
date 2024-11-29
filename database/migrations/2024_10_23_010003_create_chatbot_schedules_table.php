<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatbotSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('chatbot_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->unique();
            $table->integer('time_sending')->nullable();
            $table->integer('gmt_time_sending')->nullable();
            $table->foreignId('chatbot_closing')->nullable()->constrained('chatbot_whatsapps')->onDelete('restrict');
            $table->foreignId('chatbot_repeat')->nullable()->constrained('chatbot_whatsapps')->onDelete('restrict');
            $table->text('trigger_new_customer')->nullable();
            $table->text('message_fu3')->nullable(); 
            $table->text('message_fu7')->nullable();                
            $table->text('message_fu14')->nullable();           
            $table->text('message_fu21')->nullable();              
            $table->text('message_fu25')->nullable();        
            $table->text('trigger_order')->nullable();   
            $table->text('message_update_awb')->nullable();
            $table->text('message_in_kurir')->nullable();    
            $table->text('message_delivered')->nullable();
            $table->text('message_fu3ac')->nullable();      
            $table->text('message_fu7ac')->nullable();          
            $table->text('message_fu14ac')->nullable();         
            $table->text('message_fu21ac')->nullable();           
            $table->text('message_fu25ac')->nullable();           
            $table->text('message_fu14ar')->nullable();             
            $table->text('message_fu25ar')->nullable();       
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_schedules');
    }
}
