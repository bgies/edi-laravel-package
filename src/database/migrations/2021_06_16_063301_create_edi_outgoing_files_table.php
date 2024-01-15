<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdiOutgoingFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edi_outgoing_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('edi_edi_type_id');
//            $table->unsignedInteger('edi_edg_id');
            $table->timestamp('edi_datetime')->useCurrent();
            $table->integer('edi_payment_agency')->nullable();
            $table->integer('edi_transaction_control_number')->nullable();
            $table->string('edi_filename')->nullable();
            $table->string('interchange_sender_id')->nullable();
            $table->string('interchange_receiver_id')->nullable();
            $table->string('application_receiver_code')->nullable();
            $table->string('application_sender_code')->nullable();
            $table->integer('edi_state')->default(0);
            $table->dateTime('edi_filedate')->nullable();
            $table->dateTime('edi_transmission_date')->nullable();
            $table->integer('edi_cancelled')->default(0);
            $table->tinyInteger('edi_acknowledged')->nullable();
            $table->integer('edi_records_parsed')->nullable();
            $table->integer('edi_records_transmitted')->nullable();
            $table->boolean('edi_test_file')->nullable()->default(0);
            
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
        Schema::dropIfExists('edi_outgoing_files');
    }
}
