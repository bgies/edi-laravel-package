<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdiRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edi_replies', function (Blueprint $table) {
            $table->id();
            $table->string('identifier', 255);
            $table->bigInteger('advantage_purchase_order_id', false, true);
            $table->bigInteger('advantage_purchase_order_detail_id', false, true);
            $table->dateTime('reply_datetime');
            $table->string('return_code', 10);            
            $table->string('message', 255);
            $table->tinyInteger('resolved', false, true)->nullable();
            $table->tinyInteger('fixed_no_resend', false, true)->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edi_replies');
    }
}
