<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdiTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('edi_transactions');
        Schema::create('edi_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('etr_edi_id');
            $table->integer('etr_ref_id');
            $table->integer('etr_ref_id_2')->nullable();
            $table->integer('etr_ref_id_3')->nullable();
            $table->bigInteger('etr_edi_tansaction_control_number');
            $table->tinyInteger('etr_state');
            $table->string('etr_acknowledgment_code', 2)->nullable();
            $table->dateTime('etr_accepted_datetime')->nullable();
            $table->integer('etr_cancelled')->default(0);
            $table->integer('etr_cancelled_by_stf_id')->nullable();
            $table->dateTime('etr_cancelled_datetime')->nullable();
            $table->decimal('etr_total', 13, 4)->nullable();
            $table->dateTime('etr_modified')->nullable()->useCurrent();
            
            $table->timestamps();
            $table->softDeletes();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edi_transactions');
    }
}
